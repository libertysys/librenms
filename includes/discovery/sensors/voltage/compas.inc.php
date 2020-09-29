<?php
/**
 * compas.inc.php
 *
 * LibreNMS voltage sensor discovery module for Alpha Comp@s UPS
 *
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
 * @link       http://librenms.org
 * @copyright  2019 Paul Parsons
 * @author     Paul Parsons <paul@cppmonkey.net>
 */
$busVoltage = snmp_get($device, 'es1dc1DataDCBusBusVoltage.0', '-Ovqe', 'SITE-MONITORING-MIB');
$curOID = '.1.3.6.1.4.1.26854.3.2.1.20.1.20.1.13.3.11.0';
$index = 0;
if (is_numeric($busVoltage)) {
    $sensorType = 'compas';
    $descr = 'DC Bus Voltage';
    discover_sensor($valid['sensor'], 'voltage', $device, $curOID, $index, $sensorType, $descr, '1', '1', null, null, null, null, $busVoltage);
}
