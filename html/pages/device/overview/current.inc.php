<?php

$graph_type = "sensor_current";

if($total = mysql_result(mysql_query("SELECT count(sensor_id) from sensors WHERE sensor_class='current' AND device_id = '" . $device['device_id'] . "'"),0)) {
  $rows = round($total / 2,0);
  echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
  echo("<p style='padding: 0px 5px 5px;' class=sectionhead><img align='absmiddle' src='".$config['base_url']."/images/icons/current.png'> Current</p>");
  $i = '1';
  $currents = mysql_query("SELECT * FROM sensors WHERE sensor_class='current' AND device_id = '" . $device['device_id'] . "'");
  echo("<table width=100% valign=top>");
  echo("<tr><td width=50%>");
  echo("<table width=100% cellspacing=0 cellpadding=2>");
  while($current = mysql_fetch_array($currents)) {
    if(is_integer($i/2)) { $row_colour = $list_colour_a; } else { $row_colour = $list_colour_b; }

    $graph_colour = str_replace("#", "", $row_colour);

    $current_day    = "graph.php?id=" . $current['sensor_id'] . "&type=".$graph_type."&from=$day&to=$now&width=300&height=100";
    $current_week   = "graph.php?id=" . $current['sensor_id'] . "&type=".$graph_type."&from=$week&to=$now&width=300&height=100";
    $current_month  = "graph.php?id=" . $current['sensor_id'] . "&type=".$graph_type."&from=$month&to=$now&width=300&height=100";
    $current_year  = "graph.php?id=" . $current['sensor_id'] . "&type=".$graph_type."&from=$year&to=$now&width=300&height=100";
    $current_minigraph = "<img src='graph.php?id=" . $current['sensor_id'] . "&type=".$graph_type."&from=$day&to=$now&width=80&height=20&bg=$graph_colour' align='absmiddle'>";

    $current_link  = "<a href='device/".$device['device_id']."/health/current/' onmouseover=\"return ";
    $current_link .= "overlib('<div class=list-large>".$device['hostname']." - ".$current['sensor_descr'];
    $current_link .= "</div><div style=\'width: 750px\'><img src=\'$current_day\'><img src=\'$current_week\'><img src=\'$current_month\'><img src=\'$current_year\'></div>', RIGHT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\" >";

    $current_link_c = $current_link . "<span " . ($current['sensor_current'] < $current['sensor_limit_low'] || $current['sensor_current'] > $current['sensor_limit'] ? "style='color: red'" : '') . '>' . $current['sensor_current'] . "A</span></a>";
    $current_link_b = $current_link . $current_minigraph . "</a>";
    $current_link_a = $current_link . $current['sensor_descr'] . "</a>";

    $current['sensor_descr'] = truncate($current['sensor_descr'], 25, '');
    echo("<tr bgcolor='$row_colour'><td class=tablehead><strong>$current_link_a</strong></td><td width=80 align=right class=tablehead>$current_link_b<td width=80 align=right class=tablehead>$current_link_c</td></tr>");
    if($i == $rows) { echo("</table></td><td valign=top><table width=100% cellspacing=0 cellpadding=2>"); }
    $i++;
  }
  echo("</table>");
  echo("</td></tr>");
  echo("</table>");
  echo("</div>");
}


?>
