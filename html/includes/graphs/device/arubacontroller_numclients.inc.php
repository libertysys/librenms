<?php

$rrd_filename = rrd_name($device['hostname'], 'aruba-controller');

$rrd_list[0]['filename'] = $rrd_filename;
$rrd_list[0]['descr']    = 'Clients';
$rrd_list[0]['ds']       = 'NUMCLIENTS';

$unit_text = 'Clients';

$units       = '';
$total_units = '';
$colours     = 'mixed';

$scale_min = '0';

$nototal = 1;

if ($rrd_list) {
    include 'includes/html/graphs/generic_multi_line.inc.php';
}
