<?php

use App\Models\WirelessSensor;

// this determines the order of the tabs
$types = WirelessSensor::getTypes();

$sensors = dbFetchColumn(
    "SELECT `sensor_class` FROM `wireless_sensors` WHERE `device_id` = ? GROUP BY `sensor_class`",
    array($device['device_id'])
);
$datas = array_intersect(array_keys($types), $sensors);


$wireless_link_array = array(
    'page'   => 'device',
    'device' => $device['device_id'],
    'tab'    => 'wireless',
);

print_optionbar_start();

echo "<span style='font-weight: bold;'>Wireless</span> &#187; ";

if (!$vars['metric']) {
    $vars['metric'] = 'overview';
}

$sep = '';
echo '<span' . ($vars['metric'] == 'overview' ? ' class="pagemenu-selected"' : '') . '>';
echo generate_link('Overview', $wireless_link_array, array('metric' => 'overview'));
echo '</span>';

foreach ($datas as $type) {
    echo ' | <span';
    if ($vars['metric'] == $type) {
        echo ' class="pagemenu-selected"';
    }
    echo '>';

    echo generate_link($types[$type]['short'], $wireless_link_array, array('metric' => $type));

    echo '</span>';
}

print_optionbar_end();

if ($vars['metric'] == 'overview') {
    foreach ($datas as $type) {
        $text = $types[$type]['long'];
        if (!empty($types[$type]['unit'])) {
            $text .=  ' (' . $types[$type]['unit'] . ')';
        }

        $graph_title = generate_link($text, $wireless_link_array, array('metric' => $type));
        $graph_array['type'] = 'device_wireless_'.$type;

        include $config['install_dir'] . '/html/includes/print-device-graph.php';
    }
} elseif (isset($types[$vars['metric']])) {
    $unit = $types[$vars['metric']]['unit'];
    $factor = 1;
    if ($unit == 'MHz') {
        $unit = 'Hz';
        $factor = 1000000;
    }
    $row = 0;

    $sensors = dbFetchRows(
        'SELECT * FROM `wireless_sensors` WHERE `sensor_class` = ? AND `device_id` = ? ORDER BY `sensor_descr`',
        array($vars['metric'], $device['device_id'])
    );
    foreach ($sensors as $sensor) {
        if (!is_integer($row++ / 2)) {
            $row_colour = $config['list_colour']['even'];
        } else {
            $row_colour = $config['list_colour']['odd'];
        }

        $sensor_descr = $sensor['sensor_descr'];

        if (empty($unit)) {
            $sensor_current = ((int)$sensor['sensor_current']) . $unit;
            $sensor_limit = ((int)$sensor['sensor_limit']) . $unit;
            $sensor_limit_low = ((int)$sensor['sensor_limit_low']) . $unit;
        } else {
            $sensor_current = format_si($sensor['sensor_current'] * $factor, 3) . $unit;
            $sensor_limit = format_si($sensor['sensor_limit'] * $factor, 3) . $unit;
            $sensor_limit_low = format_si($sensor['sensor_limit_low'] * $factor, 3) . $unit;
        }

        echo "<div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'>
                    $sensor_descr 
                    <div class='pull-right'>$sensor_current | $sensor_limit_low <> $sensor_limit</div>
                </h3>
            </div>";
        echo "<div class='panel-body'>";

        $graph_array['id']   = $sensor['sensor_id'];
        $graph_array['type'] = 'wireless_' . $vars['metric'];

        include $config['install_dir'] . '/html/includes/print-graphrow.inc.php';

        echo '</div></div>';
    }
}

$pagetitle[] = 'Wireless';
