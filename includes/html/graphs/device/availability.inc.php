<?php

$scale_min = '0';
$scale_max = '100';
$float_precision = '3';

$rrd_filename = rrd_name($device['hostname'], array('availability', $vars['duration']));

$ds = 'availability';

$colour_line = '000000';
$colour_area = '8B8BEB';

$colour_area_max = 'cc9999';

$graph_title .= '::'.\LibreNMS\Util\Time::humanTime($vars['duration']);

$graph_max = 1;
$graph_min = 0;

$unit_text = 'Availability(%)';

require 'includes/html/graphs/generic_simplex.inc.php';
