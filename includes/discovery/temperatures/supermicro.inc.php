<?php

global $valid_sensor;

if($device['os'] == "linux")
{
  # Supermicro sensors
  $oids = snmp_walk($device, "1.3.6.1.4.1.10876.2.1.1.1.1.3", "-Osqn", "SUPERMICRO-HEALTH-MIB");
  $oids = trim($oids);
  if ($oids) echo("Supermicro ");
  foreach(explode("\n", $oids) as $data)
  {
    $data = trim($data);
    if ($data)
    {
      list($oid,$type) = explode(" ", $data);
      $oid_ex = explode('.',$oid);
      $index = $oid_ex[count($oid_ex)-1];
      if ($type == 2)
      {
        $temperature_oid    = "1.3.6.1.4.1.10876.2.1.1.1.1.4.$index";
        $descr_oid   = "1.3.6.1.4.1.10876.2.1.1.1.1.2.$index";
        $limit_oid   = "1.3.6.1.4.1.10876.2.1.1.1.1.5.$index";
        $divisor_oid = "1.3.6.1.4.1.10876.2.1.1.1.1.9.$index";
        $monitor_oid = "1.3.6.1.4.1.10876.2.1.1.1.1.10.$index";
        $descr   = snmp_get($device,   $descr_oid, "-Oqv", "SUPERMICRO-HEALTH-MIB");
        $temperature    = snmp_get($device,    $temperature_oid, "-Oqv", "SUPERMICRO-HEALTH-MIB");
        $limit   = snmp_get($device,   $limit_oid, "-Oqv", "SUPERMICRO-HEALTH-MIB");
        $divisor = snmp_get($device, $divisor_oid, "-Oqv", "SUPERMICRO-HEALTH-MIB") || 1;
        $monitor = snmp_get($device, $monitor_oid, "-Oqv", "SUPERMICRO-HEALTH-MIB");
        if ($monitor == 'true')
        {
          $descr = trim(str_ireplace("temperature", "", $descr));
          discover_sensor($valid_sensor, 'temperature', $device, $temperature_oid, trim($index,'.'), 'supermicro', $descr, $divisor, '1', NULL, NULL, NULL, NULL, $temperature);
        }
      }
    }
  }
}

?>
