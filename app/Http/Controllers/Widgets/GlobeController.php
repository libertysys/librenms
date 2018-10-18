<?php
/**
 * GlobeController.php
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
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Widgets;

use App\Models\Device;
use App\Models\Location;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\View\View;
use LibreNMS\Config;

class GlobeController extends WidgetController
{
    protected $title = 'Globe';

    public function __construct()
    {
        // init defaults we need to check config, so do it in construct
        $this->defaults = [
            'title' => null,
            'markers' => Config::get('frontpage_globe.markers', 'devices'),
            'region' => Config::get('frontpage_globe.region', 'world'),
            'resolution' => Config::get('frontpage_globe.resolution', 'countries'),
        ];
    }

    public function getSettingsView(Request $request)
    {
        return view('widgets.settings.globe', $this->getSettings());
    }

    /**
     * @param Request $request
     * @return View
     */
    public function getView(Request $request)
    {
        $data = $this->getSettings();
        $locations = collect();

        $dbl = Device::hasAccess($request->user())
            ->select('location')->whereNotNull('location')
            ->orderBy('location')->groupBy('location')
            ->pluck('location');

        foreach (Location::whereIn('location', $dbl)->get() as $location) {
            $count = 0;
            $up = 0;
            $down_items = collect();

            if ($data['markers'] == 'devices') {
                $devices = $location->devices();
                $count = $devices->count();
                list($devices_down, $devices_up) = $devices->partition(function ($device) {
                    return $device->status = 0;
                });
                $up = $devices_up->count();
                $down_items = $devices_down->map(function ($device) {
                    return $device->displayName() . ' DOWN';
                });
            } elseif ($data['markers'] == 'ports') {
                $devices = $location->devicesQuery()->with('ports')->get();

                foreach ($devices as $device) {
                    list($ports_down, $ports_up) = $device->ports->partition(function ($port) {
                        return $port->ifOperStatus == 'down' && $port->ifAdminStatus == 'up';
                    });
                    $count += $device->ports->count();
                    $up += $ports_up->count();
                    $down_items = $ports_down->map(function ($port) use ($device) {
                        return $device->displayName() . '/' . $port->getShortLabel() . ' DOWN';
                    });
                }
            }

            // indicate the number of up items before the itemized down
            $down_items->prepend($up .  '&nbsp;' . ucfirst($data['markers']) . '&nbsp;OK');

            $locations->push([
                $location->location,
                $count ? (1 - $up / $count) * 100 : 0, // percent down
                $count,
                $down_items->implode(',<br/> '),
            ]);
        }

        $data['locations'] = $locations->toJson();

        return view('widgets.globe', $data);
    }
}
