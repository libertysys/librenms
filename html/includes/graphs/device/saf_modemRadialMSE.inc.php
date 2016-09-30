<?php

require 'includes/graphs/common.inc.php';

$rrdfilename = $config['rrd_dir'].'/'.$device['hostname'].'/saf.rrd';

if (file_exists($rrdfilename)) {
    $rrd_options .= ' COMMENT:"  Now        Min         Max\r" ';
    $rrd_options .= ' DEF:modemRadialMSE='.$rrdfilename.':modemRadialMSE:AVERAGE ';
    $rrd_options .= ' CDEF:dividedMSE=modemRadialMSE,10,/ ';
    $rrd_options .= ' LINE1:dividedMSE#CC0000:"Radial MSE\l" ';
    $rrd_options .= ' COMMENT:\u ';
    $rrd_options .= ' GPRINT:dividedMSE:LAST:"%3.2lf dB" ';
    $rrd_options .= ' GPRINT:dividedMSE:MIN:"%3.2lf dB" ';
    $rrd_options .= ' GPRINT:dividedMSE:MAX:"%3.2lf dB\r" ';
}
