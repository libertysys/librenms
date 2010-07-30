<?php

$scale_min = "0";

include("includes/graphs/common.inc.php");

  $rrd_filename = $config['rrd_dir'] . "/" . $device['hostname'] . "/fdb_count.rrd";

  $rrd_options .= " DEF:value=$rrd_filename:value:AVERAGE";
  $rrd_options .= " COMMENT:'MACs      Current  Minimum  Maximum  Average\\n'";
  $rrd_options .= " AREA:value#EEEEEE:value";
  $rrd_options .= " LINE1.25:value#36393D:";
  $rrd_options .= " GPRINT:value:LAST:%6.2lf\  GPRINT:value:AVERAGE:%6.2lf\ ";
  $rrd_options .= " GPRINT:value:MAX:%6.2lf\  GPRINT:value:AVERAGE:%6.2lf\\\\n";

?>
