<?php

$scale_min = '0';
$scale_max = '60';

require 'includes/graphs/common.inc.php';

$rrd_options .= " COMMENT:'                          Min     Last   Max\\n'";

$rrd_options .= " DEF:sensor=$rrd_filename:sensor:AVERAGE";
$rrd_options .= " DEF:sensor_max=$rrd_filename:sensor:MAX";
$rrd_options .= " DEF:sensor_min=$rrd_filename:sensor:MIN";
$rrd_options .= ' CDEF:sensorwarm=sensor_max,'.$sensor['sensor_limit'].',GT,sensor,UNKN,IF';
$rrd_options .= ' CDEF:sensorcold=sensor_min,20,LT,sensor,UNKN,IF';
$rrd_options .= ' CDEF:sensor_diff=sensor_max,sensor_min,-';
$rrd_options .= ' AREA:sensor_min';
$rrd_options .= ' AREA:sensor_diff#c5c5c5::STACK';

$known_ipmi = dbFetchRows('SELECT * FROM `ipmi_sensors` WHERE `hw_id` = ?', array($device['hardware']));
if(count($known_ipmi) > 0)
{
	foreach($known_ipmi as $ipmis)
	{
		if($ipmis['sensor_ipmi'] == $sensor['sensor_descr'])
		{
			$rrd_options .= " LINE1.5:sensor#cc0000:'".rrdtool_escape($ipmis['sensor_display'], 21)."'";
		}
	} 
} else {
	$rrd_options .= " LINE1.5:sensor#cc0000:'".rrdtool_escape($sensor['sensor_descr'], 21)."'";
}

$rrd_options .= ' GPRINT:sensor_min:MIN:%4.1lfC';
$rrd_options .= ' GPRINT:sensor:LAST:%4.1lfC';
$rrd_options .= ' GPRINT:sensor_max:MAX:%4.1lfC\\l';

if (is_numeric($sensor['sensor_limit'])) {
    $rrd_options .= ' HRULE:'.$sensor['sensor_limit'].'#999999::dashes';
}

if (is_numeric($sensor['sensor_limit_low'])) {
    $rrd_options .= ' HRULE:'.$sensor['sensor_limit_low'].'#999999::dashes';
}
