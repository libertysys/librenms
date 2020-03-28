<?php
/**
 * ShowConfigController.php
 *
 * -Description-
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
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Device\Tabs;

use App\Facades\DeviceCache;
use App\Models\Device;
use Auth;
use LibreNMS\Config;
use LibreNMS\Interfaces\UI\DeviceTab;

class ShowConfigController implements DeviceTab
{
    private $rancidFile;

    public function __construct()
    {
        if (Auth::user()->hasGlobalAdmin()) {
            $this->rancidFile = $this->findRancidConfigFile();
        }
    }

    public function visible(Device $device): bool
    {
        return Auth::user()->hasGlobalAdmin() && (isset($this->rancidFile) || $this->oxidizedEnabled($device));
    }

    public function slug(): string
    {
        return 'showconfig';
    }

    public function icon(): string
    {
        return 'fa-align-justify';
    }

    public function name(): string
    {
        return __('Config');
    }

    public function data(Device $device): array
    {
        return [
            'rancid_file' => $this->rancidFile,
        ];
    }

    private function oxidizedEnabled(Device $device)
    {
        return Config::get('oxidized.enabled') === true
            && Config::has('oxidized.url')
            && !$device->getAttrib('override_Oxidized_disable');
    }

    private function findRancidConfigFile()
    {
        if (Config::has('rancid_configs') && !is_array(Config::get('rancid_configs'))) {
            Config::set('rancid_configs', (array)Config::get('rancid_configs', []));
        }

        if (Config::has('rancid_configs.0')) {
            $device = DeviceCache::getPrimary();
            foreach (Config::get('rancid_configs') as $configs) {
                if ($configs[(strlen($configs) - 1)] != '/') {
                    $configs .= '/';
                }

                if (is_file($configs . $device['hostname'])) {
                    return $configs . $device['hostname'];
                } elseif (is_file($configs . strtok($device['hostname'], '.'))) { // Strip domain
                    return $configs . strtok($device['hostname'], '.');
                } else {
                    if (!empty(Config::get('mydomain'))) { // Try with domain name if set
                        if (is_file($configs . $device['hostname'] . '.' . Config::get('mydomain'))) {
                            return $configs . $device['hostname'] . '.' . Config::get('mydomain');
                        }
                    }
                }
            }
        }

        return null;
    }
}