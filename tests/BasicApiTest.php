<?php
/**
 * BasicApiTest.php
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
 * @copyright  2019 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Tests;

use App\Models\ApiToken;
use App\Models\Device;
use App\Models\User;

class BasicApiTest extends DBTestCase
{
    public function testListDevices()
    {
        $user = factory(User::class)->state('admin')->create();
        $token = ApiToken::generateToken($user);
        $device = factory(Device::class)->create();

        $this->json('GET', '/api/v0/devices', [], ['X-Auth-Token' => $token->token_hash])
            ->assertStatus(200)
            ->assertJson([
                "status" => "ok",
                "devices" => [$device->toArray()],
                "count"=> 1
            ]);
    }
}
