<?php
/**
 * UserPreferencesController.php
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

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\UserPref;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use LibreNMS\Authentication\LegacyAuth;
use LibreNMS\Authentication\TwoFactor;
use LibreNMS\Config;

class UserPreferencesController extends Controller
{
    private $valid_prefs = [
        'dashboard' => 'required|integer',
        'add_schedule_note_to_device' => 'required|integer',
        'locale' => 'required|in:en,ru',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $data = [
            'can_change_password' => LegacyAuth::get()->canUpdatePasswords($user->username),
            'dashboards' => Dashboard::allAvailable($user)->with('user')->get(),
            'default_dashboard' => UserPref::getPref($user, 'dashboard'),
            'note_to_device' => UserPref::getPref($user, 'add_schedule_note_to_device'),
            'locale' => UserPref::getPref($user, 'locale') ?: 'en',
            'locales' => [
                'en' => 'English',
                'ru' => 'русский',
            ],
        ];

        if (Config::get('twofactor')) {
            $twofactor = UserPref::getPref($user, 'twofactor');
            if ($twofactor) {
                $data['twofactor_uri'] = TwoFactor::generateUri($user->username, $twofactor['key'], $twofactor['counter'] !== false);
            }
            $data['twofactor'] = $twofactor;
        }

        return view('user.preferences', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pref' => ['required', Rule::in(array_keys($this->valid_prefs))],
            'value' => $this->valid_prefs[$request->pref] ?? 'required|integer',
        ]);

        UserPref::setPref($request->user(), $request->pref, $request->value);
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
