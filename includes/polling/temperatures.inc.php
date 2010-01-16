<?php

$query = "SELECT * FROM temperature WHERE temp_host = '" . $device['device_id'] . "'";
$temp_data = mysql_query($query);
while($temperature = mysql_fetch_array($temp_data)) {

  $temp_cmd = $config['snmpget'] . " -m SNMPv2-MIB -O Uqnv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'] . " " . $temperature['temp_oid'] . "|grep -v \"No Such Instance\"";
  $temp = shell_exec($temp_cmd);

  echo("Checking temp " . $temperature['temp_descr'] . "... ");

  $temprrd  = addslashes($config['rrd_dir'] . "/" . $device['hostname'] . "/temp-" . str_replace("/", "_", str_replace(" ", "_",$temperature['temp_descr'])) . ".rrd");
  $temprrd  = str_replace(")", "_", $temprrd);
  $temprrd  = str_replace("(", "_", $temprrd);

  if (!is_file($temprrd)) {
    `rrdtool create $temprrd \
     --step 300 \
     DS:temp:GAUGE:600:-273:1000 \
     RRA:AVERAGE:0.5:1:1200 \
     RRA:MIN:0.5:12:2400 \
     RRA:MAX:0.5:12:2400 \
     RRA:AVERAGE:0.5:12:2400`;
  }

  $temp = trim(str_replace("\"", "", $temp));
  if($temperature['temp_tenths']) { $temp = $temp / 10; }
  else
  {
    if ($temperature['temp_precision']) { $temp = $temp / $temperature['temp_precision']; }
  }

  echo($temp . "C\n");

  $updatecmd = "rrdtool update $temprrd N:$temp";

  shell_exec($updatecmd);

  if($temperature['temp_current'] < $temperature['temp_limit'] && $temp >= $temperature['temp_limit']) {
    $updated = ", `service_changed` = '" . time() . "' ";
    if($device['sysContact']) { $email = $device['sysContact']; } else { $email = $config['email_default']; }
    $msg  = "Temp Alarm: " . $device['hostname'] . " " . $temperature['temp_descr'] . " is " . $temp . " (Limit " . $temperature['temp_limit'];
    $msg .= ") at " . date('l dS F Y h:i:s A');
    mail($email, "Temp Alarm: " . $device['hostname'] . " " . $temperature['temp_descr'], $msg, $config['email_headers']);
    echo("Alerting for " . $device['hostname'] . " " . $temperature['temp_descr'] . "\n");
  }

  mysql_query("UPDATE temperature SET temp_current = '$temp' WHERE temp_id = '$temperature[temp_id]'");
}

?>
