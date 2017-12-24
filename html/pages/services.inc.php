<?php

$pagetitle[] = 'Services';

?>
<div class="container-fluid">
  <div class="row">
<?php
print_optionbar_start();
require_once 'includes/modal/new_service.inc.php';

require_once 'includes/modal/delete_service.inc.php';

echo "<span style='font-weight: bold;'>Services</span> &#187; ";
$menu_options = array(
    'basic' => 'Basic',
);

if (!$vars['view']) {
    $vars['view'] = 'basic';
}

$status_options = array(
    'all' => 'All',
    'ok' => 'Ok',
    'warning' => 'Warning',
    'critical' => 'Critical',
);

if (!$vars['state']) {
    $vars['state'] = 'all';
}

// The menu option - on the left

$sep = '';

foreach ($menu_options as $option => $text) {
    if (empty($vars['view'])) {
        $vars['view'] = $option;
    }

    echo $sep;
    if ($vars['view'] == $option) {
        echo "<span class='pagemenu-selected'>";
    }

    echo generate_link($text, $vars, array(
        'view' => $option
    ));
    if ($vars['view'] == $option) {
        echo '</span>';
    }

    $sep = ' | ';
}

unset($sep);

// The status option - on the right

echo '<div class="pull-right">';
$sep = '';

foreach ($status_options as $option => $text) {
    if (empty($vars['state'])) {
        $vars['state'] = $option;
    }

    echo $sep;
    if ($vars['state'] == $option) {
        echo "<span class='pagemenu-selected'>";
    }

    echo generate_link($text, $vars, array(
        'state' => $option
    ));
    if ($vars['state'] == $option) {
        echo '</span>';
    }

    $sep = ' | ';
}

unset($sep);
echo '</div>';
print_optionbar_end();
$sql_param = array();

if (isset($vars['state'])) {
    if ($vars['state'] == 'ok') {
        $state = '0';
    } elseif ($vars['state'] == 'critical') {
        $state = '2';
    } elseif ($vars['state'] == 'warning') {
        $state = '1';
    }
}

if (isset($state)) {
    $where.= " AND service_status= ? AND service_disabled='0' AND `service_ignore`='0'";
    $sql_param[] = $state;
}
?>
<div class="row col-sm-12"><span id="message"></span></div>
<?php
if ($_SESSION['userlevel'] >= '5') {
    $host_sql = 'SELECT `D`.`device_id`,`D`.`hostname`,`D`.`sysName` FROM devices AS D, services AS S WHERE D.device_id = S.device_id GROUP BY `D`.`hostname`, `D`.`device_id` ORDER BY D.hostname';
    $host_par = array();
} else {
    $host_sql = 'SELECT `D`.`device_id`,`D`.`hostname`,`D`.`sysName` FROM devices AS D, services AS S, devices_perms AS P WHERE D.device_id = S.device_id AND D.device_id = P.device_id AND P.user_id = ? GROUP BY `D`.`hostname`, `D`.`device_id` ORDER BY D.hostname';
    $host_par = array($_SESSION['user_id']);
}

$shift = 1;
foreach (dbFetchRows($host_sql, $host_par) as $device) {
    $device_id       = $device['device_id'];
    $device_hostname = $device['hostname'];
    $device_sysName  = $device['sysName'];
    $devlink = generate_device_link($device, null, array('tab' => 'services'));
    if ($shift == 1) {
        array_unshift($sql_param, $device_id);
        $shift = 0;
    } else {
        $sql_param[0] = $device_id;
    }
    $head=true;

    foreach (dbFetchRows("SELECT * FROM `services` WHERE `device_id` = ? $where ORDER BY service_type", $sql_param) as $service) {
        if ($service['service_status'] == '2') {
            $label = 'danger';
            $title = 'CRITICAL';
        } elseif ($service['service_status'] == '1') {
            $label = 'warning';
            $title = 'WARNING';
        } elseif ($service['service_status'] == '0') {
            $label = 'success';
            $title = 'OK';
        } else {
            $label = 'info';
            $title = 'UNKNOWN';
        }
        if ($head) {
            echo '
<div class="panel panel-default">
<div class="panel-heading">
    <h3 class="panel-title">'.$devlink.'</h3>
    '.$device_sysName.'
</div>
<div class="panel-body">
<table class="table table-hover table-condensed">
<thead>
    <tr>
        <th></th>
        <th>Service</th>
        <th>Last Changed</th>
        <th>Message</th>
    </tr>
</thead>
';
        }
        $head=false;
?>
<tr>
    <td><span data-toggle='tooltip' title='<?php echo $title?>' class='service-status label label-<?php echo $label?>'> </span></td>
    <td><?php echo nl2br(display($service['service_type']))?></td>
    <td><?php echo formatUptime(time() - $service['service_changed'])?></td>
    <td><?php echo nl2br(display($service['service_desc']))?></td>
    <td><?php echo nl2br(display($service['service_message']))?></td>
<?php
if (is_admin() === true) {
    echo "    <td><button type='button' class='btn btn-primary btn-sm' aria-label='Edit' data-toggle='modal' data-target='#create-service' data-service_id='{$service['service_id']}' name='edit-service'><i class='fa fa-pencil' aria-hidden='true'></i></button>
    <button type='button' class='btn btn-danger btn-sm' aria-label='Delete' data-toggle='modal' data-target='#confirm-delete' data-service_id='{$service['service_id']}' name='delete-service'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
}
?>
</tr>
<?php
    }//end foreach

    echo "</table></div></div>";
    unset($samehost);
}//end foreach
?>
 </div>
</div>
