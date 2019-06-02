<?php
/**
 * DeviceGroup.php
 *
 * Dynamic groups of devices
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

namespace App\Models;

use LibreNMS\Alerting\QueryBuilderFluentParser;
use Permissions;

class DeviceGroup extends BaseModel
{
    public $timestamps = false;
    protected $fillable = ['name', 'desc', 'type'];
    protected $casts = ['rules' => 'array'];

    // ---- Helper Functions ----

    /**
     * Update the device groups for the given device or device_id
     *
     * @param Device|int $device
     */
    public static function updateGroupsFor($device)
    {
        $device = ($device instanceof Device ? $device : Device::find($device));
        if (!$device instanceof Device) {
            return; // could not load device
        }

        $device_group_ids = static::query()
            ->where('type', 'dynamic')
            ->get()
            ->filter(function ($device_group) use ($device) {
                /** @var DeviceGroup $device_group */
                return $device_group->getParser()
                    ->toQuery()
                    ->where('devices.device_id', $device->device_id)
                    ->exists();
            })->pluck('id');

        $device->groups()->sync($device_group_ids);
    }

    /**
     * Get a query builder parser instance from this device group
     *
     * @return QueryBuilderFluentParser
     */
    public function getParser()
    {
        return !empty($this->rules) ?
            QueryBuilderFluentParser::fromJson($this->rules) :
            QueryBuilderFluentParser::fromOld($this->pattern);
    }

    // ---- Query Scopes ----

    public function scopeHasAccess($query, User $user)
    {
        if ($user->hasGlobalRead()) {
            return $query;
        }

        return $query->whereIn('id', Permissions::deviceGroupsForUser($user));
    }

    // ---- Define Relationships ----

    public function devices()
    {
        return $this->belongsToMany('App\Models\Device', 'device_group_device', 'device_group_id', 'device_id');
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'device_group_device', 'device_group_id', 'device_id');
    }
}
