<?php
/*
 * LibreNMS Moxa EtherDevice RAM discovery module
 *
 * Copyright (c) 2017 Aldemir Akpinar <aldemir.akpinar@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'moxa-etherdevice') {
    echo 'Moxa EtherDevice';

    // Moxa people enjoy creating similar MIBs for each model!
    if ($device['sysDescr'] == 'IKS-6726A-2GTXSFP-T') {
        $mibmod = 'MOXA-IKS6726A-MIB';
    } else if ($device['sysDescr'] == 'EDS-G508E-T') {
        $mibmod = 'MOXA-EDSG508E-MIB';
    }

    $total = snmp_get($device, "totalMemory.0", '-OvQ', $mibmod);
    $avail = snmp_get($device, "freeMemory.0", '-OvQ', $mibmod);

    if ((is_numeric($total)) && (is_numeric($avail))) {
        discover_mempool($valid_mempool, $device, 0, 'moxa-etherdevice-mem', 'Memory', '1', null, null);
    }
}
