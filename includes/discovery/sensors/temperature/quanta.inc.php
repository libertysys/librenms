<?php
/*
 * LibreNMS Quanta LB6M Temperature information module
 *
 * Copyright (c) 2017 Mark Guzman <segfault@hasno.info>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

d_echo('Quanta Temperatures');
$sensor_type = 'quanta_temp';
$sensors_id_oid = 'boxServicesTempSensorState';
$sensors_values = snmpwalk_cache_multi_oid($device, $sensors_id_oid, array(), 'NETGEAR-BOXSERVICES-PRIVATE-MIB');
$numeric_oid_base = '.1.3.6.1.4.1.4413.1.1.43.1.8.1.4';

foreach ($sensors_values as $index => $entry) {
    $current_value = $entry[$sensors_id_oid];
    $descr = "Temperature $index:";
    
    if ($current_value > 0) {
        discover_sensor($valid['sensor'], 'temperature', $device, $numeric_oid_base .'.'. $index, $index, $sensor_type, $descr, 1, 1, null, null, null, null, $current_value);
    }
}
