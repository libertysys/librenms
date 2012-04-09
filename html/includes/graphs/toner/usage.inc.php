<?php
$scale_min = "0";
$scale_max = "100";

include("includes/graphs/common.inc.php");

$rrd_options .= " COMMENT:'                                 Cur    Max\\n'";

$colour = toner2colour($toner['toner_descr']);
if ($colour == NULL) { $colour="CC0000"; }

$descr = substr(str_pad($toner['toner_descr'],26),0,26);

$background = get_percentage_colours(100-$toner['toner_current']);

$rrd_options .= " DEF:toner" . $toner['toner_id'] . "=".$rrd_filename.":toner:AVERAGE ";

$rrd_options .= " LINE1:toner" . $toner['toner_id'] . "#" . $colour . ":'" . $descr . "' ";

$rrd_options .= " AREA:toner" . $toner['toner_id' ] . "#" . $background['right'] . ":";
$rrd_options .= " GPRINT:toner" . $toner['toner_id'] . ":LAST:'%5.0lf%%'";
$rrd_options .= " GPRINT:toner" . $toner['toner_id'] . ":MAX:%5.0lf%%\\\\l";

?>
