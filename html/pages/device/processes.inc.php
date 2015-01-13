<?php
/* Copyright (C) 2015 Daniel Preussker <f0o@devilcode.org>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. */

/**
 * Alerts Tracking
 * @author Daniel Preussker <f0o@devilcode.org>
 * @copyright 2015 f0o, LibreNMS
 * @license GPL
 * @package LibreNMS
 * @subpackage Pages
 */

switch( $vars['order'] ) {
	case "vsz":
		$order = "`vsz`";
	break;
	case "rss":
		$order = "`rss`";
	break;
	case "cpu":
		$order = "`pcpu`";
	break;
	case "user":
		$order = "`user`";
	break;
	case "command":
		$order = "`command`";
	break;
	default:
		$order = "`pid`";
	break;
}
if( $vars['by'] == "desc" ) {
	$by = "desc";
} else {
	$by = "asc";
}

$heads = array(
	'PID'     => '',
	'VSZ'     => 'Virtual Memory',
	'RSS'     => 'Resident Memory',
	'PCPU'    => 'Ratio of CPU time',
	'user'    => '',
	'command' => ''
);

echo "<div class='table-responsive'><table class='table table-hover'><thead><tr>";
foreach( $heads as $head=>$extra ) {
	unset($lhead, $bhead);
	$lhead = strtolower($head);
	$bhead = 'asc';
	$icon = "";
	if( '`'.$lhead.'`' == $order ) {
		$icon = " class='glyphicon glyphicon-chevron-";
		if( $by == 'asc' ) {
			$bhead = 'desc';
			$icon .= 'up';
		} else {
			$icon .= 'down';
		}
		$icon .= "'";
	}
	echo '<th><a href="/device/device='.$device['device_id'].'/tab=processes/order='.$lhead.'/by='.$bhead.'"><span'.$icon.'>&nbsp;';
	if( !empty($extra) ) {
		echo "<abbr title='$extra'>$head</abbr>";
	} else {
		echo $head;
	}
	echo '</span></a></th>';
}
echo "</tr></thead><tbody>";

foreach (dbFetchRows("SELECT * FROM `processes` WHERE `device_id` = ? ORDER BY ".$order." ".$by, array($device['device_id'])) as $entry) {
	echo '<tr>';
	echo '<td>'.$entry['pid'].'</td>';
	echo '<td>'.format_si($entry['vsz']).'</td>';
	echo '<td>'.format_si($entry['rss']).'</td>';
	echo '<td>'.$entry['pcpu'].'</td>';
	echo '<td>'.$entry['user'].'</td>';
	echo '<td>'.$entry['command'].'</td>';
	echo '</tr>';
}
echo"</tbody></table></div>";

?>
