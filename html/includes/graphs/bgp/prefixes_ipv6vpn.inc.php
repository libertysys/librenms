<?php

$rrd_filename = rrd_name($device['hostname'], array('cbgp', $data['bgpPeerIdentifier'].'.ipv6.vpn.'));

require 'includes/graphs/bgp/prefixes.inc.php';
