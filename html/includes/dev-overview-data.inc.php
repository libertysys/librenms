<?php

use App\Models\DevicePerf;
use LibreNMS\Exceptions\InvalidIpException;
use LibreNMS\Util\IP;

echo '<script src="js/leaflet.js"></script>';
echo '<link rel="stylesheet" href="js/L.Control.Locate.min.css"/>';
echo '<script src="js/L.Control.Locate.min.js"></script>';

echo '<div class="container-fluid">';
echo "<div class='row'>
      <div class='col-md-12'>
          <div class='panel panel-default panel-condensed overview'>
            <div class='panel-heading'>";

if ($config['overview_show_sysDescr']) {
    echo '<i class="fa fa-id-card fa-lg icon-theme" aria-hidden="true"></i> <strong>'.$device['sysDescr'].'</strong>';
}

echo '</div><div class="panel-body">';

$uptime = formatUptime($device['uptime']);
$uptime_text = 'Uptime';
if ($device['status'] == 0) {
    // Rewrite $uptime to be downtime if device is down
    $uptime = formatUptime(time() - strtotime($device['last_polled']));
    $uptime_text = 'Downtime';
}

if ($device['os'] == 'ios') {
    formatCiscoHardware($device);
}

if ($device['features']) {
    $device['features'] = '('.$device['features'].')';
}

$device['os_text'] = $config['os'][$device['os']]['text'];

echo '<div class="row">
        <div class="col-sm-4">System Name</div>
        <div class="col-sm-8">'.$device['sysName'].' </div>
      </div>';

if (!empty($device['ip'])) {
     echo "<div class='row'><div class='col-sm-4'>Resolved IP</div><div class='col-sm-8'>{$device['ip']}</div></div>";
} elseif ($config['force_ip_to_sysname'] === true) {
    try {
        $ip = IP::parse($device['hostname']);
        echo "<div class='row'><div class='col-sm-4'>IP Address</div><div class='col-sm-8'>$ip</div></div>";
    } catch (InvalidIpException $e) {
        // don't add an ip line
    }
}

if ($device['purpose']) {
    echo '<div class="row">
        <div class="col-sm-4">Description</div>
        <div class="col-sm-8">'.display($device['purpose']).'</div>
      </div>';
}

if ($device['hardware']) {
    echo '<div class="row">
        <div class="col-sm-4">Hardware</div>
        <div class="col-sm-8">'.$device['hardware'].'</div>
      </div>';
}

echo '<div class="row">
        <div class="col-sm-4 text-nowrap">Operating System</div>
        <div class="col-sm-8">'.$device['os_text'].' '.$device['version'].' '.$device['features'].' </div>
      </div>';

if ($device['serial']) {
    echo '<div class="row">
        <div class="col-sm-4">Serial</div>
        <div class="col-sm-8">'.$device['serial'].'</div>
      </div>';
}

if ($device['sysObjectID']) {
    echo '<div class="row">
        <div class="col-sm-4">Object ID</div>
        <div class="col-sm-8">'.$device['sysObjectID'].'</div>
      </div>';
}

if ($device['sysContact']) {
    echo '<div class="row">
        <div class="col-sm-4">Contact</div>';
    if (get_dev_attrib($device, 'override_sysContact_bool')) {
        echo '
        <div class="col-sm-8">'.htmlspecialchars(get_dev_attrib($device, 'override_sysContact_string')).'</div>
      </div>
      <div class="row">
        <div class="col-sm-4">SNMP Contact</div>';
    }

    echo '
        <div class="col-sm-8">'.htmlspecialchars($device['sysContact']).'</div>
      </div>';
}

if ($uptime) {
    echo "<div class='row'>
        <div class='col-sm-4'>$uptime_text</div>
        <div class='col-sm-8'>$uptime</div>
      </div>";
}

if ($device['location_id']) {
    $maps_api = \LibreNMS\Config::get('geoloc.api_key');
    $maps_engine = $maps_api ? \LibreNMS\Config::get('geoloc.engine') : '';

    $location = \App\Models\Location::find($device['location_id']);
        echo '<div class="row">
        <div class="col-sm-4">Location</div>
        <div class="col-sm-8">' . $location->location . '</div>
      </div>
      <div class="row">
        <div class="col-sm-4">Lat / Lng</div>
        <div class="col-sm-8"><span id="toggle-map-button" data-toggle="collapse" data-target="#toggle-map" class="collapsed"><i class="fa fa-lg fa-angle-right"></i> <span id="location-text">';
        if ($location->coordinatesValid()) {
            echo $location->lat . ', ' . $location->lng . '</span></span> <div class="pull-right"><a id="map-it-button" href="https://maps.google.com/?q=' . $location->lat . '+' . $location->lng . '" target="_blank" class="btn btn-success btn-xs" role="button"><i class="fa fa-map-marker" style="color:white" aria-hidden="true"></i> Map</a></div>';
        } else {
            echo 'N/A</span></span>';
        }
        echo '
        </div>
    </div>
    </div>
    <div class="row"></div>
    <div id="toggle-map" class="row collapse"><div class="col-sm-12"><div id="location-map"></div></div></div>
    <script>
        var device_marker, device_location, device_map;
        $("#toggle-map").on("shown.bs.collapse", function () {
            if (device_marker == null) {
                device_location = new L.LatLng(' . (float)$location->lat . ', ' . (float)$location->lng . ');
                device_map = init_map("location-map", "' . $maps_engine . '", "' . $maps_api . '");
                device_marker = init_map_marker(device_map, device_location);
                device_map.setZoom(18);
                
                device_map.on("dragend", function () {
                    var new_location = device_marker.getLatLng();
                    if (confirm("Update location to " + new_location + "? This will update this location for all devices!")) {
                        update_location(' . $location->id . ', new_location, function(success) {
                            if (success) {
                                $("#location-text").text(new_location.lat.toFixed(5) + ", " + new_location.lng.toFixed(5));
                                $("#map-it-button").attr("href", "https://maps.google.com/?q=" + new_location.lat + "+" + new_location.lng );
                            }
                        });
                    }
                });
            }
        });
    </script>
    ';

}

echo '</div>
      </div>
      </div>
      </div>';

$perf_info = DevicePerf::where('device_id', $device['device_id'])->latest('timestamp')->first();
$perf_debug = json_decode($perf_info['debug'], true);
if ($perf_debug['traceroute']) {
    echo "<div class='row'>
     <div class='col-md-12'>
         <div class='panel panel-default'>
             <div class='panel-heading'>
                 <h3 class='panel-title'>Traceroute ({$perf_info['timestamp']})</h3>
             </div>
             <div class='panel-body'>
                 <pre>{$perf_debug['traceroute']}</pre>
            </div>
         </div>
     </div>
 </div>";
}

echo '</div>';

?>

<style>
    #location-map {
        padding: 15px;
        height: 400px;
    }

    #toggle-map-button { cursor: pointer; }
    #toggle-map-button i { transition: .3s transform ease-in-out; }
    #toggle-map-button:not(.collapsed) i { transform: rotate(90deg); }

    .overview .panel-body { padding-top: 0; padding-bottom: 0; }
    .overview .panel-body .row:nth-child(odd) { background-color: #f9f9f9; }
    .overview .panel-body .row:hover { background-color: #f5f5f5; }
    .overview .panel-body .row>div { padding: 3px 5px; }
</style>
