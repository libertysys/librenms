<?php

use LibreNMS\RRD\RrdDefinition;
use LibreNMS\Exceptions\JsonAppException;

$name = 'raid-drp';
$app_id = $app['app_id'];

echo $name;

try {
    $returned=json_app_get($device, 'raid-drp', 1);
} catch (JsonAppException $e) { // Only doing the generic one as this has no non-JSON return
    echo PHP_EOL . $name . ':' .$e->getCode().':'. $e->getMessage() . PHP_EOL;
    update_application($app, $e->getCode().':'.$e->getMessage(), []); // Set empty metrics and error message
    return;
}

$raidinfo=$returned['data'];

$array_rrd_def = RrdDefinition::make()
    ->addDataset('status', 'GAUGE', 0)
    ->addDataset('good', 'GAUGE', 0)
    ->addDataset('bad', 'GAUGE', 0)
    ->addDataset('spare', 'GAUGE', 0)
    ->addDataset('bbu', 'GAUGE', 0);

$stats_rrd_def = RrdDefinition::make()
    ->addDataset('unknown_arrays', 'GAUGE', 0)
    ->addDataset('bbu_good', 'GAUGE', 0)
    ->addDataset('bbu_failed', 'GAUGE', 0)
    ->addDataset('arrays', 'GAUGE', 0)
    ->addDataset('spare_drive', 'GAUGE', 0)
    ->addDataset('good_drives', 'GAUGE', 0)
    ->addDataset('bbu_charging', 'GAUGE', 0)
    ->addDataset('bbu_na', 'GAUGE', 0)
    ->addDataset('good_arrays', 'GAUGE', 0)
    ->addDataset('bbu_notPresen', 'GAUGE', 0)
    ->addDataset('rebuilding_arrays', 'GAUGE', 0)
    ->addDataset('bad_arrays', 'GAUGE', 0)
    ->addDataset('bad_drives', 'GAUGE', 0)
    ->addDataset('bbu_unknown', 'GAUGE', 0);


//
// update the RRD files for each found array
//

$array_keys=array_keys($raidinfo['arrays']);
foreach ($array_keys as $array_name) {
    /*  Turn the status into a integer.
     * Integer Status mapping
     * 0 unknwon
     * 1 bad
     * 2 rebuilding
     * 3 good
    */
    $status=0;
    if (strcmp($raidinfo['arrays'][$array_name]['status'], 'good') == 0) {
        $status=3;
    } elseif (strcmp($raidinfo['arrays'][$array_name]['status'], 'rebuilding') == 0) {
        $status=2;
    } elseif (strcmp($raidinfo['arrays'][$array_name]['status'], 'bad') == 0) {
        $status=1;
    }

    /* Turns the BBU status into a integer.
     * Integer Status mapping
     * 0 unknwon
     * 1 na
     * 2 notPresent
     * 3 charging
     * 4 failed
     * 5 good
     */
    $bbu_status=0;
    if (strcmp($raidinfo['arrays'][$array_name]['BBUstatus'], 'na') == 0) {
        $bbu_status=1;
    } elseif (strcmp($raidinfo['arrays'][$array_name]['BBUstatus'], 'notPrsent') == 0) {
        $bbu_status=2;
    } elseif (strcmp($raidinfo['arrays'][$array_name]['BBUstatus'], 'failed') == 0) {
        $bbu_status=3;
    } elseif (strcmp($raidinfo['arrays'][$array_name]['BBUstatus'], 'charging') == 0) {
        $bbu_status=4;
    } elseif (strcmp($raidinfo['arrays'][$array_name]['BBUstatus'], 'good') == 0) {
        $bbu_status=5;
    }

    $good=count($raidinfo['arrays'][$array_name]['good']);
    $bad=count($raidinfo['arrays'][$array_name]['bad']);
    $spare=count($raidinfo['arrays'][$array_name]['spare']);

    $rrd_name = array('app', $name, $app_id, );
    $fields = array(
        'status'=>$status,
        'good'=>$good,
        'bad'=>$bad,
        'spare'=>$spare,
        'bbu'=>$bbu_status,
    );
    $tags = array('name' => $name, 'app_id' => $app_id, 'rrd_def' => $array_rrd_def, 'rrd_name' => $rrd_name);
    data_update($device, 'app', $tags, $fields);
}

//
// component processing for portsactivity
//
$device_id=$device['device_id'];
$options=array(
    'filter' => array(
        'device_id' => array('=', $device_id),
        'type' => array('=', 'raid-drp'),
     ),
);

$component=new LibreNMS\Component();
$components=$component->getComponents($device_id, $options);

//delete portsactivity component if nothing is found
if (empty($array_keys)) {
    if (isset($components[$device_id])) {
        foreach ($components[$device_id] as $component_id => $_unused) {
                 $component->deleteComponent($component_id);
        }
    }
//add portsactivity component if found
} else {
    if (isset($components[$device_id])) {
        $portsc = $components[$device_id];
    } else {
        $portsc = $component->createComponent($device_id, 'raid-drp');
    }

    $id = $component->getFirstComponentID($portsc);
    $portsc[$id]['label'] = 'RAID-DRP';
    $portsc[$id]['arrays'] = json_encode($array_keys);

    $component->setComponentPrefs($device_id, $portsc);
}

update_application($app, 'OK', data_flatten($raidinfo));
