<?php

require 'includes/graphs/common.inc.php';

$rrd_filename = rrd_name($device['hostname'], 'vpdn-l2tp');

$stats = array('tunnels');

$i = 0;
foreach ($stats as $stat) {
    $i++;
    $rrd_list[$i]['filename'] = $rrd_filename;
    $rrd_list[$i]['ds']       = $stat;
}

$colours = 'mixed';

$nototal    = 1;
$simple_rrd = 1;

require 'includes/graphs/generic_multi_line.inc.php';
