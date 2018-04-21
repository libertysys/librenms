<?php
/**
 * ack-alert.inc.php
 *
 * LibreNMS ack-alert.inc.php
 *
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2018 Neil Lathwood
 * @author     Neil Lathwood <gh+n@laf.io>
 */

use LibreNMS\Config;

header('Content-type: application/json');

$alert_id = $vars['alert_id'];
$state    = $vars['state'];
$ack_msg  = $vars['ack_msg'];

$status = 'error';

if (!is_numeric($alert_id)) {
    $message = 'No alert selected';
} elseif (!is_numeric($state)) {
    $message = 'No state passed';
} else {
    if ($state == 2) {
        $state = 1;
        $open  = 1;
    } elseif ($state >= 1) {
        $state = 2;
        $open  = 1;
    }

    $data = ['state' => $state, 'open' => $open];
    if (!empty($ack_msg)) {
        $data['note'] = date(Config::get('dateformat.long')) . " - Ack ({$_SESSION['username']}) $ack_msg";
    }

    if (dbUpdate($data, 'alerts', 'id=?', array($alert_id)) >= 0) {
        if ($state === 2) {
            $alert_info = dbFetchRow("SELECT `alert_rules`.`name`,`alerts`.`device_id` FROM `alert_rules` LEFT JOIN `alerts` ON `alerts`.`rule_id` = `alert_rules`.`id` WHERE `alerts`.`id` = ?", [$alert_id]);
            log_event("{$_SESSION['username']} acknowledged alert {$alert_info['name']}", $alert_info['device_id'], 'alert', 2, $alert_id);
        }
        $message = 'Alert acknowledged status changed.';
        $status  = 'ok';
    } else {
        $message = 'Alert has not been acknowledged.';
    }
}//end if

die(json_encode([
    'status'       => $status,
    'message'      => $message,
]));
