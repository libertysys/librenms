<?php
/**
 * Ericsson-ml.php
 *
 *
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\OS;

use LibreNMS\Device\WirelessSensor;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessFrequencyDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessPowerDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessRateDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessSnrDiscovery;
use LibreNMS\OS;

class Ericsson6600 extends OS implements
    WirelessFrequencyDiscovery,
    WirelessPowerDiscovery,
    WirelessRateDiscovery,
    WirelessSnrDiscovery
{
    public function discoverWirelessSnr()
    {
        $sensors = [];

        $data = snmpwalk_cache_oid($this->getDeviceArray(), 'xfCarrierTermSNIR', [], 'XF-RADIOLINK-RLT-MIB');
        foreach ($data as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'snr',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.193.81.3.4.5.1.3.1.17.' . $index,
                'ericsson-6600',
                $index,
                'SNR: ' . snmp_get($this->getDeviceArray(), 'xfCarrierTermDistinguishedName' . '.' . $index, '-Oqv', 'XF-RADIOLINK-RLT-MIB'),
                null,
                1,
                10
            );
        }

        return $sensors;
    }

    public function discoverWirelessRate()
    {
        $sensors = [];

        $data = snmpwalk_cache_oid($this->getDeviceArray(), 'xfCarrierTermActualCapacity', [], 'XF-RADIOLINK-RLT-MIB');
        foreach ($data as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'rate',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.193.81.3.4.5.1.3.1.13.' . $index,
                'ericsson-6600',
                $index,
                'Rate: ' . snmp_get($this->getDeviceArray(), 'xfCarrierTermDistinguishedName' . '.' . $index, '-Oqv', 'XF-RADIOLINK-RLT-MIB'),
                null,
                1000,
                1
            );
        }

        return $sensors;
    }

    public function discoverWirelessFrequency()
    {
        $sensors = [];

        $data_tx = snmpwalk_cache_oid($this->getDeviceArray(), 'xfRFBaseTxFrequency', [], 'XF-RADIOLINK-PTP-RADIO-MIB');
        $data_rx = snmpwalk_cache_oid($this->getDeviceArray(), 'xfRFBaseRxFrequency', [], 'XF-RADIOLINK-PTP-RADIO-MIB');
        foreach ($data_tx as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'frequency',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.193.81.3.4.3.1.2.1.1.' . $index,
                'ericsson-6600',
                $index . 'tx',
                'TX Frequency: ' . snmp_get($this->getDeviceArray(), 'ifName' . '.' . $index, '-Oqv', 'IF-MIB'),
                null,
                1,
                1000
            );
        }
        foreach ($data_rx as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'frequency',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.193.81.3.4.3.1.2.1.2.' . $index,
                'ericsson-6600',
                $index . 'rx',
                'RX Frequency: ' . snmp_get($this->getDeviceArray(), 'ifName' . '.' . $index, '-Oqv', 'IF-MIB'),
                null,
                1,
                1000
            );
        }

        return $sensors;
    }

    public function discoverWirelessPower()
    {
        $sensors = [];

        $data_tx = snmpwalk_cache_oid($this->getDeviceArray(), 'xfRfCurrentOutputPower', [], 'XF-RADIOLINK-PTP-RADIO-MIB');
        $data_rx = snmpwalk_cache_oid($this->getDeviceArray(), 'xfRfCurrentInputPower', [], 'XF-RADIOLINK-PTP-RADIO-MIB');
        foreach ($data_tx as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'power',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.193.81.3.4.3.1.8.1.3.' . $index,
                'ericsson-6600',
                $index . 'tx',
                'Output power: ' . snmp_get($this->getDeviceArray(), 'ifName' . '.' . $index, '-Oqv', 'IF-MIB'),
            );
        }
        foreach ($data_rx as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'power',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.193.81.3.4.3.1.8.1.7.' . $index,
                'ericsson-6600',
                $index . 'rx',
                'Input power: ' . snmp_get($this->getDeviceArray(), 'ifName' . '.' . $index, '-Oqv', 'IF-MIB'),
                null,
                1,
                10

            );
        }

        return $sensors;
    }

    //xfRLTMeasuredHopLength
}