<?php

if($_GET['from'])    { $from   = mres($_GET['from']);   }
if($_GET['to'])      { $to     = mres($_GET['to']);     }
if($_GET['width'])   { $width  = mres($_GET['width']);  }
if($_GET['height'])  { $height = mres($_GET['height']); }

if($_GET['bg'])      { $bg     = mres($_GET['bg']);     }

if($_GET['inverse']) { $in = 'out'; $out = 'in'; } else { $in = 'in'; $out = 'out'; }
if($_GET['legend'] == "no")  { $rrd_options = " -g"; }

#if($bg) { $rrd_options .= " -c CANVAS#" . $bg . " "; }

if(!$scale_min && !$scale_max) { $rrd_options .= " --alt-autoscale-max"; }

if($scale_min) { $rrd_options .= " -l $scale_min"; }
if($scale_max) { $rrd_options .= " -u $scale_max"; }


$rrd_options .= " -E --start ".$from." --end " . ($to - 150) . " --width ".$width." --height ".$height." ";
$rrd_options .= $config['rrdgraph_def_text'];

$rrd_options .= " -c BACK#FFFFFF";

if($height < "99")  { $rrd_options .= " --only-graph"; }
if($width <= "300") { $rrd_options .= " --font LEGEND:7:".$config['mono_font']." --font AXIS:6:".$config['mono_font']." --font-render-mode normal"; 
} else { $rrd_options .= " --font LEGEND:8:".$config['mono_font']." --font AXIS:7:".$config['mono_font']." --font-render-mode normal";  }

?>
