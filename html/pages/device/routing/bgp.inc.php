<div style='padding: 10px; height: 20px; clear: both; display: block;'>
  <div style='float: left; font-size: 22px; font-weight: bold;'>Local AS : <?php echo($device['bgpLocalAs']); ?></div>
</div>

<?php
print_optionbar_start();

echo("
  <div style='margin: auto; text-align: left; padding-left: 11px; clear: both; display:block; height:20px;'>");

  if (!isset($_GET['optb'])) { echo("<span class='pagemenu-selected'>"); }
  echo("<a href='/device/" . $device['device_id'] . "/routing/bgp/'>Basic</a>");
  if (!isset($_GET['optb'])) { echo("</span>"); }

  echo(" | ");

  if ($_GET['optb'] == "updates") { echo("<span class='pagemenu-selected'>"); }
  echo("<a href='/device/" . $device['device_id'] . "/routing/bgp/updates/'>Updates</a>");
  if ($_GET['optb'] == "updates") { echo("</span>"); }

  echo(" | Prefixes: ");

  if ($_GET['optb'] == "prefixes" && $_GET['optc'] == "ipv4.unicast") { echo("<span class='pagemenu-selected'>"); }
  echo("<a href='".$config['base_url']."/device/" . $device['device_id'] . "/routing/bgp/prefixes/ipv4.unicast/'>IPv4</a>");
  if ($_GET['optb'] == "prefixes" && $_GET['optc'] == "ipv4.unicast") { echo("</span>"); }

  echo(" | ");

  if ($_GET['optb'] == "prefixes" && $_GET['optc'] == "vpnv4.unicast") { echo("<span class='pagemenu-selected'>"); }
  echo("<a href='".$config['base_url']."/device/" . $device['device_id'] . "/routing/bgp/prefixes/vpnv4.unicast/'>VPNv4</a>");
  if ($_GET['optb'] == "prefixes" && $_GET['optc'] == "vpnv4.unicast") { echo("</span>"); }

  echo(" | ");

  if ($_GET['optb'] == "prefixes" && $_GET['optc'] == "ipv6.unicast") { echo("<span class='pagemenu-selected'>"); }
  echo("<a href='".$config['base_url']."/device/" . $device['device_id'] . "/routing/bgp/prefixes/ipv6.unicast/'>IPv6</a>");
  if ($_GET['optb'] == "prefixes" && $_GET['optc'] == "ipv6.unicast") { echo("</span>"); }

  echo(" | Traffic: ");

  if ($_GET['optb'] == "macaccounting") { echo("<span class='pagemenu-selected'>"); }
  echo("<a href='".$config['base_url']."/device/" . $device['device_id'] . "/routing/bgp/macaccounting/'>Mac Accounting</a>");
  if ($_GET['optb'] == "macaccounting") { echo("</span>"); }

echo("</div>
");

print_optionbar_end();
?>

<div style="margin: 5px;"><table border="0" cellspacing="0" cellpadding="5" width="100%">

<?php
$i = "1";
$peer_query = mysql_query("select * from bgpPeers WHERE device_id = '".$device['device_id']."' ORDER BY bgpPeerRemoteAs, bgpPeerIdentifier");

while ($peer = mysql_fetch_assoc($peer_query))
{
  $has_macaccounting = mysql_result(mysql_query("SELECT COUNT(*) FROM `ipv4_mac` AS I, mac_accounting AS M WHERE I.ipv4_address = '".$peer['bgpPeerIdentifier']."' AND M.mac = I.mac_address"),0);
  unset($bg_image);
  if (!is_integer($i/2)) { $bg_colour = $list_colour_a; } else { $bg_colour = $list_colour_b; }
  #if ($peer['bgpPeerAdminStatus'] == "start") { $img = "images/16/accept.png"; } else { $img = "images/16/delete.png"; }
  if ($peer['bgpPeerState'] == "established") { $col = "green"; } else { $col = "red"; $bg_image = "images/warning-background.png"; }
  if ($peer['bgpPeerAdminStatus'] == "start" || $peer['bgpPeerAdminStatus'] == "running") { $admin_col = "green"; } else { $admin_col = "red"; $bg_image = "images/warning-background.png"; }

  if ($peer['bgpPeerRemoteAs'] == $device['bgpLocalAs']) { $peer_type = "<span style='color: #00f;'>iBGP</span>"; } else { $peer_type = "<span style='color: #0a0;'>eBGP</span>"; }

  $query = "SELECT * FROM ipv4_addresses AS A, ports AS I, devices AS D WHERE ";
  $query .= "(A.ipv4_address = '".$peer['bgpPeerIdentifier']."' AND I.interface_id = A.interface_id)";
  $query .= " AND D.device_id = I.device_id";
  $ipv4_host = mysql_fetch_assoc(mysql_query($query));

  $query = "SELECT * FROM ipv6_addresses AS A, ports AS I, devices AS D WHERE ";
  $query .= "(A.ipv6_address = '".$peer['bgpPeerIdentifier']."' AND I.interface_id = A.interface_id)";
  $query .= " AND D.device_id = I.device_id";
  $ipv6_host = mysql_fetch_assoc(mysql_query($query));

  if ($ipv4_host)
  {
    $peerhost = $ipv4_host;
  }
  elseif ($ipv6_host)
  {
    $peerhost = $ipv6_host;
  }
  else
  {
    unset($peerhost);
  }

  if ($peerhost)
  {
    $peername = generate_device_link($peerhost);
  }
  else
  {
    #$peername = gethostbyaddr($peer['bgpPeerIdentifier']); ## FFffuuu DNS
    if ($peername == $peer['bgpPeerIdentifier'])
    {
      unset($peername);
    } else {
      $peername = "<i>".$peername."<i>";
    }
  }

  $af_query = mysql_query("SELECT * FROM `bgpPeers_cbgp` WHERE `device_id` = '".$device['device_id']."' AND bgpPeerIdentifier = '".$peer['bgpPeerIdentifier']."'");
  unset($peer_af);

  while ($afisafi = mysql_fetch_assoc($af_query))
  {
    $afi = $afisafi['afi'];
    $safi = $afisafi['safi'];
    $peer_af .= $sep . $config['afi'][$afi][$safi];          ##### CLEAN ME UP, I AM MESSY AND I SMELL OF CHEESE!
    $sep = "<br />";
    $valid_afi_safi[$afi][$safi] = 1; ## Build a list of valid AFI/SAFI for this peer
  }

  unset($sep);

  $graph_type       = "bgp_updates";
  $peer_daily_url   = "graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=" . $graph_type . "&amp;from=$day&amp;to=$now&amp;width=500&amp;height=150";
  $peeraddresslink  = "<span class=list-large><a href='device/" . $peer['device_id'] . "/routing/bgp/updates/' onmouseover=\"return overlib('<img src=\'$peer_daily_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\">" . $peer['bgpPeerIdentifier'] . "</a></span>";

  echo("<tr bgcolor=$bg_colour background=$bg_image>
           <td width=20><span class=list-large>$i</span></td>
           <td>" . $peeraddresslink . "<br />".generate_device_link($peer, shorthost($peer['hostname']), 'bgp/')."</td>
	     <td>$peer_type</td>
           <td style='font-size: 10px; font-weight: bold; line-height: 10px;'>" . (isset($peer_af) ? $peer_af : '') . "</td>
           <td><strong>AS" . $peer['bgpPeerRemoteAs'] . "</strong><br />" . $peer['astext'] . "</td>
           <td><strong><span style='color: $admin_col;'>" . $peer['bgpPeerAdminStatus'] . "<span><br /><span style='color: $col;'>" . $peer['bgpPeerState'] . "</span></strong></td>
           <td>" .formatUptime($peer['bgpPeerFsmEstablishedTime']). "<br />
               Updates <img src='images/16/arrow_down.png' align=absmiddle> " . $peer['bgpPeerInUpdates'] . "
                       <img src='images/16/arrow_up.png' align=absmiddle> " . $peer['bgpPeerOutUpdates'] . "</td></tr>");

  if (isset($_GET['optb']) && $_GET['optb'] != "macaccounting")
  {
    foreach (explode(" ", $_GET['optb']) as $graph_type)
    {
      if ($graph_type == "prefixes") { list($afi, $safi) = explode(".", $_GET['optc']); $afisafi = "&amp;afi=$afi&amp;safi=$safi"; }
      if ($graph_type == "updates" || $valid_afi_safi[$afi][$safi])
      {
        $daily_traffic   = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$day&amp;to=$now&amp;width=210&amp;height=100$afisafi";
        $daily_url       = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$day&amp;to=$now&amp;width=500&amp;height=150$afisafi";
        $weekly_traffic  = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$week&amp;to=$now&amp;width=210&amp;height=100$afisafi";
        $weekly_url      = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$week&amp;to=$now&amp;width=500&amp;height=150$afisafi";
        $monthly_traffic = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$month&amp;to=$now&amp;width=210&amp;height=100$afisafi";
        $monthly_url     = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$month&amp;to=$now&amp;width=500&amp;height=150$afisafi";
        $yearly_traffic  = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$year&amp;to=$now&amp;width=210&amp;height=100$afisafi";
        $yearly_url      = $config['base_url'] . "/graph.php?id=" . $peer['bgpPeer_id'] . "&amp;type=bgp_$graph_type&amp;from=$year&amp;to=$now&amp;width=500&amp;height=150$afisafi";
        echo("<tr bgcolor=$bg_colour><td colspan=7>");
        echo("<a href='' onmouseover=\"return overlib('<img src=\'$daily_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\"><img src='$daily_traffic' border=0></a> ");
        echo("<a href='' onmouseover=\"return overlib('<img src=\'$weekly_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\"><img src='$weekly_traffic' border=0></a> ");
        echo("<a href='' onmouseover=\"return overlib('<img src=\'$monthly_url\'>', LEFT".$config['overlib_defaults'].", WIDTH, 350);\" onmouseout=\"return nd();\"><img src='$monthly_traffic' border=0></a> ");
        echo("<a href='' onmouseover=\"return overlib('<img src=\'$yearly_url\'>', LEFT".$config['overlib_defaults'].", WIDTH, 350);\" onmouseout=\"return nd();\"><img src='$yearly_traffic' border=0></a>");
        echo("</td></tr>");
      }
    }
  }

  if ($_GET['opta'] == "macaccounting" && $has_macaccounting)
  {
    $acc = mysql_fetch_assoc(mysql_query("SELECT * FROM `ipv4_mac` AS I, mac_accounting AS M, ports AS P WHERE I.ipv4_address = '".$peer['bgpPeerIdentifier']."' AND M.mac = I.mac_address AND P.interface_id = M.interface_id"));
    $graph_type = "mac_acc_bits";
    $database = $config['rrd_dir'] . "/" . $device['hostname'] . "/cip-" . $acc['ifIndex'] . "-" . $acc['mac'] . ".rrd";
    if (is_file($database))
    {
      $daily_traffic   = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$day&amp;to=$now&amp;width=210&amp;height=100";
      $daily_url       = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$day&amp;to=$now&amp;width=500&amp;height=150";
      $weekly_traffic  = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$week&amp;to=$now&amp;width=210&amp;height=100";
      $weekly_url      = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$week&amp;to=$now&amp;width=500&amp;height=150";
      $monthly_traffic = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$month&amp;to=$now&amp;width=210&amp;height=100";
      $monthly_url     = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$month&amp;to=$now&amp;width=500&amp;height=150";
      $yearly_traffic  = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$year&amp;to=$now&amp;width=210&amp;height=100";
      $yearly_url      = "graph.php?id=" . $acc['ma_id'] . "&amp;type=$graph_type&amp;from=$year&amp;to=$now&amp;width=500&amp;height=150";
      echo("<tr bgcolor=$bg_colour><td colspan=7>");
      echo("<a href='?page=interface&amp;id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$daily_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\">
        <img src='$daily_traffic' border=0></a> ");
      echo("<a href='?page=interface&amp;id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$weekly_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\">
        <img src='$weekly_traffic' border=0></a> ");
      echo("<a href='?page=interface&amp;id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$monthly_url\'>', LEFT".$config['overlib_defaults'].", WIDTH, 350);\" onmouseout=\"return nd();\">
        <img src='$monthly_traffic' border=0></a> ");
      echo("<a href='?page=interface&amp;id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$yearly_url\'>', LEFT".$config['overlib_defaults'].", WIDTH, 350);\" onmouseout=\"return nd();\">
        <img src='$yearly_traffic' border=0></a>");
      echo("</td></tr>");
    }
  }

  $i++;
  unset($valid_afi_safi);
}
?>

</table></div>
