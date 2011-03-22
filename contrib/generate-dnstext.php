#!/usr/bin/env php
<?php

include("../config.php");
include("../includes/functions.php");

$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
$db = mysql_select_db($config['db_name'], $link);


$query = "SELECT * FROM ipaddr AS A, ports as I, devices as D WHERE A.interface_id = I.interface_id AND I.device_id = D.device_id AND D.os = 'ios'";
$data = mysql_query($query, $link);
while($ip = mysql_fetch_array($data)) {
    unset($sub);
    $hostname = $ip['hostname'];

    $real_hostname = $hostname;

    $hostname = str_replace(".jtibs.net", "", $hostname);
    $hostname = str_replace(".wtibs.net", "", $hostname);
    $hostname = str_replace(".jerseytelecom.net", "", $hostname);

    list($cc, $loc, $host) = explode(".", $hostname);
    if($host) {
        $hostname = "$host.$loc.$cc.v4.jerseytelecom.net";
    } else {
        $host = $cc; unset ($cc);
        $hostname = "$host.v4.jerseytelecom.net";
    }

    $interface = $ip['ifDescr'];
    $address = $ip['addr'];
    $cidr = $ip['cidr'];
    $interface = strtolower(makeshortif(fixifname($interface)));
    $interface = str_replace("/", "-", $interface);
    $interface = str_replace(":", "_", $interface);
    list($interface, $sub) = explode(".", $interface);
    if($sub) {
        $sub = str_replace(" ", "", $sub);
        $sub = str_replace("aal5", "", $sub);
        $interface = "$sub.$interface";
    }
    $hostip = trim(gethostbyname($real_hostname));

    list($first, $second, $third, $fourth) = explode(".", $address);
    $revzone = "$third.$second.$first.in-addr.arpa";
    $reverse = "$fourth.$revzone";
    $dnsname = "$interface.$hostname";

    $dns_list[] = str_pad($revzone, 24) . "|" . str_pad($reverse, 30)."IN ADDR  ".str_pad($dnsname, 30);

}

sort ($dns_list);

foreach ($dns_list as $entry) {
    list($zone, $entry) = explode("|", $entry);
    $zone = trim($zone);

    if($zone != $oldzone) { echo("\n$$zone\n------------------------------\n"); }

    echo("$entry \n");

    $oldzone = $zone;

}


?>
