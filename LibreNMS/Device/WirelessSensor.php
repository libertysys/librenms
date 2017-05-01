<?php
/**
 * WirelessSensor.php
 *
 * Wireless Sensors
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Device;

use LibreNMS\OS;

class WirelessSensor extends Sensor
{
    protected static $name = 'Wireless Sensor';
    protected static $table = 'wireless_sensors';
    protected static $data_name = 'wireless-sensor';

    private $access_point_ip;

    /**
     * Sensor constructor. Create a new sensor to be discovered.
     *
     * @param string $type Class of this sensor, must be a supported class
     * @param int $device_id the device_id of the device that owns this sensor
     * @param array|string $oids an array or single oid that contains the data for this sensor
     * @param string $subtype the type of sensor an additional identifier to separate out sensors of the same class, generally this is the os name
     * @param int|string $index the index of this sensor, must be stable, generally the index of the oid
     * @param string $description A user visible description of this sensor, may be truncated in some places (like graphs)
     * @param int|float $current The current value of this sensor, will seed the db and may be used to guess limits
     * @param int $multiplier a number to multiply the value(s) by
     * @param int $divisor a number to divide the value(s) by
     * @param string $aggregator an operation to combine multiple numbers. Supported: sum, avg
     * @param int $access_point_id The id of the AP in the access_points sensor this belongs to (generally used for controllers)
     * @param int|float $high_limit Alerting: Maximum value
     * @param int|float $low_limit Alerting: Minimum value
     * @param int|float $high_warn Alerting: High warning value
     * @param int|float $low_warn Alerting: Low warning value
     * @param int|float $entPhysicalIndex The entPhysicalIndex this sensor is associated, often a port
     * @param int|float $entPhysicalMeasured the table to look for the entPhysicalIndex, for example 'ports' (maybe unused)
     */
    public function __construct(
        $type,
        $device_id,
        $oids,
        $subtype,
        $index,
        $description,
        $current = null,
        $multiplier = 1,
        $divisor = 1,
        $aggregator = 'sum',
        $access_point_id = null,
        $high_limit = null,
        $low_limit = null,
        $high_warn = null,
        $low_warn = null,
        $entPhysicalIndex = null,
        $entPhysicalMeasured = null
    ) {
        $this->access_point_ip = $access_point_id;
        parent::__construct(
            $type,
            $device_id,
            $oids,
            $subtype,
            $index,
            $description,
            $current,
            $multiplier,
            $divisor,
            $aggregator,
            $high_limit,
            $low_limit,
            $high_warn,
            $low_warn,
            $entPhysicalIndex,
            $entPhysicalMeasured
        );
    }

    protected function toArray()
    {
        $sensor = parent::toArray();
        $sensor['access_point_id'] = $this->access_point_ip;
        return $sensor;
    }

    public static function discover(OS $os)
    {
        foreach (self::getTypes() as $type => $descr) {
            static::discoverType($os, $type);
        }
    }

    /**
     * Return a list of valid types with metadata about each type
     * $class => array(
     *  'short' - short text for this class
     *  'long'  - long text for this class
     *  'unit'  - units used by this class 'dBm' for example
     *  'icon'  - font awesome icon used by this class
     * )
     * @param bool $valid filter this list by valid types in the database
     * @param int $device_id when filtering, only return types valid for this device_id
     * @return array
     */
    public static function getTypes($valid = false, $device_id = null)
    {
        // Add new types here
        // FIXME I'm really bad with icons, someone please help!
        static $types = array(
            'clients' => array(
                'short' => 'Clients',
                'long' => 'Client Count',
                'unit' => '',
                'icon' => 'tablet',
            ),
            'quality' => array(
                'short' => 'Quality',
                'long' => 'Quality',
                'unit' => '%',
                'icon' => 'feed',
            ),
            'capacity' => array(
                'short' => 'Capacity',
                'long' => 'Capacity',
                'unit' => '%',
                'icon' => 'feed',
            ),
            'utilization' => array(
                'short' => 'Utilization',
                'long' => 'utilization',
                'unit' => '%',
                'icon' => 'percent',
            ),
            'ccq' => array(
                'short' => 'CCQ',
                'long' => 'Client Connection Quality',
                'unit' => '%',
                'icon' => 'wifi',
            ),
            'noise' => array(
                'short' => 'Noise',
                'long' => 'Noise',
                'unit' => 'dB',
                'icon' => 'signal',
            ),
            'noise-floor' => array(
                'short' => 'Noise Floor',
                'long' => 'Noise Floor',
                'unit' => 'dBm/Hz',
                'icon' => 'signal',
            ),
            'snr' => array(
                'short' => 'SNR',
                'long' => 'Signal-to-Noise Ratio',
                'unit' => 'dB',
                'icon' => 'signal',
            ),
            'rssi' => array(
                'short' => 'RSSI',
                'long' => 'Received Signal Strength Indicator',
                'unit' => 'dBm',
                'icon' => 'signal',
            ),
            'error-ratio' => array(
                'short' => 'Error Ratio',
                'long' => 'Bit/Packet Error Ratio',
                'unit' => '%',
                'icon' => 'exclamation-triangle',
            ),
            'error-rate' => array(
                'short' => 'BER',
                'long' => 'Bit Error Rate',
                'unit' => 'bps',
                'icon' => 'exclamation-triangle',
            ),
            'rate' => array(
                'short' => 'Rate',
                'long' => 'TX/RX Rate',
                'unit' => 'bps',
                'icon' => 'tachometer',
            ),
            'signal' => array(
                'short' => 'Signal',
                'long' => 'Signal Strength',
                'unit' => 'dBm',
                'icon' => 'signal',
            ),
            'power' => array(
                'short' => 'Power',
                'long' => 'TX/RX Power',
                'unit' => 'dBm',
                'icon' => 'bolt',
            ),
            'distance' => array(
                'short' => 'Distance',
                'long' => 'Distance',
                'unit' => 'km',
                'icon' => 'space-shuttle',
            ),
            'frequency' => array(
                'short' => 'Frequency',
                'long' => 'Frequency',
                'unit' => 'MHz',
                'icon' => 'line-chart',
            ),
        );

        if ($valid) {
            $sql = 'SELECT `sensor_class` FROM `wireless_sensors`';
            $params = array();
            if (isset($device_id)) {
                $sql .= ' WHERE `device_id`=?';
                $params[] = $device_id;
            }
            $sql .= ' GROUP BY `sensor_class`';

            $sensors = dbFetchColumn($sql, $params);
            return array_intersect_key($types, array_flip($sensors));
        }

        return $types;
    }

    protected static function getDiscoveryInterface($type)
    {
        return str_to_class($type, 'LibreNMS\\Interfaces\\Discovery\\Sensors\\Wireless') . 'Discovery';
    }

    protected static function getDiscoveryMethod($type)
    {
        return 'discoverWireless' . str_to_class($type);
    }

    protected static function getPollingInterface($type)
    {
        return str_to_class($type, 'LibreNMS\\Interfaces\\Polling\\Sensors\\Wireless') . 'Polling';
    }

    protected static function getPollingMethod($type)
    {
        return 'pollWireless' . str_to_class($type);
    }
}
