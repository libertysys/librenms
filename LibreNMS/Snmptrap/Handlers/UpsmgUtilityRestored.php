<?php
/**
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
 * @copyright  2018 PipoCanaja
 * @author     PipoCanaja <pipocanaja@gmail.com>
 */

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;
use Log;

class UpsmgUtilityRestored implements SnmptrapHandler
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
        $sensor = $device->sensors()->where('sensor_type', 'upsmgInputBadStatus')->first();
        if (!$sensor) {
            Log::warning("Snmptrap UpsmgUtilityRestored: Could not find matching sensor upsmgInputBadStatus for device: " . $device->hostname);
            return;
        }
        $sensor->sensor_current = 2;
        $sensor->save();
        $device_array = $device->toArray();
        log_event("UPS power restored, state sensor " . $sensor->sensor_descr . " has changed to ".$sensor->sensor_current . ".", $device_array, "Power", 1);
    }
}
