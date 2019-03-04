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
* @subpackage webui
* @link       http://librenms.org
* @copyright  2019 LibreNMS
* @author     LibreNMS Contributors
*/

global $config;

$graphs = [
    'memcached_bits' => 'Traffic',
    'memcached_commands' => 'Commands',
    'memcached_data' => 'Data Size',
    'memcached_items' => 'Items',
    'memcached_hitmiss' => 'Hits/Misses',
    'memcached_uptime' => 'Uptime',
    'memcached_threads' => 'Threads',
];

include "app.bootstrap.inc.php";
