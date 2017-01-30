<?php
/**
 * hpe-msl.inc.php
 *
 * LibreNMS os poller module for HPE MSL
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
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

$hardware_array = snmp_get_multi($device, 'hpHttpMgDeviceProductName.1 hpHttpMgDeviceSerialNumber.1 hpHttpMgDeviceVersion.1', '-OQUs', 'SEMI-MIB');
d_echo($hardware_array);
$hardware  = trim($hardware_array[0]['hpHttpMgDeviceProductName'], '"');
$serial  = trim($hardware_array[0]['hpHttpMgDeviceSerialNumber'], '"');
$version  = trim($hardware_array[0]['hpHttpMgDeviceVersion'], '"');
