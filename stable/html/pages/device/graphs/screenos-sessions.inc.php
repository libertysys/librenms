<?php

if ($device['os'] == "netscreen" || $device['os_group'] == "netscreen")
{
  $graph_title = "Firewall Sessions";
  $graph_type = "netscreen_sessions";

  include("includes/print-device-graph.php");
}

?>