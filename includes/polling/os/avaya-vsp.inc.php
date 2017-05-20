<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2016 Neil Lathwood <neil@lathwood.co.uk>
 * Copyright (c) 2016 Daniel Cox <danielcoxman@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

// rcSysVersion
$version  = snmp_get($device, 'rcSysVersion.0', '-Osqv', 'RAPID-CITY');
$version = explode(' ', $version);
$version = $version[0];
$version = str_replace('"', '', $version);

// rcChasSerialNumber
$serial   = snmp_get($device, 'rcChasSerialNumber.0', '-Osqv', 'RAPID-CITY');
$serial = str_replace('"', '', $serial);

// Appended Hard revision to serial number
$hwrevision = snmp_get($device, 'rcChasHardwareRevision.0', '-Osqv', 'RAPID-CITY');
$hwrevision = str_replace('"', '', $hwrevision);
$serial = $serial . " HW:$hwrevision";
