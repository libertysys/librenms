#!/usr/bin/env php
<?php

include("includes/defaults.inc.php");
include("config.php");
include("includes/functions.php");

$ports = mysql_result(mysql_query("SELECT count(*) FROM ports"),0);
$devices    = mysql_result(mysql_query("SELECT count(*) FROM devices"),0);

$dataHandle = fopen("http://www.observium.org/latest.php?i=$ports&d=$devices&v=".$config['version'], r);

if ($dataHandle)
{
	while (!feof($dataHandle))
        {
  		$data.= fread($dataHandle, 4096);
	}
	if ($data)
	{
 		list($major, $minor, $release) = explode(".", $data);
                list($cur, $tag) = explode("-", $config['version']);
	        list($cur_major, $cur_minor, $cur_release) = explode(".", $cur);

     	     if ($argv[1] == "--cron")
     	     {
               if (is_file('vrrd')) { echo("ERROR: 'vrrd' is not a directory!\n"); exit; }
               if (is_dir('vrrd') && !is_writable('vrrd')) { echo("ERROR: I can not write in the 'vrrd' directory!\n"); exit; }
               if (!is_dir('vrrd')) { mkdir('vrrd'); }
     	       $fd = fopen('vrrd/version.txt','w');
     	       fputs($fd, "$major.$minor.$release");
     	       fclose($fd);
             } else {
                echo("Current Version $cur_major.$cur_minor.$cur_release \n");

		if ($major > $cur_major) {
	          echo("New major release : $major.$minor.$release");
                } elseif ($major == $cur_major && $minor > $cur_minor) {
	          echo("New minor release : $major.$minor.$release");
                } elseif ($major == $cur_major && $minor == $cur_minor && $release > $cur_release) {
                  echo("New trivial release : $major.$minor.$release");
                } elseif ($major < $cur_major || ($major == $cur_major && $minor < $cur_minor) || ($major == $cur_major && $minor == $cur_minor && $release < $cur_release)) {
		  echo("Your release is newer than the official version!\n");
                } else {
		  echo("Your release is up to date\n");
                }
                echo("\n");
             }
	}
	fclose($dataHandle);
}

?>
