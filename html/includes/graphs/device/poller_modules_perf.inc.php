<?php
/*
 * LibreNMS per-module poller performance
 *
 * Copyright (c) 2016 Mike Rostermund <mike@kollegienet.dk>
 * Copyright (c) 2016 Paul D. Gear <paul@librenms.org>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$scale_min = '0';
$attribs = get_dev_attribs($device['device_id']);
ksort($config['poller_modules']);

require 'includes/graphs/common.inc.php';

$count = 0;
foreach ($config['poller_modules'] as $module => $module_status) {
    $rrd_filename = rrd_name($device['hostname'], array('poller-perf', $module));
    if ($attribs['poll_'.$module] || ( $module_status && !isset($attribs['poll_'.$module]))) {
        if (is_file($rrd_filename)) {
            $local_ds['ds']       = 'poller';
            $local_ds['descr']    = $module;
            $local_ds['filename'] = $rrd_filename;
            $rrd_list[]     = $local_ds;
            $count++;
        }
    }
}

$unit_text = "Seconds";
$simple_rrd = false;
$nototal = false;
$text_orig = true;
$colours = 'manycolours';
require "includes/graphs/generic_multi_simplex_seperated.inc.php";
