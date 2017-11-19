<?php
/*
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage graphs
 * @link       http://librenms.org
 * @copyright  2017 LibreNMS
 * @author     LibreNMS Contributors
*/

require_once $config['install_dir'] . '/includes/device-groups.inc.php';

$where = ' `devices`.`disabled` = 0';

$alert_states = array(
    // divined from librenms/alerts.php
    'recovered' => 0,
    'alerted' => 1,
    'acknowledged' => 2,
    'worse' => 3,
    'better' => 4,
);

$alert_severities = array(
    // alert_rules.status is enum('ok','warning','critical')
    'ok' => 1,
    'warning' => 2,
    'critical' => 3,
    'ok only' => 4,
    'warning only' => 5,
    'critical only' => 6,
);

$show_recovered = false;

if (is_numeric($_POST['device_id']) && $_POST['device_id'] > 0) {
    $where .= ' AND `alerts`.`device_id`=' . $_POST['device_id'];
}

if (is_numeric($_POST['acknowledged'])) {
    // I assume that if we are searching for acknowleged/not, we aren't interested in recovered
    $where .= " AND `alerts`.`state`" . ($_POST['acknowledged'] ? "=" : "!=") . $alert_states['acknowledged'];
}

if (is_numeric($_POST['state'])) {
    $where .= " AND `alerts`.`state`=" . $_POST['state'];
    if ($_POST['state'] == $alert_states['recovered']) {
        $show_recovered = true;
    }
}

if (isset($_POST['min_severity'])) {
    if (is_numeric($_POST['min_severity'])) {
        $min_severity_id = $_POST['min_severity'];
    } elseif (!empty($_POST['min_severity'])) {
        $min_severity_id = $alert_severities[$_POST['min_severity']];
    }
    if (isset($min_severity_id)) {
        $where .= " AND `alert_rules`.`severity` " . ($min_severity_id > 3 ? "" : ">") . "= " . ($min_severity_id > 3 ? $min_severity_id - 3 : $min_severity_id);
    }
}

if (is_numeric($_POST['group'])) {
    $where .= " AND devices.device_id IN (SELECT `device_id` FROM `device_group_device` WHERE `device_group_id` = ?)";
    $param[] = $_POST['group'];
}

if (!$show_recovered) {
    $where .= " AND `alerts`.`state`!=" . $alert_states['recovered'];
}

if (isset($searchPhrase) && !empty($searchPhrase)) {
    $where .= " AND (`timestamp` LIKE '%$searchPhrase%' OR `rule` LIKE '%$searchPhrase%' OR `name` LIKE '%$searchPhrase%' OR `hostname` LIKE '%$searchPhrase%')";
}

$sql = ' FROM `alerts` LEFT JOIN `devices` ON `alerts`.`device_id`=`devices`.`device_id`';

if (is_admin() === false && is_read() === false) {
    $sql .= ' LEFT JOIN `devices_perms` AS `DP` ON `devices`.`device_id` = `DP`.`device_id`';
    $where .= ' AND `DP`.`user_id`=?';
    $param[] = $_SESSION['user_id'];
}

$sql .= "  RIGHT JOIN `alert_rules` ON `alerts`.`rule_id`=`alert_rules`.`id` WHERE $where";

$count_sql = "SELECT COUNT(`alerts`.`id`) $sql";
$total = dbFetchCell($count_sql, $param);
if (empty($total)) {
    $total = 0;
}

if (!isset($sort) || empty($sort)) {
    $sort = 'timestamp DESC';
}

$sql .= " ORDER BY $sort";

if (isset($current)) {
    $limit_low = (($current * $rowCount) - ($rowCount));
    $limit_high = $rowCount;
}

if ($rowCount != -1) {
    $sql .= " LIMIT $limit_low,$limit_high";
}

$sql = "SELECT `alerts`.*, `devices`.`hostname`, `devices`.`sysName`, `devices`.`hardware`, `devices`.`location`, `alert_rules`.`rule`, `alert_rules`.`name`, `alert_rules`.`severity` $sql";

