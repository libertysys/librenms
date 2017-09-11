<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2017 Aldemir Akpinar <https://github.com/aldemira/>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */
header('Content-type: application/json');

if (is_admin() === false) {
    die('ERROR: You need to be admin');
}

if (!is_numeric($_POST['device_id'])) {
    echo 'ERROR: Wrong device id!';
    exit;
} else {
    $device_deps = dbFetchRows('SELECT device_id, hostname from devices WHERE device_id ` <>  ?', array($_POST['device_id']));
    echo json_encode($device_deps, true);
}
