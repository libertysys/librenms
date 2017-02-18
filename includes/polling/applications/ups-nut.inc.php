<?php
/*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    LibreNMS
* @link       http://librenms.org
* @copyright  2016 crcro
* @author     Cercel Valentin <crc@nuamchefazi.ro>
*
*/

// (2016-11-25, R.Morris) ups-nut, try "extend" -> if not, fall back to "exec" support.
// -> Similar to approach used by Distro, but skip "legacy UCD-MIB shell support"
//
//NET-SNMP-EXTEND-MIB::nsExtendOutputFull."ups-nut"
$name = 'ups-nut';
$app_id = $app['app_id'];
$oid = '.1.3.6.1.4.1.8072.1.3.2.3.1.2.7.117.112.115.45.110.117.116';
$ups_nut = snmp_get($device, $oid, '-Oqv');

// If "extend" (used above) fails, try "exec" support.
// Note, exec always splits outputs on newline, so need to use snmp_walk (not a single SNMP entry!)
if (!$ups_nut) {
    // Data is in an array, due to how "exec" works with ups-nut.sh output, so snmp_walk to retrieve it
    $oid = '.1.3.6.1.4.1.2021.7890.2.101';
    $ups_nut=snmp_walk($device, $oid, '-Oqv');
}
//print_r(array_values(explode("\n", $ups_nut)));

echo ' '.$name;

// (2016-11-25, R.Morris) Correct list and data below, to match latest ups-nut.sh script (missing one input, and misaligned).
list ($charge, $battery_low, $remaining, $bat_volt, $bat_nom, $line_nom, $input_volt, $load) = explode("\n", $ups_nut);

$rrd_name = array('app', $name, $app_id);
$rrd_def = array(
    'DS:charge:GAUGE:'.$config['rrd']['heartbeat'].':0:100',
    'DS:battery_low:GAUGE:'.$config['rrd']['heartbeat'].':0:100',
    'DS:time_remaining:GAUGE:'.$config['rrd']['heartbeat'].':0:U',
    'DS:battery_voltage:GAUGE:'.$config['rrd']['heartbeat'].':0:U',
    'DS:battery_nominal:GAUGE:'.$config['rrd']['heartbeat'].':0:U',
    'DS:line_nominal:GAUGE:'.$config['rrd']['heartbeat'].':0:U',
    'DS:input_voltage:GAUGE:'.$config['rrd']['heartbeat'].':0:U',
    'DS:load:GAUGE:'.$config['rrd']['heartbeat'].':0:100'
);
//print_r(array_values($rrd_def));

$fields = array(
    'charge' => $charge,
    'battery_low' => $battery_low,
    'time_remaining' => $remaining/60,
    'battery_voltage' => $bat_volt,
    'battery_nominal' => $bat_nom,
    'line_nominal' => $line_nom,
    'input_voltage' => $input_volt,
    'load' => $load
);
//print_r(array_values($fields));

$tags = compact('name', 'app_id', 'rrd_name', 'rrd_def');
data_update($device, 'app', $tags, $fields);
