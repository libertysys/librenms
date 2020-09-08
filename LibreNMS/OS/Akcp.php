<?php
/**
 * Akcp.php
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

namespace LibreNMS\OS;

use LibreNMS\Interfaces\Discovery\OSDiscovery;
use LibreNMS\OS;

class Akcp extends OS implements OSDiscovery
{
    public function discoverOS(): void
    {
        $data = snmp_get_multi($this->getDevice(), ['hhmsAgentManufName.0', 'hhmsAgentHtmlView.0'], '-OQUs', 'HHMSAGENT-MIB');

        $device = $this->getDeviceModel();
        $hardware = $data[0]['hhmsAgentManufName'] ?? null;
        $hardware .= ' ' . trim($data[0]['hhmsAgentHtmlView'] ?? '');

        if (empty(trim($hardware))) {
            preg_match('/SP\d+/', $device->sysDescr, $matches);
            $hardware = $matches[0];
        }

        $device->hardware = $hardware;
    }
}