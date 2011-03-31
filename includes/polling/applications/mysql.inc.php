<?php

#Polls MySQL  statistics from script via SNMP

$mysql_rrd  = $config['rrd_dir'] . "/" . $device['hostname'] . "/app-mysql-".$app['app_id'].".rrd";
$mysql_cmd  = $config['snmpget'] ." -m NET-SNMP-EXTEND-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
$mysql_cmd .= " nsExtendOutputFull.5.109.121.115.113.108";

$mysql  = shell_exec($mysql_cmd);

echo(" mysql...");

$data = explode("\n", $mysql);

for ($a=0,$n=count($data);$a<$n;$a++)
{
        $elements = explode(":",$data[$a]);
        $nstring .= (float)trim($elements[1]).":";
        unset($elements);
}

#$data = explode("\n", $mysql);
#$nstring = trim(implode(':',$data),':');

if (!is_file($mysql_rrd)) {
    rrdtool_create ($mysql_rrd, "--step 300 \
	DS:IDBLBSe:GAUGE:600:0:125000000000 \
	DS:IBLFh:DERIVE:600:0:125000000000 \
	DS:IBLWn:DERIVE:600:0:125000000000 \
	DS:SRows:DERIVE:600:0:125000000000 \
	DS:SRange:DERIVE:600:0:125000000000 \
	DS:SMPs:DERIVE:600:0:125000000000 \
	DS:SScan:DERIVE:600:0:125000000000 \
	DS:IBIRd:DERIVE:600:0:125000000000 \
	DS:IBIWr:DERIVE:600:0:125000000000 \
	DS:IBILg:DERIVE:600:0:125000000000 \
	DS:IBIFSc:DERIVE:600:0:125000000000 \
	DS:IDBRDd:DERIVE:600:0:125000000000 \
	DS:IDBRId:DERIVE:600:0:125000000000 \
	DS:IDBRRd:DERIVE:600:0:125000000000 \
	DS:IDBRUd:DERIVE:600:0:125000000000 \
	DS:IBRd:DERIVE:600:0:125000000000 \
	DS:IBCd:DERIVE:600:0:125000000000 \
	DS:IBWr:DERIVE:600:0:125000000000 \
	DS:TLIe:DERIVE:600:0:125000000000 \
	DS:TLWd:DERIVE:600:0:125000000000 \
	DS:IBPse:GAUGE:600:0:125000000000 \
	DS:IBPDBp:GAUGE:600:0:125000000000 \
	DS:IBPFe:GAUGE:600:0:125000000000 \
	DS:IBPMps:GAUGE:600:0:125000000000 \
	DS:TOC:GAUGE:600:0:125000000000 \
	DS:OFs:GAUGE:600:0:125000000000 \
	DS:OTs:GAUGE:600:0:125000000000 \
	DS:OdTs:GAUGE:600:0:125000000000 \
	DS:IBSRs:DERIVE:600:0:125000000000 \
	DS:IBSWs:DERIVE:600:0:125000000000 \
	DS:IBOWs:DERIVE:600:0:125000000000 \
	DS:QCs:GAUGE:600:0:125000000000 \
	DS:QCeFy:GAUGE:600:0:125000000000 \
	DS:MaCs:GAUGE:600:0:125000000000 \
	DS:MUCs:GAUGE:600:0:125000000000 \
	DS:ACs:DERIVE:600:0:125000000000 \
	DS:AdCs:DERIVE:600:0:125000000000 \
	DS:TCd:GAUGE:600:0:125000000000 \
	DS:Cs:DERIVE:600:0:125000000000 \
	DS:IBTNx:DERIVE:600:0:125000000000 \
	DS:KRRs:DERIVE:600:0:125000000000 \
	DS:KRs:DERIVE:600:0:125000000000 \
	DS:KWR:DERIVE:600:0:125000000000 \
	DS:KWs:DERIVE:600:0:125000000000 \
	DS:QCQICe:DERIVE:600:0:125000000000 \
	DS:QCHs:DERIVE:600:0:125000000000 \
	DS:QCIs:DERIVE:600:0:125000000000 \
	DS:QCNCd:DERIVE:600:0:125000000000 \
	DS:QCLMPs:DERIVE:600:0:125000000000 \
	DS:CTMPDTs:DERIVE:600:0:125000000000 \
	DS:CTMPTs:DERIVE:600:0:125000000000 \
	DS:CTMPFs:DERIVE:600:0:125000000000 \
	DS:IBIIs:DERIVE:600:0:125000000000 \
	DS:IBIMRd:DERIVE:600:0:125000000000 \
	DS:IBIMs:DERIVE:600:0:125000000000 \
	DS:IBILog:DERIVE:602:0:125000000000 \
	DS:IBISc:DERIVE:602:0:125000000000 \
	DS:IBIFLg:DERIVE:600:0:125000000000 \
	DS:IBFBl:DERIVE:600:0:125000000000 \
	DS:IBIIAo:DERIVE:600:0:125000000000 \
	DS:IBIAd:DERIVE:600:0:125000000000 \
	DS:IBIAe:DERIVE:600:0:125000000000 \
	DS:SFJn:DERIVE:600:0:125000000000 \
	DS:SFRJn:DERIVE:600:0:125000000000 \
	DS:SRe:DERIVE:600:0:125000000000 \
	DS:SRCk:DERIVE:600:0:125000000000 \
	DS:SSn:DERIVE:600:0:125000000000 \
	DS:SQs:DERIVE:600:0:125000000000 \
	DS:BRd:DERIVE:600:0:125000000000 \
	DS:BSt:DERIVE:600:0:125000000000 \
	DS:CDe:DERIVE:600:0:125000000000 \
	DS:CIt:DERIVE:600:0:125000000000 \
	DS:CISt:DERIVE:600:0:125000000000 \
	DS:CLd:DERIVE:600:0:125000000000 \
	DS:CRe:DERIVE:600:0:125000000000 \
	DS:CRSt:DERIVE:600:0:125000000000 \
	DS:CSt:DERIVE:600:0:125000000000 \
	DS:CUe:DERIVE:600:0:125000000000 \
	DS:CUMi:DERIVE:600:0:125000000000 \
	RRA:AVERAGE:0.5:1:600 \
	RRA:AVERAGE:0.5:6:700 \
	RRA:AVERAGE:0.5:24:775 \
	RRA:AVERAGE:0.5:288:797 \
	RRA:MIN:0.5:1:600 \
	RRA:MIN:0.5:6:700 \
	RRA:MIN:0.5:24:775 \
	RRA:MIN:0.5:3:600 \
	RRA:MAX:0.5:1:600 \
	RRA:MAX:0.5:6:700 \
	RRA:MAX:0.5:24:775 \
	RRA:MAX:0.5:288:797");
}

rrdtool_update($mysql_rrd, "N:$nstring");
echo("done ");
?>
