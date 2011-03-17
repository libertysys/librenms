<?php

#$device = device_by_id_cache($id);

include("includes/graphs/common.inc.php");

$file = $config['rrd_dir'] . "/" . $device['hostname'] . "/" . safename("screenos_sessions.rrd");

$rrd_list[0]['filename'] = $file;
$rrd_list[0]['descr'] = "Maxiumum";
$rrd_list[0]['rra'] = "max";

$rrd_list[1]['filename'] = $file;
$rrd_list[1]['descr'] = "Allocated";
$rrd_list[1]['rra'] = "allocate";

$rrd_list[2]['filename'] = $file;
$rrd_list[2]['descr'] = "Failed";
$rrd_list[2]['rra'] = "failed";

if ($_GET['debug']) { print_r($rrd_list); } 

$colours   = "mixed";
$nototal   = 1;
$unit_text = "Sessions";
$scale_min = "0";

include("includes/graphs/generic_multi_line.inc.php");

?>