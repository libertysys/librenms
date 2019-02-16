<?php
/**
 * equipStatusTrap.php
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
 * @copyright  2018 Vitali Kari
 * @author     Vitali Kari <vitali.kari@gmail.com>
 */

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;

class EquipStatusTrap implements SnmptrapHandler
{

    /**
     * Handle snmptrap.
     * Data is pre-parsed and delivered as a Trap.
     *
     * @param Device $device
     * @param Trap $trap
     * @return void
     */
    public function handle(Device $device, Trap $trap)
    {
        $severity = 0;
        $state = $trap->getOidData('EQUIPMENT-MIB::equipStatus.0');

        if ($state == 'warning' || $state == 'major' || $state == '5' || $state == '3') {
            $severity = 4;
        } elseif ($state == 'critical' || $state == '4') {
            $severity = 5;
        } elseif ($state == 'minor' || $state == '2') {
            $severity = 3;
        } elseif ($state == 'nonAlarmed' || $state == '1') {
            $severity = 1;
        } else {
            $severity = 0;
        }
        log_event('SNMP Trap: Equipment Status  ' . $state, $device->toArray(), 'state', $severity, $device->hostname);
    }
}
