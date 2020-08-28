<?php
/**
 * Dlink.php
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
 * @link       http://librenms.org
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\OS;

class Dlink extends \LibreNMS\OS
{
    public function discoverOS(): void
    {
        parent::discoverOS(); // yaml
        $device = $this->getDeviceModel();

        if (!empty($device->hardware) && $rev = snmp_get($this->getDevice(), '.1.3.6.1.2.1.16.19.3.0', '-Oqv')) {
            $device->hardware .= ' Rev. ' . $rev;
        }
    }
}
