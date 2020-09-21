<?php
/**
 * OspfNbrStateChange.php
 *
 * -Description-
 * Handles ospfNbrStateChange SNMP traps. Trap is sent when an OSPF
 * neighbor changes state. Handler logs the change and updates the
 * neighbor's information in the ospf_nbrs table.
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
 * @copyright  2020 KanREN Inc
 * @author     Heath Barnhart <hbarnhart@kanren.net>
 */

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;
use Log;

class OspfNbrStateChange implements SnmptrapHandler
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
        $ospfNbrIpAddr = $trap->getOidData($trap->findOid('OSPF-MIB::ospfNbrRtrId'));
        $ospfNbr = $device->ospfNbrs()->where('ospfNbrRtrId', $ospfNbrIpAddr)->first();

        $ospfNbr->ospfNbrState = $trap->getOidData($trap->findOid('OSPF-MIB::ospfNbrState'));

        $severity = 4;

        if ($ospfNbr->ospfNbrState == 'full') {
            $severity = 1;
        } elseif ($ospfNbr->ospfNbrState == 'down') {
            $severity = 5;
        }

        Log::event("OSPF neighbor $ospfNbrIpAddr changed state to $ospfNbr->ospfNbrState", $device->device_id, 'trap', $severity);

        $ospfNbr->save();
    }
}
