<?php
/**
 * cmts.inc.php
 *
 * LibreNMS os sensor pre-cache module for Arris CMTS
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
 * @copyright  2018 TheGreatDoc
 * @author     TheGreatDoc
 * Based on Neil Lathwood Cisco EPC files
 */

echo 'ifName ';
$pre_cache['cmts_ifName'] = snmpwalk_cache_oid($device, 'ifName', array(), 'DOCS-IF-MIB');

echo 'ifAlias ';
$pre_cache['cmts_ifAlias'] = snmpwalk_cache_oid($device, 'ifAlias', array(), 'DOCS-IF-MIB');

echo 'docsIfSignalQualityTable ';
$pre_cache['cmts_docsIfSignalQualityTable'] = snmpwalk_cache_oid($device, 'docsIfSignalQualityTable', array(), 'DOCS-IF-MIB');
