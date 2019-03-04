<?php
/*
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       http://librenms.org
 * @copyright  2019 LibreNMS
 * @author     Cercel Valentin <crc@nuamchefazi.ro>
*/

global $config;

$graphs = [
    'powerdns-dnsdist_latency' => 'Latency',
    'powerdns-dnsdist_cache' => 'Cache',
    'powerdns-dnsdist_downstream' => 'Downstream servers',
    'powerdns-dnsdist_dynamic_blocks' => 'Dynamic blocks',
    'powerdns-dnsdist_rules_stats' => 'Rules stats',
    'powerdns-dnsdist_queries_stats' => 'Queries stats',
    'powerdns-dnsdist_queries_latency' => 'Queries latency',
    'powerdns-dnsdist_queries_drop' => 'Queries drop',
];

include 'app.bootstrap.inc.php';
