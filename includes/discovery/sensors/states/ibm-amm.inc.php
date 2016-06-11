<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2016 Neil Lathwood <neil@lathwood.co.uk>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'ibm-amm') {

    $index = 1;
    $oids = array(
        'blower1State' => '.1.3.6.1.4.1.2.3.51.2.2.3.10.0',
        'blower2State' => '.1.3.6.1.4.1.2.3.51.2.2.3.11.0',
        'blower3State' => '.1.3.6.1.4.1.2.3.51.2.2.3.12.0',
        'blower4State' => '.1.3.6.1.4.1.2.3.51.2.2.3.13.0'
    );

    foreach ($oids as $state_name => $oid) {

        $state = snmp_get($device, $oid, '-Oqv');
        if (!empty($state)) {

            $state_index_id = create_state_index($state_name);
            
            if ($state_index_id) {

                $states = array(
                    array($state_index_id,'unknown',0,1,3) ,
                    array($state_index_id,'good',1,2,0) ,
                    array($state_index_id,'warning',1,3,1) ,
                    array($state_index_id,'bad',1,4,2) ,
                );
 
                foreach($states as $value) { 
                    $insert = array(
                        'state_index_id' => $value[0],
                        'state_descr' => $value[1],
                        'state_draw_graph' => $value[2],
                        'state_value' => $value[3],
                        'state_generic_value' => $value[4]
                    );
                    dbInsert($insert, 'state_translations');
                }//end foreach

            }//end if

            discover_sensor($valid['sensor'], 'state', $device, $oid, $index, $state_name, $state_name, '1', '1', null, null, null, null, $state, 'snmp', $index);
            //Create Sensor To State Index
            create_sensor_to_state_index($device, $state_name, $index);
            $index++;

        }//end if

    }//end foreach

    $index = 1;
    $oids = array(
        'blower1ControllerState' => '.1.3.6.1.4.1.2.3.51.2.2.3.30.0',
        'blower2ControllerState' => '.1.3.6.1.4.1.2.3.51.2.2.3.31.0',
        'blower3ControllerState' => '.1.3.6.1.4.1.2.3.51.2.2.3.32.0',
        'blower4ControllerState' => '.1.3.6.1.4.1.2.3.51.2.2.3.33.0');

    foreach ($oids as $state_name => $oid) {

        $state = snmp_get($device, $oid, '-Oqv');

        if (is_numeric($state) && $state != 2) {

            $state_index_id = create_state_index($state_name);

            if ($state_index_id) {

                $states = array(
                    array($state_index_id,'operational',0,0,0),
                    array($state_index_id,'flashing',1,1,1),
                    array($state_index_id,'notPresent',1,2,2),
                    array($state_index_id,'communicationError',1,3,2),
                    array($state_index_id,'unknown',1,4,2),
                );

                foreach($states as $value) {
                    $insert = array(
                        'state_index_id' => $value[0],
                        'state_descr' => $value[1],
                        'state_draw_graph' => $value[2],
                        'state_value' => $value[3],
                        'state_generic_value' => $value[4]
                    );
                    dbInsert($insert, 'state_translations');
                }//end foreach

            }//end if

            discover_sensor($valid['sensor'], 'state', $device, $oid, $index, $state_name, $state_name, '1', '1', null, null, null, null, $state, 'snmp', $index);
            //Create Sensor To State Index
            create_sensor_to_state_index($device, $state_name, $index);
            $index++;

        }//end if

    }//end foreach

}//end if
