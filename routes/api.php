<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['prefix' => 'v0', 'namespace' => '\App\Api\Controllers'], function () {
    Route::get('system', 'LegacyApiController@server_info')->name('server_info');

    // global read only access required
    Route::middleware(['can:global-read'])->group(function () {
        Route::get('bgp', 'LegacyApiController@list_bgp')->name('list_bgp');
        Route::get('bgp/{id}', 'LegacyApiController@get_bgp')->name('get_bgp');
        Route::get('ospf', 'LegacyApiController@list_ospf')->name('list_ospf');
        Route::get('oxidized/{hostname?}', 'LegacyApiController@list_oxidized')->name('list_oxidized');

        Route::get('resources/ip/networks/{id}/ip', 'LegacyApiController@get_network_ip_addresses')->name('get_network_ip_addresses');
    });

    // admin required
    Route::middleware(['can:admin'])->group(function () {
        Route::group(['prefix' => 'devices'], function () {
            Route::post(null, 'LegacyApiController@add_device')->name('add_device');
            Route::delete('{hostname}', 'LegacyApiController@del_device')->name('del_device');
            Route::patch('{hostname}', 'LegacyApiController@update_device')->name('update_device_field');
            Route::patch('{hostname}/rename/{new_hostname}', 'LegacyApiController@rename_device')->name('rename_device');
        });
    });

    // restricted by access
    Route::group(['prefix' => 'devices'], function () {
        Route::get('{hostname}/graphs/health/{type}/{sensor_id?}', 'LegacyApiController@get_graph_generic_by_hostname')->name('get_health_graph');
        Route::get('{hostname}/graphs/wireless/{type}/{sensor_id?}', 'LegacyApiController@get_graph_generic_by_hostname')->name('get_wireless_graph');
        Route::get('{hostname}/vlans', 'LegacyApiController@get_vlans')->name('get_vlans');
        Route::get('{hostname}/links', 'LegacyApiController@list_links')->name('list_links');
        Route::get('{hostname}/graphs', 'LegacyApiController@get_graphs')->name('get_graphs');
        Route::get('{hostname}/fdb', 'LegacyApiController@get_fdb')->name('get_fdb');
        Route::get('{hostname}/health/{type?}/{sensor_id?}', 'LegacyApiController@list_available_health_graphs')->name('list_available_health_graphs');
        Route::get('{hostname}/wireless/{type?}/{sensor_id?}', 'LegacyApiController@list_available_wireless_graphs')->name('list_available_wireless_graphs');
        Route::get('{hostname}/ports', 'LegacyApiController@get_port_graphs')->name('get_port_graphs');
        Route::get('{hostname}/ip', 'LegacyApiController@get_device_ip_addresses')->name('get_ip_addresses');

        Route::get('{hostname}/{type}', 'LegacyApiController@get_graph_generic_by_hostname')->name('get_graph_generic_by_hostname');
        Route::get('{hostname}', 'LegacyApiController@get_device')->name('get_device');
        Route::get(null, 'LegacyApiController@list_devices')->name('list_devices');
    });

    Route::group(['prefix' => 'ports'], function () {
        Route::get('{portid}', 'LegacyApiController@get_port_info')->name('get_port_info');
        Route::get('{portid}/ip', 'LegacyApiController@get_port_ip_addresses')->name('get_port_ip_info');
        Route::get(null, 'LegacyApiController@get_all_ports')->name('get_all_ports');
    });
});

// Legacy API
Route::any('/v0/{path?}', 'LegacyController@api')->where('path', '.*');
