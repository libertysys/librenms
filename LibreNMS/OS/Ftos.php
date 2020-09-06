<?php
/**
 * Ftos.php
 *
 * Dell Force10 OS
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

namespace LibreNMS\OS;

class Ftos extends Dnos
{
    public function discoverOS(): void
    {
        parent::discoverOS(); // yaml

        $device = $this->getDeviceModel();
        $device->hardware = $this->getHardware();
    }

    protected function getHardware()
    {
        $hardware = [
            '.1.3.6.1.4.1.6027.1.1.1' => 'E1200',
            '.1.3.6.1.4.1.6027.1.1.2' => 'E600',
            '.1.3.6.1.4.1.6027.1.1.3' => 'E300',
            '.1.3.6.1.4.1.6027.1.1.4' => 'E610',
            '.1.3.6.1.4.1.6027.1.1.5' => 'E1200i',
            '.1.3.6.1.4.1.6027.1.2.1' => 'C300',
            '.1.3.6.1.4.1.6027.1.2.2' => 'C150',
            '.1.3.6.1.4.1.6027.1.3.1' => 'S50',
            '.1.3.6.1.4.1.6027.1.3.2' => 'S50E',
            '.1.3.6.1.4.1.6027.1.3.3' => 'S50V',
            '.1.3.6.1.4.1.6027.1.3.4' => 'S25P-AC',
            '.1.3.6.1.4.1.6027.1.3.5' => 'S2410CP',
            '.1.3.6.1.4.1.6027.1.3.6' => 'S2410P',
            '.1.3.6.1.4.1.6027.1.3.7' => 'S50N-AC',
            '.1.3.6.1.4.1.6027.1.3.8' => 'S50N-DC',
            '.1.3.6.1.4.1.6027.1.3.9' => 'S25P-DC',
            '.1.3.6.1.4.1.6027.1.3.10' => 'S25V',
            '.1.3.6.1.4.1.6027.1.3.11' => 'S25N',
        ];

        return $hardware[$this->getDeviceModel()->sysObjectID] ?? null;
    }
}
