<?php

if (is_file(rrd_name($device['hostname'], 'ucd_mem'))) {
    $graph_title = 'Memory Utilisation';
    $graph_type  = 'device_memory';

    include 'includes/print-device-graph.php';
}
