<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       http://librenms.org
 * @copyright  2017 LibreNMS
 * @author     LibreNMS Contributors
*/

use LibreNMS\Authentication\LegacyAuth;

$pagetitle[] = 'Services';

require_once '../includes/services.inc.php';
$services = service_get($device['device_id']);

require_once 'includes/modal/new_service.inc.php';
require_once 'includes/modal/delete_service.inc.php';

if (!$vars['view']) {
    $vars['view'] = 'basic';
}

$menu_options = array(
    'basic' => 'Basic',
    'details' => 'Details',
);

print_optionbar_start();
echo "<span style='font-weight: bold;'>Services &#187; </span>";
$sep = '';
foreach ($menu_options as $option => $text) {
    if (empty($vars['view'])) {
        $vars['view'] = $option;
    }

    echo $sep;
    if ($vars['view'] == $option) {
        echo '<span class="pagemenu-selected">';
    }

    echo generate_link($text, $vars, array('view' => $option));
    if ($vars['view'] == $option) {
        echo '</span>';
    }

    $sep = ' | ';
}
unset($sep);

if (LegacyAuth::user()->hasGlobalAdmin()) {
    echo '<div class="pull-right"><a data-toggle="modal" href="#create-service"><i class="fa fa-cog" style="color:green" aria-hidden="true"></i> Add Service</a></div>';
}

print_optionbar_end();
echo '</div><div>';

if (count($services) > '0') {
    // Loop over each service, pulling out the details.

    echo '<table class="table table-hover table-condensed">';

    foreach ($services as $service) {
        $service['service_ds'] = htmlspecialchars_decode($service['service_ds']);
        if ($service['service_status'] == '2') {
            $status = '<span class="alert-status label-danger"><span class="device-services-page">' . $service['service_type'] . '</span></span>';
        } elseif ($service['service_status'] == '1') {
            $status = '<span class="alert-status label-warning"><span class="device-services-page">' . $service['service_type'] . '</span></span>';
        } elseif ($service['service_status'] == '0') {
            $status = '<span class="alert-status label-success"><span class="device-services-page">' . $service['service_type'] . '</span></span>';
        } else {
            $status = '<span class="alert-status label-info"><span class="device-services-page">' . $service['service_type'] . '</span></span>';
        }

        echo '<tr id="row_' . $service['service_id'] . '">';
        echo '<td class="col-sm-12">';
        echo '<div class="col-sm-1">' . $status . '</div>';
        echo '<div class="col-sm-2 text-muted">' . formatUptime(time() - $service['service_changed']) . '</div>';
        echo '<div class="col-sm-2 text-muted">' . $service['service_desc'] . '</div>';
        echo '<div class="col-sm-5">' . nl2br(trim($service['service_message'])) . '</div>';
        echo '<div class="col-sm-2">';
        echo '<div class="pull-right">';
        if (LegacyAuth::user()->hasGlobalAdmin()) {
            echo "<button type='button' class='btn btn-primary btn-sm' aria-label='Edit' data-toggle='modal' data-target='#create-service' data-service_id='{$service['service_id']}' name='edit-service'><i class='fa fa-pencil' aria-hidden='true'></i></button>
        <button type='button' class='btn btn-danger btn-sm' aria-label='Delete' data-toggle='modal' data-target='#confirm-delete' data-service_id='{$service['service_id']}' name='delete-service'><i class='fa fa-trash' aria-hidden='true'></i></button";
        }
        echo '</div>';
        echo '</div>';

        if ($vars['view'] == 'details') {
            // if we have a script for this check, use it.
            $check_script = $config['install_dir'] . '/includes/services/check_' . strtolower($service['service_type']) . '.inc.php';
            if (is_file($check_script)) {
                include $check_script;

                // If we have a replacement DS use it.
                if (isset($check_ds)) {
                    $service['service_ds'] = $check_ds;
                }
            }

            $graphs = json_decode($service['service_ds'], true);
            foreach ($graphs as $k => $v) {
                $graph_array['device'] = $device['device_id'];
                $graph_array['type'] = 'device_service';
                $graph_array['service'] = $service['service_id'];
                $graph_array['ds'] = $k;

                echo '<tr>';
                echo '<td colspan="5"><div class="col-sm-12">';

                include 'includes/print-graphrow.inc.php';

                echo '</div></td>';
                echo '</tr>';
            }
        }
    }
    echo '</table>';
} else {
    echo '<div class="device-services-page-no-service">No Services</div>';
}

echo '</div>';
