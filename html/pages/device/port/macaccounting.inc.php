<?php


$hostname = $device['hostname'];
$hostid   = $device['interface_id'];
$ifname   = $interface['ifDescr'];
$ifIndex   = $interface['ifIndex'];
$speed = humanspeed($interface['ifSpeed']);

$ifalias = $interface['name'];

if ($interface['ifPhysAddress']) { $mac = "$interface[ifPhysAddress]"; }

$color = "black";
if ($interface['ifAdminStatus'] == "down") { $status = "<span class='grey'>Disabled</span>"; }
if ($interface['ifAdminStatus'] == "up" && $interface['ifOperStatus'] == "down") { $status = "<span class='red'>Enabled / Disconnected</span>"; }
if ($interface['ifAdminStatus'] == "up" && $interface['ifOperStatus'] == "up") { $status = "<span class='green'>Enabled / Connected</span>"; }

$i = 1;
$inf = fixifName($ifname);

echo("<div style='clear: both;'>");

if ($_GET['optd'] == "top10")
{
  if ($_GET['opte'])
  {
    $period = $_GET['opte'];
  } else { $period = "1day"; }

  $from = "-" . $period;
  if ($_GET['optc'])
  {
    $stat = $_GET['optc'];
  } else { $stat = "bits"; }

  if ($_GET['optf'])
  {
    $sort = $_GET['optf'];
  } else { $sort = "in"; }

  echo("<div style='margin: 0px 0px 0px 0px'>
         <div style=' margin:0px; float: left;';>
           <div style='margin: 0px 10px 5px 0px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Day</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id'].
                    "/macaccounting/$stat/top10/1day/$sort/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id'].
                    "&amp;stat=$stat&amp;type=port_mac_acc_total&amp;sort=$sort&amp;from=-1day&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
           <div style='margin: 0px 10px 5px 0px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Two Day</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id'].
                    "/macaccounting/$stat/top10/2day/$sort/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id'].
                    "&amp;stat=$stat&amp;type=port_mac_acc_total&amp;sort=$sort&amp;from=-2day&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
           <div style='margin: 0px 10px 5px 0px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Week</span><br />
            <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id']."/macaccounting/$stat/top10/1week/$sort/'>
            <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id']."&amp;type=port_mac_acc_total&amp;sort=$sort&amp;stat=$stat&amp;from=-1week&amp;to=now&amp;width=150&amp;height=50' />
            </a>
            </div>
            <div style='margin: 0px 10px 5px 0px; padding:5px; background: #e5e5e5;'>
            <span class=device-head>Month</span><br />
            <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id']."/macaccounting/$stat/top10/1month/$sort/'>
            <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id']."&amp;type=port_mac_acc_total&amp;sort=$sort&amp;stat=$stat&amp;from=-1month&amp;to=now&amp;width=150&amp;height=50' />
            </a>
            </div>
            <div style='margin: 0px 10px 5px 0px; padding:5px; background: #e5e5e5;'>
            <span class=device-head>Year</span><br />
            <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id']."/macaccounting/$stat/top10/1year/$sort/'>
            <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id']."&amp;type=port_mac_acc_total&amp;sort=$sort&amp;stat=$stat&amp;from=-1year&amp;to=now&amp;width=150&amp;height=50' />
            </a>
            </div>
       </div>
       <div style='float: left;'>
         <img src='".$config['base_url']."/graph.php?id=".$interface['interface_id']."&amp;type=port_mac_acc_total&amp;sort=$sort&amp;stat=$stat&amp;from=$from&amp;to=now&amp;width=745&amp;height=300' />
       </div>
       <div style=' margin:0px; float: left;';>
            <div style='margin: 0px 0px 5px 10px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Traffic</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id']."/macaccounting/bits/top10/$period/$sort/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id']."&amp;stat=bits&amp;type=port_mac_acc_total&amp;sort=$sort&amp;from=$from&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
           <div style='margin: 0px 0px 5px 10px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Packets</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id']."/macaccounting/pkts/top10/$period/$sort/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id']."&amp;stat=pkts&amp;type=port_mac_acc_total&amp;sort=$sort&amp;from=$from&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
           <div style='margin: 0px 0px 5px 10px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Top Input</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id'].
                    "/macaccounting/$stat/top10/$period/in/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id'].
                    "&amp;stat=$stat&amp;type=port_mac_acc_total&amp;sort=in&amp;from=$from&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
           <div style='margin: 0px 0px 5px 10px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Top Output</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id'].
                    "/macaccounting/$stat/top10/$period/out/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id'].
                    "&amp;stat=$stat&amp;type=port_mac_acc_total&amp;sort=out&amp;from=$from&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
           <div style='margin: 0px 0px 5px 10px; padding:5px; background: #e5e5e5;'>
           <span class=device-head>Top Aggregate</span><br />
           <a href='".$config['base_url']."/device/" . $device['device_id'] . "/port/".$interface['interface_id'].
                    "/macaccounting/$stat/top10/$period/both/'>
             <img style='border: #5e5e5e 2px;' valign=middle src='".$config['base_url']."/graph.php?id=".$interface['interface_id'].
                    "&amp;stat=$stat&amp;type=port_mac_acc_total&amp;sort=both&amp;from=$from&amp;to=now&amp;width=150&amp;height=50' />
           </a>
           </div>
       </div>
     </div>
