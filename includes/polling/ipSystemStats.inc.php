<?php

#IP-MIB::ipSystemStatsInReceives.ipv4 = Counter32: 1062322382
#IP-MIB::ipSystemStatsInReceives.ipv6 = Counter32: 5229983
#IP-MIB::ipSystemStatsHCInReceives.ipv4 = Counter64: 1062322382
#IP-MIB::ipSystemStatsHCInReceives.ipv6 = Counter64: 5229983
#IP-MIB::ipSystemStatsHCInOctets.ipv4 = Counter64: 0
#IP-MIB::ipSystemStatsHCInOctets.ipv6 = Counter64: 0
#IP-MIB::ipSystemStatsInHdrErrors.ipv4 = Counter32: 199
#IP-MIB::ipSystemStatsInHdrErrors.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsInAddrErrors.ipv4 = Counter32: 0
#IP-MIB::ipSystemStatsInAddrErrors.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsInUnknownProtos.ipv4 = Counter32: 1
#IP-MIB::ipSystemStatsInUnknownProtos.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsInForwDatagrams.ipv4 = Counter32: 4350883
#IP-MIB::ipSystemStatsInForwDatagrams.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsHCInForwDatagrams.ipv4 = Counter64: 4350883
#IP-MIB::ipSystemStatsHCInForwDatagrams.ipv6 = Counter64: 0
#IP-MIB::ipSystemStatsReasmReqds.ipv4 = Counter32: 0
#IP-MIB::ipSystemStatsReasmReqds.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsReasmOKs.ipv4 = Counter32: 573
#IP-MIB::ipSystemStatsReasmOKs.ipv6 = Counter32: 191
#IP-MIB::ipSystemStatsReasmFails.ipv4 = Counter32: 2
#IP-MIB::ipSystemStatsReasmFails.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsInDiscards.ipv4 = Counter32: 0
#IP-MIB::ipSystemStatsInDiscards.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsInDelivers.ipv4 = Counter32: 1053500708
#IP-MIB::ipSystemStatsInDelivers.ipv6 = Counter32: 5229756
#IP-MIB::ipSystemStatsHCInDelivers.ipv4 = Counter64: 1053500708
#IP-MIB::ipSystemStatsHCInDelivers.ipv6 = Counter64: 5229756
#IP-MIB::ipSystemStatsOutRequests.ipv4 = Counter32: 874021272
#IP-MIB::ipSystemStatsOutRequests.ipv6 = Counter32: 5157066
#IP-MIB::ipSystemStatsHCOutRequests.ipv4 = Counter64: 874021272
#IP-MIB::ipSystemStatsHCOutRequests.ipv6 = Counter64: 5157066
#IP-MIB::ipSystemStatsOutNoRoutes.ipv4 = Counter32: 1
#IP-MIB::ipSystemStatsOutNoRoutes.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsHCOutForwDatagrams.ipv4 = Counter64: 0
#IP-MIB::ipSystemStatsHCOutForwDatagrams.ipv6 = Counter64: 0
#IP-MIB::ipSystemStatsOutDiscards.ipv4 = Counter32: 205
#IP-MIB::ipSystemStatsOutDiscards.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsOutFragFails.ipv4 = Counter32: 0
#IP-MIB::ipSystemStatsOutFragFails.ipv6 = Counter32: 0
#IP-MIB::ipSystemStatsOutFragCreates.ipv4 = Counter32: 0
#IP-MIB::ipSystemStatsOutFragCreates.ipv6 = Counter32: 68
#IP-MIB::ipSystemStatsDiscontinuityTime.ipv4 = Timeticks: (0) 0:00:00.00
#IP-MIB::ipSystemStatsDiscontinuityTime.ipv6 = Timeticks: (0) 0:00:00.00
#IP-MIB::ipSystemStatsRefreshRate.ipv4 = Gauge32: 30000 milli-seconds
#IP-MIB::ipSystemStatsRefreshRate.ipv6 = Gauge32: 30000 milli-seconds

  echo("Polling IP-MIB ipSystemStats ");

  $ipSystemStats = snmpwalk_cache_oid($device, "ipSystemStats", NULL, "IP-MIB");

 if($ipSystemStats) {

  foreach($ipSystemStats as $af => $stats) {

   echo("$af ");

    $oids = array('ipSystemStatsInReceives','ipSystemStatsInHdrErrors','ipSystemStatsInAddrErrors','ipSystemStatsInUnknownProtos','ipSystemStatsInForwDatagrams','ipSystemStatsReasmReqds',
                  'ipSystemStatsReasmOKs','ipSystemStatsReasmFails','ipSystemStatsInDiscards','ipSystemStatsInDelivers','ipSystemStatsOutRequests','ipSystemStatsOutNoRoutes','ipSystemStatsOutDiscards',
                  'ipSystemStatsOutFragFails','ipSystemStatsOutFragCreates','ipSystemStatsOutForwDatagrams');

    ### Use HC counters instead if they're available.
    if(isset($stats['ipSystemStatsHCInReceives']))       { $stats['ipSystemStatsInReceives']       = $stats['ipSystemStatsHCInReceives']; }
    if(isset($stats['ipSystemStatsHCInForwDatagrams']))  { $stats['ipSystemStatsInForwDatagrams']  = $stats['ipSystemStatsHCInForwDatagrams']; }
    if(isset($stats['ipSystemStatsHCInDelivers']))       { $stats['ipSystemStatsInDelivers']       = $stats['ipSystemStatsHCInDelivers']; }
    if(isset($stats['ipSystemStatsHCOutRequests']))      { $stats['ipSystemStatsOutRequests']      = $stats['ipSystemStatsHCOutRequests']; }
    if(isset($stats['ipSystemStatsHCOutForwDatagrams'])) { $stats['ipSystemStatsOutForwDatagrams'] = $stats['ipSystemStatsHCOutForwDatagrams']; }

    unset($snmpstring, $rrdupdate, $snmpdata, $snmpdata_cmd, $rrd_create);

    $rrdfile = $config['rrd_dir'] . "/" . $device['hostname'] . "/" . safename("ipSystemStats-".$af.".rrd");

    $rrd_create = $config['rrdtool'] . " create $rrdfile ";
    $rrd_create .= "RRA:AVERAGE:0.5:1:600 RRA:AVERAGE:0.5:6:700 RRA:AVERAGE:0.5:24:775 RRA:AVERAGE:0.5:288:797 RRA:MAX:0.5:1:600 RRA:MAX:0.5:6:700 RRA:MAX:0.5:24:775 RRA:MAX:0.5:288:797";
    
    $rrdupdate = "N";

    foreach($oids as $oid){
      $oid_ds = str_replace("ipSystemStats", "", $oid);
      $oid_ds = truncate($oid_ds, 19, '');
      $rrd_create .= " DS:$oid_ds:COUNTER:600:U:100000000000";
      if(strstr($stats[$oid], "No") || strstr($stats[$oid], "d") || strstr($stats[$oid], "s")) { $stats[$oid] = "0"; }
      $rrdupdate  .= ":".$stats[$oid]; 
    }
    if(!file_exists($rrdfile)) { shell_exec($rrd_create); }
    rrdtool_update($rrdfile, $rrdupdate);
    unset($rrdupdate, $rrd_create);

    ## FIXME per-AF?
    
    $graphs['ipsystemstats_'.$af] = TRUE;
    $graphs['ipsystemstats_'.$af.'_frag'] = TRUE;
  }
 }

echo("\n");


?>
