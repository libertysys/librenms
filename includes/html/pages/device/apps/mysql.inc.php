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
* @copyright  2020 LibreNMS
* @author     Cercel Valentin <crc@nuamchefazi.ro>
*/

$graphs = array(
    'mysql_command_counters' => 'Commands',
    'mysql_connections' => 'Connections',
    'mysql_files_tables' => 'Files and tables',
    'mysql_innodb_buffer_pool' => 'InnoDB Buffer pool',
    'mysql_innodb_buffer_pool_activity' => 'InnoDB Buffer pool activity',
    'mysql_innodb_insert_buffer' => 'InnoDB Insert buffer',
    'mysql_innodb_io' => 'InnoDB I/O',
    'mysql_innodb_io_pending' => 'InnoDB I/O Pending',
    'mysql_innodb_log' => 'InnoDB log',
    'mysql_innodb_row_operations' => 'InnoDB operations',
    'mysql_innodb_semaphores' => 'InnoDB Semaphores',
    'mysql_innodb_transactions' => 'InnoDB Transactions',
    'mysql_myisam_indexes' => 'MyISAM Indexes',
    'mysql_network_traffic' => 'Network traffic',
    'mysql_query_cache' => 'Query cache',
    'mysql_query_cache_memory' => 'Query cache memory',
    'mysql_select_types' => 'Select types',
    'mysql_slow_queries' => 'Slow queries',
    'mysql_sorts' => 'Sorts',
    'mysql_table_locks' => 'Table locks',
    'mysql_temporary_objects' => 'Temporary objects',
);

foreach ($graphs as $key => $text) {
    $graph_type = $key;
    $graph_array['height'] = '100';
    $graph_array['width'] = '215';
    $graph_array['to'] = \LibreNMS\Config::get('time.now');
    $graph_array['id'] = $app['app_id'];
    $graph_array['type'] = 'application_' . $key;

    echo '<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">' . $text . '</h3>
    </div>
    <div class="panel-body">
    <div class="row">';
    include 'includes/html/print-graphrow.inc.php';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
