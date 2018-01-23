<?php
/**
 * init.php
 *
 * Load includes and initialize needed things
 *
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

/**
 * @param array $modules Which modules to initialize
 */

use LibreNMS\Authentication\Auth;

global $config;

$install_dir = realpath(__DIR__ . '/..');
$config['install_dir'] = $install_dir;
chdir($install_dir);

require_once $install_dir . '/includes/common.php';

# composer autoload
if (!is_file($install_dir . '/vendor/autoload.php')) {
    c_echo("%RError: Missing dependencies%n, run: %Bcomposer install --no-dev%n\n\n");
}
require $install_dir . '/vendor/autoload.php';

if (version_compare(PHP_VERSION, '5.4', '>=')) {
    require_once $install_dir . '/lib/influxdb-php/vendor/autoload.php';
}

if (!function_exists('module_selected')) {
    function module_selected($module, $modules)
    {
        return in_array($module, (array) $modules);
    }
}

// function only files
require_once $install_dir . '/includes/dbFacile.php';
require_once $install_dir . '/includes/rrdtool.inc.php';
require_once $install_dir . '/includes/influxdb.inc.php';
require_once $install_dir . '/includes/opentsdb.inc.php';
require_once $install_dir . '/includes/graphite.inc.php';
require_once $install_dir . '/includes/datastore.inc.php';
require_once $install_dir . '/includes/billing.php';
require_once $install_dir . '/includes/syslog.php';
if (module_selected('mocksnmp', $init_modules)) {
    require_once $install_dir . '/tests/mocks/mock.snmp.inc.php';
} else {
    require_once $install_dir . '/includes/snmp.inc.php';
}
require_once $install_dir . '/includes/services.inc.php';
require_once $install_dir . '/includes/mergecnf.inc.php';
require_once $install_dir . '/includes/functions.php';
require_once $install_dir . '/includes/rewrites.php';

if (module_selected('web', $init_modules)) {
    chdir($install_dir . '/html');
    require_once $install_dir . '/html/includes/functions.inc.php';
}

if (module_selected('discovery', $init_modules)) {
    require_once $install_dir . '/includes/discovery/functions.inc.php';
}

if (module_selected('polling', $init_modules)) {
    require_once $install_dir . '/includes/device-groups.inc.php';
    require_once $install_dir . '/includes/polling/functions.inc.php';
}

if (module_selected('alerts', $init_modules)) {
    require_once $install_dir . '/includes/device-groups.inc.php';
    require_once $install_dir . '/includes/alerts.inc.php';
}

// variable definitions
require $install_dir . '/includes/cisco-entities.php';
require $install_dir . '/includes/vmware_guestid.inc.php';
require $install_dir . '/includes/defaults.inc.php';
require $install_dir . '/includes/definitions.inc.php';

// Display config.php errors instead of http 500
$display_bak = ini_get('display_errors');
ini_set('display_errors', 1);
include $install_dir . '/config.php';
if (isset($config['php_memory_limit']) && is_numeric($config['php_memory_limit']) && $config['php_memory_limit'] > 128) {
    ini_set('memory_limit', $config['php_memory_limit'].'M');
}
ini_set('display_errors', $display_bak);

if (!module_selected('nodb', $init_modules)) {
    // Check for testing database
    if (getenv('DBTEST')) {
        if (isset($config['test_db_name'])) {
            $config['db_name'] = $config['test_db_name'];
        }
        if (isset($config['test_db_user'])) {
            $config['db_user'] = $config['test_db_user'];
        }
        if (isset($config['test_db_pass'])) {
            $config['db_pass'] = $config['test_db_pass'];
        }
    }

    // Connect to database
    try {
        dbConnect();
    } catch (\LibreNMS\Exceptions\DatabaseConnectException $e) {
        if (isCli()) {
            echo 'MySQL Error: ' . $e->getMessage() . PHP_EOL;
        } else {
            echo "<h2>MySQL Error</h2><p>" . $e->getMessage() . "</p>";
        }
        exit(2);
    }

    // pull in the database config settings
    mergedb();

    // load graph types from the database
    require $install_dir . '/includes/load_db_graph_types.inc.php';

    // Process $config to tidy up
    require $install_dir . '/includes/process_config.inc.php';
}

try {
    Auth::get();
} catch (Exception $exception) {
    print_error('ERROR: no valid auth_mechanism defined!');
    echo $exception->getMessage() . PHP_EOL;
    exit();
}

if (module_selected('discovery', $init_modules) && !update_os_cache()) {
    // load_all_os() is called by update_os_cache() if updated, no need to call twice
    load_all_os();
} elseif (module_selected('web', $init_modules)) {
    load_all_os(!module_selected('nodb', $init_modules));
}

if (module_selected('web', $init_modules)) {
    umask(0002);
    if (!isset($config['title_image'])) {
        $config['title_image'] = 'images/librenms_logo_'.$config['site_style'].'.svg';
    }
    require $install_dir . '/html/includes/vars.inc.php';
}

$console_color = new Console_Color2();

if (module_selected('auth', $init_modules) ||
    (
        module_selected('graphs', $init_modules) &&
        isset($config['allow_unauth_graphs']) &&
        $config['allow_unauth_graphs'] != true
    )
) {
    require $install_dir . '/html/includes/authenticate.inc.php';
}
