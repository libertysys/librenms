<?php

use LibreNMS\Config;
use LibreNMS\IPMI\IPMIClient;
use LibreNMS\IPMI\NodeManager;
use LibreNMS\RRD\RrdDefinition;

$ipmi_rows = dbFetchRows("SELECT * FROM sensors WHERE device_id = ? AND poller_type='ipmi'", [$device['device_id']]);

if (is_array($ipmi_rows)) {
    d_echo($ipmi_rows);

    if ($ipmi['host'] = $attribs['ipmi_hostname']) {
        $ipmi['tool'] = Config::get('ipmitool', 'ipmitool');
        $ipmi['user'] = $attribs['ipmi_username'];
        $ipmi['password'] = $attribs['ipmi_password'];
        $ipmi['type'] = $attribs['ipmi_type'];
        if (Config::get('own_hostname') == $device['hostname']) {
            $ipmi['host'] = 'localhost';
        }

        $client = new IPMIClient($ipmi['tool'], $ipmi['host'], $ipmi['user'], $ipmi['password']);
        $client->setPort(filter_var($attribs['ipmi_port'], FILTER_VALIDATE_INT) ? $attribs['ipmi_port'] : '623');

        echo 'Fetching IPMI sensor data...';

        // Check to see if we know which IPMI interface to use
        // so we dont use wrong arguments for ipmitool
        if ($ipmi['type'] != '') {
            $client->setDriver($ipmi['type']);
            $results = $client->getSensorDataRepository();
            d_echo($results);
            echo " done.\n";
        } else {
            echo " type not yet discovered.\n";
        }

        foreach ($results as $row) {
            [$desc, $value, $type, $status] = explode(',', $row);
            $desc = trim($desc, ' ');
            $ipmi_unit_type = Config::get("ipmi_unit.$type");

            // SDR records can include hexadecimal values, identified by an h
            // suffix (like "93h" for 0x93). Convert them to decimal.
            if (preg_match('/^([0-9A-Fa-f]+)h$/', $value, $matches)) {
                $value = hexdec($matches[1]);
            }

            $ipmi_sensor[$desc][$ipmi_unit_type]['value'] = $value;
            $ipmi_sensor[$desc][$ipmi_unit_type]['unit'] = $type;
        }

        $nmClient = new NodeManager($client);
        if ($nmClient->isPlatformSupported()) {
            $ipmi_unit_type = Config::get('ipmi_unit.Watts');
            foreach ($nmClient->getPowerReadings() as $nmSensorKey => $nmSensorValue) {
                $ipmi_sensor[$nmSensorKey][$ipmi_unit_type]['value'] = $nmSensorValue;
                $ipmi_sensor[$nmSensorKey][$ipmi_unit_type]['unit'] = 'Watts';
            }
        }

        foreach ($ipmi_rows as $ipmisensors) {
            echo 'Updating IPMI sensor ' . $ipmisensors['sensor_descr'] . '... ';

            $sensor_value = $ipmi_sensor[$ipmisensors['sensor_descr']][$ipmisensors['sensor_class']]['value'];
            $unit = $ipmi_sensor[$ipmisensors['sensor_descr']][$ipmisensors['sensor_class']]['unit'];

            echo "$sensor_value $unit\n";

            $rrd_name = get_sensor_rrd_name($device, $ipmisensors);
            $rrd_def = RrdDefinition::make()->addDataset('sensor', 'GAUGE', -20000, 20000);

            $fields = [
                'sensor' => $sensor_value,
            ];

            $tags = [
                'sensor_class' => $ipmisensors['sensor_class'],
                'sensor_type' => $ipmisensors['sensor_type'],
                'sensor_descr' => $ipmisensors['sensor_descr'],
                'sensor_index' => $ipmisensors['sensor_index'],
                'rrd_name' => $rrd_name,
                'rrd_def' => $rrd_def,
            ];
            data_update($device, 'ipmi', $tags, $fields);

            // FIXME warnings in event & mail not done here yet!
            dbUpdate(
                [
                    'sensor_current' => $sensor_value,
                    'lastupdate' => ['NOW()'],
                ],
                'sensors',
                'poller_type = ? AND sensor_class = ? AND sensor_id = ?',
                ['ipmi', $ipmisensors['sensor_class'], $ipmisensors['sensor_id']]
            );
        }

        unset($ipmi_sensor);
    }
}
