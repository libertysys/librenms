<?php

$rrd_filename = rrd_name($device['hostname'], ['cbgp', $data['bgpPeerIdentifier'] . '.ipv4.vpn']);

require 'includes/html/graphs/bgp/prefixes.inc.php';
