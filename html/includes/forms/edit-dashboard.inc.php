<?php
/* Copyright (C) 2015 Daniel Preussker, QuxLabs UG <preussker@quxlabs.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. */

/**
 * Edit Dashboards
 * @author Daniel Preussker
 * @copyright 2015 Daniel Preussker, QuxLabs UG
 * @license GPL
 * @package LibreNMS
 * @subpackage Dashboards
 */

$status    = 'error';
$message   = 'unknown error';
if (isset($_REQUEST['dashboard_id']) && isset($_REQUEST['dashboard_name'])) {
    if(dbUpdate(array('dashboard_name'=>$_REQUEST['dashboard_name']),'dashboards','user_id = ? && dashboard_id = ?',array($_SESSION['user_id'],$_REQUEST['dashboard_id']))) {
        $status  = 'ok';
        $message = 'Updated dashboard';
    }
    else {
        $message = 'ERROR: Could not update dashboard '.$_REQUEST['dashboard_id'];
    }
}
else {
    $message = 'ERROR: Not enough params';
}

die(json_encode(array(
    'status'       => $status,
    'message'      => $message,
)));