$rulei = 0;
$format = $_POST['format'];
foreach (dbFetchRows($sql, $param) as $alert) {
    $log = dbFetchCell('SELECT details FROM alert_log WHERE rule_id = ? AND device_id = ? ORDER BY id DESC LIMIT 1', array($alert['rule_id'], $alert['device_id']));
    $fault_detail = alert_details($log);

    $alert_to_ack = '<i class="command-ack-alert fa fa-eye" style="font-size:20px;" aria-hidden="true" title="MARK AS ACKNOWLEDGED" data-target="ack-alert" data-state="' . $alert['state'] . '" data-alert_id="' . $alert['id'] . '" name="ack-alert"></i>';
    $alert_to_nack = '<i class="command-ack-alert fa fa-eye-slash" style="font-size:20px;" aria-hidden="true" title="MARK AS NOT ACKNOWLEDGED" data-target="ack-alert" data-state="' . $alert['state'] . '" data-alert_id="' . $alert['id'] . '" name="ack-alert"></i>';
    $alert_status_running = '<i class="fa fa-microphone" style="font-size:20px;" aria-hidden="true" title="NOTIFICATIONS ARE RUNNING"></i>';
    $alert_status_suspended = '<i class="fa fa-microphone-slash" style="font-size:20px;" aria-hidden="true" title="NOTIFICATIONS ARE SUSPENDED"></i>';

    if ((int)$alert['state'] === 0) {
        $ico = '';
        $msg = '';
    } elseif ((int)$alert['state'] === 1 || (int)$alert['state'] === 3 || (int)$alert['state'] === 4) {
        $ico = $alert_to_ack;
        $msg = $alert_status_running;
        if ((int)$alert['state'] === 3) {
            $msg = '<i class="fa fa-angle-double-down" style="font-size:20px;" aria-hidden="true" title="STATUS GOT WORST"></i>';
        } elseif ((int)$alert['state'] === 4) {
            $msg = '<i class="fa fa-angle-double-up" style="font-size:20px;" aria-hidden="true" title="STATUS GOT BETTER"></i>';
        }
    } elseif ((int)$alert['state'] === 2) {
        $ico = $alert_to_nack;
        $msg = $alert_status_suspended;
    }

    $severity = $alert['severity'];
    if ($alert['state'] == 3) {
        $severity .= ' <strong>+</strong>';
    } elseif ($alert['state'] == 4) {
        $severity .= ' <strong>-</strong>';
    }

    $ack_ico = $alert_to_ack;

    if ($alert['state'] == 2) {
        $ack_ico = $alert_to_nack;
    }

    $hostname = '<div class="incident">' . generate_device_link($alert) . '<div id="incident' . ($rulei + 1) . '" class="collapse">' . $fault_detail . '</div></div>';

    switch ($severity) {
        case 'critical':
            $severity_ico = '<p class="text-danger"><i class="fa fa-times-circle-o" style="font-size:20px;" aria-hidden="true" data-label="critical" title="CRITICAL"></i></p>';
            break;
        case 'warning':
            $severity_ico = '<p class="text-warning"><i class="fa fa-exclamation-circle" style="font-size:20px;" aria-hidden="true" data-label="warning" title="WARNING"></i></p>';
            break;
        case 'ok':
            $severity_ico = '<p class="text-success"><i class="fa fa-check-circle-o" style="font-size:20px;" aria-hidden="true" data-label="ok" title="OK"></i></p>';
            break;
        default:
            $severity_ico = '';
            break;
    }

    $proc = dbFetchCell('SELECT proc FROM alerts,alert_rules WHERE alert_rules.id = alerts.rule_id AND alerts.id = ?', array($alert['id']));
    if (($proc == "") || ($proc == "NULL")) {
        $has_proc = '';
    } else {
        if (!preg_match('/^http[s]*:\/\//', $proc)) {
            $has_proc = '';
        } else {
            $has_proc = '<a href="' . $proc . '" target="_blank"><i class="fa fa-external-link" style="font-size:20px;" aria-hidden="true"></i></a>';
        }
    }

    $response[] = array(
        'id' => $rulei++,
        'rule' => '<i title="' . htmlentities($alert['rule']) . '"><a href="' . generate_url(array('page' => 'alert-rules')) . '">' . htmlentities($alert['name']) . '</a></i>',
        'details' => '<a class="fa fa-plus incident-toggle" style="display:none" data-toggle="collapse" data-target="#incident' . ($rulei) . '" data-parent="#alerts"></a>',
        'hostname' => $hostname,
        'timestamp' => ($alert['timestamp'] ? $alert['timestamp'] : 'N/A'),
        'severity' => $severity_ico,
        'state' => $alert['state'],
        'alert_id' => $alert['id'],
        'ack_ico' => $ack_ico,
        'status' => $msg,
        'proc' => $has_proc,
    );
}

$output = array(
    'current' => $current,
    'rowCount' => $rowCount,
    'rows' => $response,
    'total' => $total,
);
echo _json_encode($output);
