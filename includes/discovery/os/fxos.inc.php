<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2016 Søren Friis Rosiak <sorenrosiak@gmail.com> 
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if (empty($os)) {
    if (strstr($sysDescr, 'Cisco FX-OS')) {
        $os = 'fxos';
    } elseif (preg_match('/[0-9.]+sf.(virtual|cisco)-[0-9]+/', $sysDescr)) {
        $os = 'fxos';
    }
}
