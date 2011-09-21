<?php

include("includes/graphs/common.inc.php");

include('includes/graphs/common.inc.php');

$rrd_filename = $config["rrd_dir"] . '/' . $device["hostname"] . '/app-mysql-'.$app["app_id"].'.rrd';

$array = array('MaCs'  => array('descr' => 'Max Connections', 'colour' => '22FF22'),
               'MUCs'  => array('descr' => 'Max Used Connections', 'colour' => '0022FF'),
               'ACs'   => array('descr' => 'Aborted Clients', 'colour' => 'FF0000'),
               'AdCs'  => array('descr' => 'Aborted Connects', 'colour' => '0080C0'),
               'TCd'   => array('descr' => 'Threads Connected', 'colour' => 'FF0000'),
               'Cs'    => array('descr' => 'New Connections', 'colour' => '0080C0'),
);

$i = 0;
if (is_file($rrd_filename))
{
  foreach ($array as $ds => $vars)
  {
    $rrd_list[$i]['filename'] = $rrd_filename;
    $rrd_list[$i]['descr'] = $vars['descr'];
    $rrd_list[$i]['ds'] = $ds;
#    $rrd_list[$i]['colour'] = $vars['colour'];
    $i++;
  }
} else { echo("file missing: $file");  }

$colours   = "mixed";
$nototal   = 1;
$unit_text = "Commands";

include("includes/graphs/generic_multi_simplex_seperated.inc.php");

?>
