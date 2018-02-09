<?php
$name = 'zfs';
$app_id = $app['app_id'];
$unit_text     = 'misses/second';
$colours       = 'psychedelic';
$dostack       = 0;
$printtotal    = 0;
$addarea       = 1;
$transparency  = 15;

$rrd_filename = rrd_name($device['hostname'], array('app', $name, $app['app_id']));


$rrd_list=array();
if (rrdtool_check_rrd_exists($rrd_filename)) {
    $rrd_list[]=array(
        'filename' => $rrd_filename,
        'descr'    => 'Demand',
        'ds'       => 'demand_data_misses',
    );
    $rrd_list[]=array(
        'filename' => $rrd_filename,
        'descr'    => 'Demand Meta',
        'ds'       => 'demand_meta_misses',
    );
    $rrd_list[]=array(
        'filename' => $rrd_filename,
        'descr'    => 'Prefetch',
        'ds'       => 'pre_data_misses',
    );
    $rrd_list[]=array(
        'filename' => $rrd_filename,
        'descr'    => 'Prefetch Meta',
        'ds'       => 'pre_meta_misses',
    );
    $rrd_list[]=array(
        'filename' => $rrd_filename,
        'descr'    => 'ARC',
        'ds'       => 'arc_misses',
    );
} else {
    d_echo('RRD "'.$rrd_filename.'" not found');
}

require 'includes/graphs/generic_multi_line.inc.php';
