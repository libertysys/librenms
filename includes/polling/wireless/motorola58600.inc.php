<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

use LibreNMS\RRD\RrdDefinition;

$transmitPower = snmp_get($device, "transmitPower.0", "-Ovqn", "CANOPY-SYS-MIB");
if (is_numeric($transmitPower)) {
    $rrd_def = RrdDefinition::make()->addDataset('transmitPower', 'GAUGE', 0, 100);
    $fields = array(
        'transmitPower' => $transmitPower / 10,
    );

    $tags = compact('rrd_def');
    data_update($device, 'motorola58600-transmitPower', $tags, $fields);
    $graphs['cambium_250_transmitPower'] = true;
}

$receivePower = snmp_get($device, "receivePower.0", "-Ovqn", "CANOPY-SYS-MIB");
$noiseFloor = snmp_get($device, "noiseFloor.0", "-Ovqn", "CANOPY-SYS-MIB");
if (is_numeric($receivePower)) {
    $rrd_def = RrdDefinition::make()
        ->addDataset('receivePower', 'GAUGE', -150, 0)
        ->addDataset('noiseFloor', 'GAUGE', -150, 0);
    $fields = array(
        'receivePower' => $receivePower / 10,
        'noiseFloor' => $noiseFloor,
    );

    $tags = compact('rrd_def');
    data_update($device, 'motorola58600-receivePower', $tags, $fields);
    $graphs['cambium_250_receivePower'] = true;
}

$txModulation = snmp_get($device, "transmitModulationMode.0", "-Ovqn", "CANOPY-SYS-MIB");
$rxModulation = snmp_get($device, "receiveModulationMode.0", "-Ovqn", "CANOPY-SYS-MIB");
if (is_numeric($txModulation) && is_numeric($rxModulation)) {
    $rrd_def = RrdDefinition::make()
        ->addDataset('txModulation', 'GAUGE', 0, 24)
        ->addDataset('rxModulation', 'GAUGE', 0, 24);
    $fields = array(
        'txModuation' => $txModulation,
        'rxModulation' => $rxModulation,
    );

    $tags = compact('rrd_def');
    data_update($device, 'motorola58600-modulationMode', $tags, $fields);
    $graphs['cambium_250_modulationMode'] = true;
}

$receiveDataRate = snmp_get($device, "receiveDataRate.0", "-Ovqn", "CANOPY-SYS-MIB");
$transmitDataRate = snmp_get($device, "transmitDataRate.0", "-Ovqn", "CANOPY-SYS-MIB");
$aggregateDataRate = snmp_get($device, "aggregateDataRate.0", "-Ovqn", "CANOPY-SYS-MIB");
if (is_numeric($receiveDataRate) && is_numeric($transmitDataRate) && is_numeric($aggregateDataRate)) {
    $rrd_def = RrdDefinition::make()
        ->addDataset('receiveDataRate', 'GAUGE', 0, 10000)
        ->addDataset('transmitDataRate', 'GAUGE', 0, 10000)
        ->addDataset('aggregateDataRate', 'GAUGE', 0, 10000);
    $fields = array(
        'receiveDataRate' => $receiveDataRate / 100,
        'transmitDataRate' => $transmitDataRate / 100,
        'aggregateDataRate' => $aggregateDataRate / 100,
    );

    $tags = compact('rrd_def');
    data_update($device, 'motorola58600-dataRate', $tags, $fields);
    $graphs['cambium_250_dataRate'] = true;
}

$ssr = snmp_get($device, "signalStrengthRatio.0", "-Ovqn", "CANOPY-SYS-MIB");
if (is_numeric($ssr)) {
    $rrd_def = RrdDefinition::make()->addDataset('ssr', 'GAUGE', -150, 150);
    $fields = array(
        'ssr' => $ssr,
    );

    $tags = compact('rrd_def');
    data_update($device, 'motorola58600-ssr', $tags, $fields);
    $graphs['cambium_250_ssr'] = true;
}
