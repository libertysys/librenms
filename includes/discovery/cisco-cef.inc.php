<?php

echo("Cisco CEF Switching Path: ");

$cefs = array();
$cefs = snmpwalk_cache_threepart_oid($device, "CISCO-CEF-MIB::cefSwitchingPath", $cefs);
if ($debug) { print_r($cefs); }

if (is_array($cefs))
{
  if (!is_array($entity_array))
  {
    echo("Caching OIDs: ");
    $entity_array = array();
    echo(" entPhysicalDescr");
    $entity_array = snmpwalk_cache_multi_oid($device, "entPhysicalDescr", $entity_array, "ENTITY-MIB");
    echo(" entPhysicalName");
    $entity_array = snmpwalk_cache_multi_oid($device, "entPhysicalName", $entity_array, "ENTITY-MIB");
    echo(" entPhysicalModelName");
    $entity_array = snmpwalk_cache_multi_oid($device, "entPhysicalModelName", $entity_array, "ENTITY-MIB");
  }
    foreach ($cefs as $entity => $afis)
  {
    $entity_name = $entity_array[$entity]['entPhysicalName'] ." - ".$entity_array[$entity]['entPhysicalModelName'];
    echo("\n$entity $entity_name\n");
    foreach ($afis as $afi => $paths)
    {
      echo(" |- $afi\n");
      foreach ($paths as $path => $path_name)
      {
        echo(" | |-".$path.": ".$path_name['cefSwitchingPath']."\n");
        $cef_exists[$device['device_id']][$entity][$afi][$path] = 1;

        if (dbFetchCell("SELECT COUNT(*) from `cef` WHERE device_id = ? AND entPhysicalIndex = ?, AND afi=? AND cef_index=?",array($device['device_id'], $entity,$afi,$path)) != "1")
        {
          dbInsert(array('device_id' => $device['device_id'], 'entPhysicalIndex' => $entity, 'afi' => $afi, 'cef_path' => $path), 'cef');
          echo("+");
        }

      }
    }
  }
}

// FIXME - need to delete old ones. FIXME REALLY.

echo("\n");

?>
