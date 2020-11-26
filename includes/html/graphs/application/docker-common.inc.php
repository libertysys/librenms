<?php
$name = 'docker';
$app_id = $app['app_id'];
$colours = 'mega';
$dostack = 0;
$printtotal = 0;
$addarea = 1;
$transparency = 15;

$unitlen = 20;
$bigdescrlen = 25;
$smalldescrlen = 25;

if (isset($vars['container'])) {
    $containers=array($vars['container']);
} else {
    $containers=get_arrays_with_application($device, $app['app_id'], 'docker');
}

$int=0;
while (isset($containers[$int])) {
    $container_name=$containers[$int];
    $rrd_filename = rrd_name($device['hostname'], array('app', $name, $app_id, $container_name));

    if (rrdtool_check_rrd_exists($rrd_filename)) {
        $rrd_list[]=array(
            'filename' => $rrd_filename,
            'descr'    => $container_name,
            'ds'       => $rrdVar,
        );
    }
    $int++;
}

require 'includes/html/graphs/generic_multi_line_exact_numbers.inc.php';