");
  unset($query);
  }
  else
  {

  $query = mysql_query("SELECT *, (M.cipMacHCSwitchedBytes_input_rate + M.cipMacHCSwitchedBytes_output_rate) as bps FROM `mac_accounting` AS M,
                       `ports` AS I, `devices` AS D WHERE M.interface_id = '".$interface['interface_id']."' AND I.interface_id = M.interface_id
                       AND I.device_id = D.device_id ORDER BY bps DESC");


  while ($acc = mysql_fetch_assoc($query))
  {
    if (!is_integer($i/2)) { $row_colour = $list_colour_a; } else { $row_colour = $list_colour_b; }
    $addy = mysql_fetch_assoc(mysql_query("SELECT * FROM ipv4_mac where mac_address = '".$acc['mac']."'"));
    #$name = gethostbyaddr($addy['ipv4_address']); FIXME - Maybe some caching for this?
    $arp_host = mysql_fetch_assoc(mysql_query("SELECT * FROM ipv4_addresses AS A, ports AS I, devices AS D WHERE A.ipv4_address = '".$addy['ipv4_address']."' AND I.interface_id = A.interface_id AND D.device_id = I.device_id"));
    if ($arp_host) { $arp_name = generate_device_link($arp_host); $arp_name .= " ".generate_port_link($arp_host); } else { unset($arp_if); }


    if ($name == $addy['ipv4_address']) { unset ($name); }
    if (mysql_result(mysql_query("SELECT count(*) FROM bgpPeers WHERE device_id = '".$acc['device_id']."' AND bgpPeerIdentifier = '".$addy['ipv4_address']."'"),0))
    {
      $peer_query = mysql_query("SELECT * FROM bgpPeers WHERE device_id = '".$acc['device_id']."' AND bgpPeerIdentifier = '".$addy['ipv4_address']."'");
      $peer_info = mysql_fetch_assoc($peer_query);
    } else { unset ($peer_info); }

    if ($peer_info)
    {
      $asn = "AS".$peer_info['bgpPeerRemoteAs']; $astext = $peer_info['astext'];
    } else {
      unset ($as); unset ($astext); unset($asn);
    }

    if ($_GET['optc'])
    {
      $graph_type = "macaccounting_" . $_GET['optc'];
    } else {
      $graph_type = "macaccounting_bits";
    }

    if ($_GET['optd'] == "thumbs")
    {
      if (!$asn) { $asn = "No Session"; }

     echo("<div style='display: block; padding: 3px; margin: 3px; min-width: 221px; max-width:221px; min-height:90px; max-height:90px; text-align: center; float: left; background-color: #e5e5e5;'>
      ".$addy['ipv4_address']." - ".$asn."
          <a href='#' onmouseover=\"return overlib('\
     <div style=\'font-size: 16px; padding:5px; font-weight: bold; color: #555555;\'>".$name." - ".$addy['ipv4_address']." - ".$asn."</div>\
     <img src=\'graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=-2day&amp;to=$now&amp;width=450&amp;height=150\'>\
     ', CENTER, LEFT, FGCOLOR, '#e5e5e5', BGCOLOR, '#e5e5e5', WIDTH, 400, HEIGHT, 150);\" onmouseout=\"return nd();\" >
          <img src='graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=-2day&amp;to=$now&amp;width=213&amp;height=45'></a>

          <span style='font-size: 10px;'>".$name."</span>
         </div>");

   }
   else
   {
     echo("<div style='background-color: $row_colour; padding: 0px;'>");

     echo("
      <table>
        <tr>
          <td class=list-large width=200>".mac_clean_to_readable($acc['mac'])."</td>
          <td class=list-large width=200>".$addy['ipv4_address']."</td>
          <td class=list-large width=500>".$name." ".$arp_name . "</td>
          <td class=list-large width=100>".formatRates($acc['cipMacHCSwitchedBytes_input_rate'] / 8)."</td>
          <td class=list-large width=100>".formatRates($acc['cipMacHCSwitchedBytes_output_rate'] / 8)."</td>
        </tr>
      </table>
    ");

     $peer_info['astext'];

     $graph_array['type']   = $graph_type;
     $graph_array['id']     = $acc['ma_id'];
     $graph_array['height'] = "100";
     $graph_array['width']  = "216";
     $graph_array['to']     = $now;
     echo('<tr bgcolor="'.$bg_colour.'"' . ($bg_image ? ' background="'.$bg_image.'"' : '') . '"><td colspan="7">');
     include("includes/print-quadgraphs.inc.php");
     echo("</td></tr>");

     $i++;
    }
  }
}

?>
