<?php

if(mysql_result(mysql_query("SELECT count(storage_id) from storage WHERE host_id = '" . $device['device_id'] . "'"),0)) {
  echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
  echo("<p class=sectionhead>Storage</p>");
  echo("<table width=100% cellspacing=0 cellpadding=5>");
  $drive_rows = '0';

  $drives = mysql_query("SELECT * FROM `storage` WHERE host_id = '" . $device['device_id'] . "'");
  while($drive = mysql_fetch_array($drives)) {
    if(is_integer($drive_rows/2)) { $row_colour = $list_colour_a; } else { $row_colour = $list_colour_b; }
    $total = $drive['hrStorageSize'] * $drive['hrStorageAllocationUnits'];
    $used  = $drive['hrStorageUsed'] * $drive['hrStorageAllocationUnits'];
    $perc  = round($drive['storage_perc'], 0);
    $total = formatStorage($total);
    $used = formatStorage($used);

    $fs_url   = "/device/".$device['device_id']."/health/storage/";

    $fs_popup  = "onmouseover=\"return overlib('<div class=list-large>".$device['hostname']." - ".$drive['hrStorageDescr'];
    $fs_popup .= "</div><img src=\'graph.php?id=" . $drive['storage_id'] . "&type=hrstorage&from=$month&to=$now&width=400&height=125\'>";
    $fs_popup .= "', RIGHT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\"";

    $mini_graph = $config['base_url'] . "/graph.php?id=".$drive['storage_id']."&type=hrstorage&from=".$day."&to=".$now."&width=80&height=20&bg=f4f4f4";



    if($perc > '90') { $left_background='c4323f'; $right_background='C96A73';  
    } elseif($perc > '75') { $left_background='bf5d5b'; $right_background='d39392';
    } elseif($perc > '50') { $left_background='bf875b'; $right_background='d3ae92';
    } elseif($perc > '25') { $left_background='5b93bf'; $right_background='92b7d3';
    } else { $left_background='9abf5b'; $right_background='bbd392'; } 
   
    echo("<tr bgcolor=$row_colour><td class=tablehead><a href='".$fs_url."' $fs_popup>" . $drive['hrStorageDescr'] . "</a></td>
            <td width=90><a href='".$fs_url."' $fs_popup><img src='$mini_graph' /></a></td>
            <td width=200><a href='".$fs_url."' $fs_popup>".print_percentage_bar (200, 16, $perc, "$used / $total", "ffffff", $left_background, $perc . "%", "ffffff", $right_background)."</a></td>
          </tr>");
    $drive_rows++;
  }
  echo("</table>");
  echo("</div>");
}

unset ($drive_rows);

?>
