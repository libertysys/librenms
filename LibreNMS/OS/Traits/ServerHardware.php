<?php
/*
 * PCHardware.php
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

namespace LibreNMS\OS\Traits;

trait ServerHardware
{
    protected function discoverServerHardware()
    {
        $this->discoverDellHardware() || $this->discoverHpHardware();
    }

    protected function discoverDellHardware()
    {
        // Detect Dell hardware via OpenManage SNMP
        $hw = snmp_get_multi_oid($this->getDeviceArray(), [
            'MIB-Dell-10892::chassisModelName.1',
            'MIB-Dell-10892::chassisServiceTagName.1',
        ], '-OUQ', null, 'dell');

        if (empty($hw)) {
            return false;
        }

        $device = $this->getDevice();
        if (! empty($hw['MIB-Dell-10892::chassisModelName.1'])) {
            $device->hardware = 'Dell ' . $hw['MIB-Dell-10892::chassisModelName.1'];
        }

        $device->serial = $hw['MIB-Dell-10892::chassisServiceTagName.1'] ?? $device->serial;

        return true;
    }

    protected function discoverHpHardware()
    {
        $hw = snmp_get_multi_oid($this->getDeviceArray(), [
            'CPQSINFO-MIB::cpqSiProductName.0',
            'CPQSINFO-MIB::cpqSiSysSerialNum.0',
        ], '-OUQ', null, 'hp');

        if (empty($hw)) {
            return false;
        }

        $device = $this->getDevice();
        $device->hardware = $hw['CPQSINFO-MIB::cpqSiProductName.0'] ?? $device->hardware;
        $device->serial = $hw['CPQSINFO-MIB::cpqSiSysSerialNum.0'] ?? $device->serial;

        return true;
    }
}
