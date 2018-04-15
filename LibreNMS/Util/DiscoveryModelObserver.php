<?php
/**
 * DiscoveryModelObserver.php
 *
 * Displays +,-,U,. while running discovery and adding,deleting,updating, and doing nothing.
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

namespace LibreNMS\Util;

use Illuminate\Database\Eloquent\Model as Eloquent;

class DiscoveryModelObserver
{
    public function saving(Eloquent $model)
    {
        if (!$model->isDirty()) {
            echo '.';
        }
    }

    public function updated(Eloquent $model)
    {
        echo 'U';
    }

    public function created(Eloquent $model)
    {
        echo '+';
    }

    public function deleted(Eloquent $model)
    {
        echo '-';
    }
}
