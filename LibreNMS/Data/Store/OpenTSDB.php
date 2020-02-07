<?php
/**
 * OpenTSDB.php
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

namespace LibreNMS\Data\Store;

use Carbon\Carbon;
use LibreNMS\Config;
use LibreNMS\Interfaces\Data\Datastore as DatastoreContract;
use Log;

class OpenTSDB implements DatastoreContract
{
    /** @var \Socket\Raw\Socket $connection */
    protected $connection;

    public function __construct(\Socket\Raw\Factory $socketFactory)
    {
        $host = Config::get('opentsdb.host');
        $port = Config::get('opentsdb.port', 2181);
        try {
            $this->connection = $socketFactory->createClient("$host:$port");
        } catch (\Socket\Raw\Exception $e) {
            Log::debug('OpenTSDB Error: ' . $e->getMessage());
        }

        if ($this->connection) {
            Log::notice('Connected to OpenTSDB');
        } else {
            Log::error('Connection to OpenTSDB has failed!');
        }
    }

    /**
     * Datastore-independent function which should be used for all polled metrics.
     *
     * RRD Tags:
     *   rrd_def     RrdDefinition
     *   rrd_name    array|string: the rrd filename, will be processed with rrd_name()
     *   rrd_oldname array|string: old rrd filename to rename, will be processed with rrd_name()
     *   rrd_step             int: rrd step, defaults to 300
     *
     * @param array $device
     * @param string $measurement Name of this measurement
     * @param array $tags tags for the data (or to control rrdtool)
     * @param array|mixed $fields The data to update in an associative array, the order must be consistent with rrd_def,
     *                            single values are allowed and will be paired with $measurement
     */
    public function put($device, $measurement, $tags, $fields)
    {
        if (!$this->connection) {
            Log::error("OpenTSDB Error: not connected\n");
            return;
        }

        $flag = Config::get('opentsdb.co');
        $timestamp = Carbon::now()->timestamp;
        $tmp_tags = "hostname=".$device['hostname'];

        foreach ($tags as $k => $v) {
            $v = str_replace(array(' ',',','='), '_', $v);
            if (!empty($v)) {
                $tmp_tags = $tmp_tags ." ". $k ."=".$v;
            }
        }

        if ($measurement == 'port') {
            foreach ($fields as $k => $v) {
                $measurement = $k;
                if ($flag == true) {
                    $measurement = $measurement.".".$device['co'];
                }

                $this->putData('port.'.$measurement, $timestamp, $v, $tmp_tags);
            }
        } else {
            if ($flag == true) {
                $measurement = $measurement . '.' . $device['co'];
            }

            foreach ($fields as $k => $v) {
                $tmp_tags_key = $tmp_tags . " " . "key" . "=" . $k;
                $this->putData($measurement, $timestamp, $v, $tmp_tags_key);
            }
        }
    }

    private function putData($measurement, $timestamp, $tags, $value)
    {
        try {
            $line = sprintf('put net.%s %d %f %s', strtolower($measurement), $timestamp, $value, $tags);
            Log::debug("Sending to OpenTSDB: $line\n");
            $this->connection->write("$line\n"); // send $line into OpenTSDB
        } catch (\Socket\Raw\Exception $e) {
            Log::error('OpenTSDB Error: ' . $e->getMessage());
        }
    }

    public static function isEnabled()
    {
        return Config::get('opentsdb.enable', false);
    }

    /**
     * Checks if the datastore wants rrdtags to be sent when issuing put()
     *
     * @return boolean
     */
    public function wantsRrdTags()
    {
        return false;
    }
}
