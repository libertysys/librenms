<?php

use LibreNMS\RRD\RrdDefinition;

$oids = snmp_get_multi($device, 'pfStateCount.0 pfStateSearches.0 pfStateInserts.0 pfStateRemovals.0', '-OQUs', 'OPENBSD-PF-MIB');

$states = $oids[0]['pfStateCount'];
$searches = $oids[0]['pfStateSearches'];
$inserts = $oids[0]['pfStateInserts'];
$removals = $oids[0]['pfStateCount'];

if (is_numeric($states)) {
    $rrd_def = RrdDefinition::make()->addDataset('states', 'GAUGE', 0);

    $fields = array(
        'states' => $states,
    );

    $tags = compact('rrd_def');
    data_update($device, 'pf_states', $tags, $fields);

    $graphs['openbsd_pf_states'] = true;
}

if (is_numeric($searches)) {
    $rrd_def = RrdDefinition::make()->addDataset('searches', 'GAUGE', 0);

    $fields = array(
        'searches' => $searches,
    );

    $tags = compact('rrd_def');
    data_update($device, 'pf_searches', $tags, $fields);

    $graphs['openbsd_pf_searches'] = true;
}

if (is_numeric($inserts)) {
    $rrd_def = RrdDefinition::make()->addDataset('inserts', 'GAUGE', 0);

    $fields = array(
        'inserts' => $inserts,
    );

    $tags = compact('rrd_def');
    data_update($device, 'pf_inserts', $tags, $fields);

    $graphs['openbsd_pf_inserts'] = true;
}

if (is_numeric($removals)) {
    $rrd_def = RrdDefinition::make()->addDataset('removals', 'GAUGE', 0);

    $fields = array(
        'removals' => $removals,
    );

    $tags = compact('rrd_def');
    data_update($device, 'pf_removals', $tags, $fields);

    $graphs['openbsd_pf_removals'] = true;
}
