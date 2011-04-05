<?php

## Common Functions

function get_port_by_id($port_id)
{
  if (is_numeric($port_id))
  {
    $port = mysql_fetch_assoc(mysql_query("SELECT * FROM `ports` WHERE `interface_id` = '".$port_id."'"));
  }
  if (is_array($port))
  {
    return $port;
  } else {
    return FALSE;
  }
}

function get_application_by_id($application_id)
{
  if (is_numeric($application_id))
  {
    $application = mysql_fetch_assoc(mysql_query("SELECT * FROM `applications` WHERE `app_id` = '".$application_id."'"));
  }
  if (is_array($application))
  {
    return $application;
  } else {
    return FALSE;
  }
}

function get_sensor_by_id($sensor_id)
{
  if (is_numeric($sensor_id))
  {
    $sensor = mysql_fetch_assoc(mysql_query("SELECT * FROM `sensors` WHERE `sensor_id` = '".$sensor_id."'"));
  }
  if (is_array($sensor))
  {
    return $sensor;
  } else {
    return FALSE;
  }
}

function get_device_id_by_interface_id($interface_id)
{
  if (is_numeric($interface_id))
  {
    $device_id = mysql_result(mysql_query("SELECT `device_id` FROM `ports` WHERE `interface_id` = '".$interface_id."'"),0);
  }
  if (is_numeric($device_id))
  {
    return $device_id;
  } else {
    return FALSE;
  }
}

function ifclass($ifOperStatus, $ifAdminStatus)
{
  $ifclass = "interface-upup";

  if ($ifAdminStatus == "down") { $ifclass = "interface-admindown"; }
  if ($ifAdminStatus == "up" && $ifOperStatus== "down") { $ifclass = "interface-updown"; }
  if ($ifAdminStatus == "up" && $ifOperStatus== "up") { $ifclass = "interface-upup"; }

  return $ifclass;
}

function device_by_id_cache($device_id)
{
  global $device_cache;

  if (is_array($device_cache[$device_id]))
  {
    $device = $device_cache[$device_id];
  } else {
    $device = mysql_fetch_assoc(mysql_query("SELECT * FROM `devices` WHERE `device_id` = '".$device_id."'"));
    if (get_dev_attrib($device,'override_sysLocation_bool'))
    {
      $device['real_location'] = $device['location'];
      $device['location'] = get_dev_attrib($device,'override_sysLocation_string');
    }
    $device_cache[$device_id] = $device;
  }

  return $device;
}

function truncate($substring, $max = 50, $rep = '...')
{
  if (strlen($substring) < 1){ $string = $rep; } else { $string = $substring; }
  $leave = $max - strlen ($rep);
  if (strlen($string) > $max){ return substr_replace($string, $rep, $leave); } else { return $string; }
}

function mres($string)
{ // short function wrapper because the real one is stupidly long and ugly. aestetics.
  return mysql_real_escape_string($string);
}

function getifhost($id)
{
  $sql = mysql_query("SELECT `device_id` from `ports` WHERE `interface_id` = '$id'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function gethostbyid($id)
{
  $sql = mysql_query("SELECT `hostname` FROM `devices` WHERE `device_id` = '$id'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function strgen ($length = 16)
{
  $entropy = array(0,1,2,3,4,5,6,7,8,9,'a','A','b','B','c','C','d','D','e',
  'E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n',
  'N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w',
  'W','x','X','y','Y','z','Z');
  $string = "";

  for ($i=0; $i<$length; $i++)
  {
    $key = mt_rand(0,61);
    $string .= $entropy[$key];
  }

  return $string;
}

function getpeerhost($id)
{
  $sql = mysql_query("SELECT `device_id` from `bgpPeers` WHERE `bgpPeer_id` = '$id'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function getifindexbyid($id)
{
  $sql = mysql_query("SELECT `ifIndex` FROM `ports` WHERE `interface_id` = '$id'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function getifbyid($id)
{
  $sql = mysql_query("SELECT * FROM `ports` WHERE `interface_id` = '$id'");
  $result = @mysql_fetch_array($sql);

  return $result;
}

function getifdescrbyid($id)
{
  $sql = mysql_query("SELECT `ifDescr` FROM `ports` WHERE `interface_id` = '$id'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function getidbyname($domain)
{
  $sql = mysql_query("SELECT `device_id` FROM `devices` WHERE `hostname` = '$domain'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function gethostosbyid($id)
{
  $sql = mysql_query("SELECT `os` FROM `devices` WHERE `device_id` = '$id'");
  $result = @mysql_result($sql, 0);

  return $result;
}

function safename($name)
{
  return preg_replace('/[^a-zA-Z0-9,._\-]/', '_', $name);
}

function zeropad($num, $length = 2)
{
  while (strlen($num) < $length)
  {
    $num = '0'.$num;
  }

  return $num;
}

function set_dev_attrib($device, $attrib_type, $attrib_value)
{
  $count_sql = "SELECT COUNT(*) FROM devices_attribs WHERE `device_id` = '" . mres($device['device_id']) . "' AND `attrib_type` = '$attrib_type'";
  if (mysql_result(mysql_query($count_sql),0))
  {
    $update_sql = "UPDATE devices_attribs SET attrib_value = '$attrib_value' WHERE `device_id` = '" . mres($device['device_id']) . "' AND `attrib_type` = '$attrib_type'";
    mysql_query($update_sql);
  }
  else
  {
    $insert_sql = "INSERT INTO devices_attribs (`device_id`, `attrib_type`, `attrib_value`) VALUES ('" . mres($device['device_id'])."', '$attrib_type', '$attrib_value')";
    mysql_query($insert_sql);
  }

  return mysql_affected_rows();
}

function get_dev_attrib($device, $attrib_type)
{
  $sql = "SELECT attrib_value FROM devices_attribs WHERE `device_id` = '" . mres($device['device_id']) . "' AND `attrib_type` = '$attrib_type'";
  if ($row = mysql_fetch_assoc(mysql_query($sql)))
  {
    return $row['attrib_value'];
  }
  else
  {
    return NULL;
  }
}

function del_dev_attrib($device, $attrib_type)
{
  $sql = "DELETE FROM devices_attribs WHERE `device_id` = '" . mres($device['device_id']) . "' AND `attrib_type` = '$attrib_type'";
  return mysql_query($sql);
}

function formatRates($rate)
{
   $rate = format_si($rate) . "bps";
   return $rate;
}

function formatStorage($rate, $round = '2')
{
   $rate = format_bi($rate, $round) . "B";
   return $rate;
}

function format_si($rate)
{
  if ($rate >= "0.1")
  {
    $sizes = Array('', 'k', 'M', 'G', 'T', 'P', 'E');
    $round = Array('2','2','2','2','2','2','2','2','2');
    $ext = $sizes[0];
    for ($i = 1; (($i < count($sizes)) && ($rate >= 1000)); $i++) { $rate = $rate / 1000; $ext  = $sizes[$i]; }
  }
  else
  {
    $sizes = Array('', 'm', 'u', 'n');
    $round = Array('2','2','2','2');
    $ext = $sizes[0];
    for ($i = 1; (($i < count($sizes)) && ($rate != 0) && ($rate <= 0.1)); $i++) { $rate = $rate * 1000; $ext  = $sizes[$i]; }
  }

  return round($rate, $round[$i]).$ext;
}

function format_bi($size, $round = '2')
{
  $sizes = Array('', 'k', 'M', 'G', 'T', 'P', 'E');
  $ext = $sizes[0];
  for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++) { $size = $size / 1024; $ext  = $sizes[$i]; }
  return round($size, $round).$ext;
}

?>
