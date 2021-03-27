<?php

header('Content-type: application/json');

use App\Models\Port;

if (! Auth::user()->hasGlobalAdmin()) {
    $response = [
        'status'  => 'error',
        'message' => 'Need to be admin',
    ];
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

$status = 'error';
$message = 'Error with config';

// enable/disable ports/interfaces on devices.
$device_id = intval($_POST['device']);
$rows_updated = 0;

foreach ($_POST as $key => $val) {
    $port_id = intval(end(explode('_', $key)));

    if (strncmp($key, 'port_group_', 11) == 0) {
        $port_group_ids = $val;

        if (($idx = array_search('0', $port_group_ids)) !== false) {
            unset($port_group_ids[$idx]);
        }

        Port::find($port_id)->groups()->sync($port_group_ids);
    } elseif (strncmp($key, 'oldign_', 7) == 0) {
        // Interface identifier passed as part of the field name

        $oldign = intval($val) ? 1 : 0;
        $newign = $_POST['ignore_' . $port_id] ? 1 : 0;

        // As checkboxes are not posted when unset - we effectively need to do a diff to work
        // out a set->unset case.
        if ($oldign == $newign) {
            continue;
        }

        $n = dbUpdate(['ignore' => $newign], 'ports', '`device_id` = ? AND `port_id` = ?', [$device_id, $port_id]);

        if ($n < 0) {
            $rows_updated = -1;
            break;
        }

        $rows_updated += $n;
    } elseif (strncmp($key, 'olddis_', 7) == 0) {
        // Interface identifier passed as part of the field name

        $olddis = intval($val) ? 1 : 0;
        $newdis = $_POST['disabled_' . $port_id] ? 1 : 0;

        // As checkboxes are not posted when unset - we effectively need to do a diff to work
        // out a set->unset case.
        if ($olddis == $newdis) {
            continue;
        }

        $n = dbUpdate(['disabled' => $newdis], 'ports', '`device_id` = ? AND `port_id` = ?', [$device_id, $port_id]);

        if ($n < 0) {
            $rows_updated = -1;
            break;
        }

        $rows_updated += $n;
    }//end if
}//end foreach

if ($rows_updated > 0) {
    $message = $rows_updated . ' Device record updated.';
    $status = 'ok';
} elseif ($rows_updated = '-1') {
    $message = 'Device record unchanged. No update necessary.';
    $status = 'ok';
} else {
    $message = 'Device record update error.';
}

$response = [
    'status'        => $status,
    'message'       => $message,
];
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
