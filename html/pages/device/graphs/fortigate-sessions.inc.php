<?php

if ($device['os'] == 'fortigate' || $device['os_group'] == 'fortigate') {
    $graph_title = 'Firewall Sessions';
    $graph_type  = 'fortigate_sessions';

    include 'includes/print-device-graph.php';
}
