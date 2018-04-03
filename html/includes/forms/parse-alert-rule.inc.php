<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

use LibreNMS\Alerting\QueryBuilderParser;

if (is_admin() === false) {
    header('Content-type: text/plain');
    die('ERROR: You need to be admin');
}

$alert_id = $_POST['alert_id'];
$template_id = $_POST['template_id'];

if (is_numeric($alert_id) && $alert_id > 0) {
    $rule = dbFetchRow('SELECT * FROM `alert_rules` WHERE `id` = ? LIMIT 1', [$alert_id]);

    $maps = [];

    $devices = dbFetchRows('SELECT `device_id`, `hostname`, `sysName` FROM `alert_device_map` LEFT JOIN `devices` USING (`device_id`) WHERE `rule_id`=?', [$alert_id]);
    foreach ($devices as $device) {
        $maps[] = ['id' => $device['device_id'], 'text' => format_hostname($device)];
    }

    $groups = dbFetchRows('SELECT `group_id`, `name` FROM `alert_group_map` LEFT JOIN `device_groups` ON `device_groups`.`id`=`alert_group_map`.`group_id` WHERE `rule_id`=?', [$alert_id]);
    foreach ($groups as $group) {
        $maps[] = ['id' => 'g' . $group['group_id'], 'text' => $group['name']];
    }

    $contacts = [];
    $emails = dbFetchRows('SELECT `alert_transport_map`.`transport_id`, `contact_name`, `email` FROM `alert_transport_map` LEFT JOIN `transport_email` ON `transport_email`.`transport_id`=`alert_transport_map`.`transport_id` WHERE `rule_id` = ?', [$alert_id]);
    foreach($emails as $email) {
        $contacts[] = ['id' => 'e'. $email['transport_id'], 
                       'text' => '('.$email['contact_name'].') '.$email['email']];
    }

} elseif (is_numeric($template_id) && $template_id >= 0) {
    $tmp_rules = get_rules_from_json();
    $rule = $tmp_rules[$template_id];
    $maps = [];
}

if (is_array($rule)) {
    if (empty($rule['builder'])) {
        // convert old rules when editing
        $builder = QueryBuilderParser::fromOld($rule['rule'])->toArray();
    } else {
        $builder = json_decode($rule['builder']);
    }

    header('Content-type: application/json');
    echo json_encode([
        'extra'    => isset($rule['extra']) ? json_decode($rule['extra']) : null,
        'maps'     => $maps,
        'contacts' => $contacts,
        'name'     => $rule['name'],
        'proc'     => $rule['proc'],
        'builder'  => $builder,
        'severity' => $rule['severity'],
    ]);
}
