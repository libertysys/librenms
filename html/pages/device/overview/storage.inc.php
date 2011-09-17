<?php

$graph_type = "storage_usage";

$drives = dbFetchRows("SELECT * FROM `storage` WHERE device_id = ? ORDER BY `storage_descr` ASC", array($device['device_id']));

if (count($drives))
{
  echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
  echo("<p style='padding: 0px 5px 5px;' class=sectionhead>");
  echo('<a class="sectionhead" href="device/'.$device['device_id'].'/health/storage/">');
  echo("<img align='absmiddle' src='".$config['base_url']."/images/icons/storage.png'> Storage</a></p>");
  echo("<table width=100% cellspacing=0 cellpadding=5>");
  $drive_rows = '0';

  foreach ($drives as $drive)
  {
    $skipdrive = 0;

    if ($device["os"] == "junos")
    {
      foreach ($config['ignore_junos_os_drives'] as $jdrive)
      {
        if (preg_match($jdrive, $drive["storage_descr"]))
        {
          $skipdrive = 1;
        }
      }
      $drive["storage_descr"] = preg_replace("/.*mounted on: (.*)/", "\\1", $drive["storage_descr"]);
    }

    if ($device['os'] == "freebsd")
    {
      foreach ($config['ignore_bsd_os_drives'] as $jdrive)
      {
        if (preg_match($jdrive, $drive["storage_descr"]))
        {
          $skipdrive = 1;
        }
      }
    }

    if ($skipdrive) { continue; }
    if (is_integer($drive_rows/2)) { $row_colour = $list_colour_a; } else { $row_colour = $list_colour_b; }
    $perc  = round($drive['storage_perc'], 0);
    $total = formatStorage($drive['storage_size']);
    $free = formatStorage($drive['storage_free']);
    $used = formatStorage($drive['storage_used']);
    $background = get_percentage_colours($perc);

    $graph_array           = array();
    $graph_array['height'] = "100";
    $graph_array['width']  = "210";
    $graph_array['to']     = $now;
    $graph_array['id']     = $drive['storage_id'];
    $graph_array['type']   = $graph_type;
    $graph_array['from']   = $day;
    $graph_array['legend'] = "no";

    $link_array = $graph_array;
    $link_array['page'] = "graphs";
    unset($link_array['height'], $link_array['width'], $link_array['legend']);
    $link = generate_url($link_array);

    $overlib_content = generate_overlib_content($graph_array, $device['hostname'] . " - " . $text_descr);

    $graph_array['width'] = 80; $graph_array['height'] = 20; $graph_array['bg'] = $graph_colour;

    $minigraph =  generate_graph_tag($graph_array);

    echo("<tr bgcolor=$row_colour>
           <td class=tablehead>".overlib_link($link, $text_descr, $overlib_content)."</td>
           <td width=90>".overlib_link($link, $minigraph, $overlib_content)."</td>
           <td width=200>".overlib_link($link, print_percentage_bar (200, 20, $percent, NULL, "ffffff", $background['left'], $percent . "%", "ffffff", $background['right']), $overlib_content)."
           </a></td>
         </tr>");

    $drive_rows++;
  }

  echo("</table>");
  echo("</div>");
}

unset ($drive_rows);

?>
