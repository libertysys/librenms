<?php

$rrd_filename = rrd_name($device['hostname'], 'panos-activetunnels');

$ds = 'activetunnels';

$colour_area = '9999cc';
$colour_line = '0000cc';

$colour_area_max = '9999cc';

$graph_max = 1;

$unit_text = 'Active Tunnels';

require 'includes/graphs/generic_simplex.inc.php';
