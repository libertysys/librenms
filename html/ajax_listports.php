<?php

/**
 * LibreNMS
 *
 *   This file is part of LibreNMS.
 *
 * @package    librenms
 * @subpackage ajax
 * @copyright  (C) 2006 - 2012 Adam Armstrong
 */

use LibreNMS\Authentication\LegacyAuth;

$init_modules = array('web', 'auth');
require realpath(__DIR__ . '/..') . '/includes/init.php';

set_debug($_REQUEST['debug']);

if (!LegacyAuth::check()) {
    echo 'unauthenticated';
    exit;
}

if (is_numeric($_GET['device_id'])) {
    $results = dbFetch('SELECT * FROM ports WHERE device_id = ?', array($_GET['device_id']));
    $results = collect($results)->sortBy('ifName', SORT_NATURAL);

    foreach ($results as $interface) {
        $interface  = cleanPort($interface);
        $string = addslashes(html_entity_decode($interface['label'].' - '.$interface['ifAlias']));
        echo "obj.options[obj.options.length] = new Option('".$string."','".$interface['port_id']."');\n";
    }
}
