<?php

echo("UCD Disk IO : ");
$diskio_array = snmpwalk_cache_oid($device, "diskIOEntry", array(), "UCD-DISKIO-MIB" , "+".$config['install_dir']."/mibs/");
$valid_diskio = array();
#  if ($debug) { print_r($diskio_array); }

if (is_array($diskio_array))
{
  foreach ($diskio_array as $index => $entry)
  {
    if ($entry['diskIONRead'] > "0" || $entry['diskIONWritten'] > "0")
    {
      if ($debug) { echo("$index ".$entry['diskIODevice']."\n"); }

      if (dbFetchCell("SELECT COUNT(*) FROM `ucd_diskio` WHERE `device_id` = ? AND `diskio_index` = ?",array($device['device_id'], $index)) == "0")
      {
        $inserted = dbInsert(array('`device_id`' => $device['device_id'], '`diskio_index`' => $index, '`diskio_descr`' => $entry['diskIODevice']), 'ucd_diskio');
        echo("+");
        if ($debug) { echo($sql . " - $inserted inserted "); }
      }
      else
      {
        echo(".");
        // FIXME Need update code here!
      }

      $valid_diskio[$index] = 1;
    } // end validity check
  } // end array foreach
} // End array if

// Remove diskio entries which weren't redetected here

$sql = "SELECT * FROM `ucd_diskio` where `device_id`  = '".$device['device_id']."'";

if ($debug) { print_r ($valid_diskio); }

foreach (dbFetchRows($sql) as $test)
{
  if ($debug) { echo($test['diskio_index'] . " -> " . $test['diskio_descr'] . "\n"); }
  if (!$valid_diskio[$test['diskio_index']])
  {
    echo("-");
    dbDelete('ucd_diskio', '`diskio_id` = ?', array($test['diskio_id']));
  }
}

unset($valid_diskio);
echo("\n");

?>
