<?php

$scale_min = "25";
$scale_max = "40";

include("includes/graphs/common.inc.php");

  $rrd_options .= " COMMENT:'                          Cur     Min    Max\\n'";

  $sensor = mysql_fetch_array(mysql_query("SELECT * FROM sensors where sensor_id = '".mres($_GET['id'])."'"));
  $device = device_by_id_cache($sensor['device_id']);

  $sensor['sensor_descr_fixed'] = substr(str_pad($sensor['sensor_descr'], 22),0,22);

  $rrd_filename = $config['rrd_dir'] . "/" . $device['hostname'] . "/temp-" . safename($sensor['sensor_type']."-".$sensor['sensor_index']) . ".rrd";


  $rrd_options .= " DEF:temp=$rrd_filename:temp:AVERAGE";
  $rrd_options .= " DEF:temp_max=$rrd_filename:temp:MAX";
  $rrd_options .= " DEF:temp_min=$rrd_filename:temp:MIN";
  $rrd_options .= " CDEF:tempwarm=temp_max,".$sensor['sensor_limit'].",GT,temp,UNKN,IF";
  $rrd_options .= " CDEF:tempcold=temp_min,20,LT,temp,UNKN,IF";
  $rrd_options .= " AREA:temp_max#c5c5c5";
  $rrd_options .= " AREA:temp_min#ffffffff";



#  $rrd_options .= " AREA:temp#bbd392";
#  $rrd_options .= " AREA:tempwarm#FFCCCC";
#  $rrd_options .= " AREA:tempcold#CCCCFF";
#  $rrd_options .= " LINE1:temp#cc0000:'" . str_replace(':','\:',str_replace('\*','*',quotemeta($sensor['sensor_descr_fixed'])))."'"; # Ugly hack :(
  $rrd_options .= " LINE1:temp#cc0000:'" . str_replace(':','\:',str_replace('\*','*',$sensor['sensor_descr_fixed']))."'"; # Ugly hack :(
  $rrd_options .= " LINE1:tempwarm#660000";
  $rrd_options .= " GPRINT:temp:LAST:%4.1lfC";
  $rrd_options .= " GPRINT:temp:MIN:%4.1lfC";
  $rrd_options .= " GPRINT:temp:MAX:%4.1lfC\\\\l";

?>
