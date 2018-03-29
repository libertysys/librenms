<?php
/**
 * acos.inc.php
 *
 * LibreNMS mempools discovery module for A10 ACOS
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
 * @copyright  2017 Neil Lathwood
 * @author     Neil Lathwood <gh+n@laf.io>
 */

if ($device['os'] === 'acos') {
    echo 'ACOS: ';
    $usage = snmp_get($device, 'axSysMemoryUsage.0', '-Ovq', 'A10-AX-MIB');
    if (is_numeric($usage)) {
        discover_mempool($valid_mempool, $device, 0, 'acos', 'System Memory', '1024', null, null);
    }
}
