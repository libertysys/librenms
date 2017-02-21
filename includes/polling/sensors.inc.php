<?php
/*
 * LibreNMS Network Management and Monitoring System
 * Copyright (C) 2006-2011, Observium Developers - http://www.observium.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See COPYING for more details.
 */

$sensors = dbFetchRows("SELECT `sensor_class` FROM `sensors` WHERE `device_id` = ? GROUP BY `sensor_class`", array($device['device_id']));
foreach ($sensors as $sensor_type) {
    poll_sensor($device, $sensor_type['sensor_class']);
}

unset($sensors, $sensor_type);
