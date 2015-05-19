<?php

if ($device['os'] == "routeros")
{
  $oids = snmp_walk($device, "mtxrHlVoltage", "-OsqnU", "MIKROTIK-MIB");
  if ($debug) { echo($oids."\n"); }
  if ($oids) echo("MIKROTIK-MIB ");
  $divisor = 10.0;
  $type = "mikrotik";

  foreach (explode("\n", $oids) as $data)
  {
    $data = trim($data);
    if ($data)
    {
      list($oid,$descr) = explode(" ", $data,2);
      $split_oid = explode('.',$oid);
      $index = $split_oid[count($split_oid)-1];
      $descr = "Voltage " . $index;
      $oid  = ".1.3.6.1.4.1.14988.1.1.3.8." . $index;
      $voltage = snmp_get($device, $oid, "-Oqv") / $divisor;

      discover_sensor($valid['sensor'], 'voltage', $device, $oid, $index, $type, $descr, $divisor, '1', NULL, NULL, NULL, NULL, $voltage);
    }
  }
}

?>
