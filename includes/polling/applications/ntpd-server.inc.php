<?php

## Polls ntpd-server statistics from script via SNMP

$rrd_filename = $config['rrd_dir'] . "/" . $device['hostname'] . "/app-ntpdserver-".$app['app_id'].".rrd";
$options      = "-O qv";
$oid          = "nsExtendOutputFull.10.110.116.112.100.115.101.114.118.101.114";

$ntpdserver   = snmp_get($device, $oid, $options);

echo(" ntpd-server");

list ($stratum, $offset, $frequency, $jitter, $noise, $stability, $uptime, $buffer_recv, $buffer_free, $buffer_used, $packets_drop, $packets_ignore, $packets_recv, $packets_sent) = explode("\n", $ntpdserver);

if (!is_file($rrd_filename))
{
  rrdtool_create($rrd_filename, "--step 300 \
        DS:stratum:GAUGE:600:-100:125000000000 \
        DS:offset:GAUGE:600:-100:125000000000 \
        DS:frequency:GAUGE:600:-100:125000000000 \
        DS:jitter:GAUGE:600:-100:125000000000 \
        DS:noise:GAUGE:600:-100:125000000000 \
        DS:stability:GAUGE:600:-100:125000000000 \
        DS:uptime:GAUGE:600:0:125000000000 \
        DS:buffer_recv:GAUGE:600:0:125000000000 \
        DS:buffer_free:GAUGE:600:0:125000000000 \
        DS:buffer_used:GAUGE:600:0:125000000000 \
        DS:packets_drop:DERIVE:600:0:125000000000 \
        DS:packets_ignore:DERIVE:600:0:125000000000 \
        DS:packets_recv:DERIVE:600:0:125000000000 \
        DS:packets_sent:DERIVE:600:0:125000000000 \
        RRA:AVERAGE:0.5:1:600 \
        RRA:AVERAGE:0.5:6:700 \
        RRA:AVERAGE:0.5:24:775 \
        RRA:AVERAGE:0.5:288:797 \
        RRA:MIN:0.5:1:600 \
        RRA:MIN:0.5:6:700 \
        RRA:MIN:0.5:24:775 \
        RRA:MIN:0.5:288:797 \
        RRA:MAX:0.5:1:600 \
        RRA:MAX:0.5:6:700 \
        RRA:MAX:0.5:24:775 \
        RRA:MAX:0.5:288:797");
}

rrdtool_update($rrd_filename,  "N:$stratum:$offset:$frequency:$jitter:$noise:$stability:$uptime:$buffer_recv:$buffer_free:$buffer_used:$packets_drop:$packets_ignore:$packets_recv:$packets_sent");

?>
