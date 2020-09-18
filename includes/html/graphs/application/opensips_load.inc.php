<?php

$scale_min = 0;

$scale_max = 1;

require 'includes/html/graphs/common.inc.php';

$opensips_rrd = rrd_name($device['hostname'], array('app', 'opensips', $app['app_id']));


if (rrdtool_check_rrd_exists($opensips_rrd)) {
    $rrd_filename = $opensips_rrd;
}


$ds = 'load';

$colour_area = 'F0E68C';
$colour_line = 'FF4500';

$colour_area_max = 'FFEE99';

$graph_max = 1000;
$graph_min = 1;

$unit_text = 'Load Average %';

require 'includes/html/graphs/generic_simplex.inc.php';
