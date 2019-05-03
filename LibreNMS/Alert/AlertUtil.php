<?php
/**
 * AlertUtil.php
 *
 * Extending the built in logging to add an event logger function
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
 * @copyright  2019 KanREN, Inc.
 * @author     Heath Barnhart <hbarnhart@kanren.net>
 */

namespace LibreNMS\Alert;

use LibreNMS\Config;
use App\Models\Device;
use PHPMailer\PHPMailer\PHPMailer;
use LibreNMS\Authentication\LegacyAuth;

class AlertUtil
{
    /**
     *
     * Get the rule_id for a specific alert
     *
     * @param $alert_id
     * @return mixed|null
     */
    private static function getRuleId($alert_id)
    {
        $query = "SELECT `rule_id` FROM `alerts` WHERE `id`=?";
        return dbFetchCell($query, [$alert_id]);
    }

    /**
     *
     * Get the transport for a given alert_id
     *
     * @param $alert_id
     * @return array
     */
    public static function getAlertTransports($alert_id)
    {
        $query = "SELECT b.transport_id, b.transport_type, b.transport_name FROM alert_transport_map AS a LEFT JOIN alert_transports AS b ON b.transport_id=a.transport_or_group_id WHERE a.target_type='single' AND a.rule_id=? UNION DISTINCT SELECT d.transport_id, d.transport_type, d.transport_name FROM alert_transport_map AS a LEFT JOIN alert_transport_groups AS b ON a.transport_or_group_id=b.transport_group_id LEFT JOIN transport_group_transport AS c ON b.transport_group_id=c.transport_group_id LEFT JOIN alert_transports AS d ON c.transport_id=d.transport_id WHERE a.target_type='group' AND a.rule_id=?";
        $rule_id = self::getRuleId($alert_id);
        return dbFetchRows($query, [$rule_id, $rule_id]);
    }

    /**
     *
     * Returns the default transports
     *
     * @return array
     */
    public static function getDefaultAlertTransports()
    {
        $query = "SELECT transport_id, transport_type, transport_name FROM alert_transports WHERE is_default=true";
        return dbFetchRows($query);
    }

     /**
     * Find contacts for alert
     * @param array $results Rule-Result
     * @return array
     */
    public static function getContacts($results)
    {
        global $config;

        if (empty($results)) {
            return [];
        }
        if (Config::get('alert.default_only') === true || Config::get('alerts.email.default_only') === true) {
            $email = Config::get('alert.default_mail', Config::get('alerts.email.default'));
            return $email ? [$email => ''] : [];
        }
        $users = LegacyAuth::get()->getUserlist();
        $contacts = array();
        $uids = array();
        foreach ($results as $result) {
            $tmp  = null;
            if (is_numeric($result["bill_id"])) {
                $tmpa = dbFetchRows("SELECT user_id FROM bill_perms WHERE bill_id = ?", array($result["bill_id"]));
                foreach ($tmpa as $tmp) {
                    $uids[$tmp['user_id']] = $tmp['user_id'];
                }
            }
            if (is_numeric($result["port_id"])) {
                $tmpa = dbFetchRows("SELECT user_id FROM ports_perms WHERE port_id = ?", array($result["port_id"]));
                foreach ($tmpa as $tmp) {
                    $uids[$tmp['user_id']] = $tmp['user_id'];
                }
            }
            if (is_numeric($result["device_id"])) {
                if ($config['alert']['syscontact'] == true) {
                    if (dbFetchCell("SELECT attrib_value FROM devices_attribs WHERE attrib_type = 'override_sysContact_bool' AND device_id = ?", [$result["device_id"]])) {
                        $tmpa = dbFetchCell("SELECT attrib_value FROM devices_attribs WHERE attrib_type = 'override_sysContact_string' AND device_id = ?", array($result["device_id"]));
                    } else {
                        $tmpa = dbFetchCell("SELECT sysContact FROM devices WHERE device_id = ?", array($result["device_id"]));
                    }
                    if (!empty($tmpa)) {
                        $contacts[$tmpa] = '';
                    }
                }
                $tmpa = dbFetchRows("SELECT user_id FROM devices_perms WHERE device_id = ?", array($result["device_id"]));
                foreach ($tmpa as $tmp) {
                    $uids[$tmp['user_id']] = $tmp['user_id'];
                }
            }
        }
        foreach ($users as $user) {
            if (empty($user['email'])) {
                continue; // no email, skip this user
            }
            if (empty($user['realname'])) {
                $user['realname'] = $user['username'];
            }
            if (empty($user['level'])) {
                $user['level'] = LegacyAuth::get()->getUserlevel($user['username']);
            }
            if ($config['alert']['globals'] && ( $user['level'] >= 5 && $user['level'] < 10 )) {
                            $contacts[$user['email']] = $user['realname'];
            } elseif ($config['alert']['admins'] && $user['level'] == 10) {
                $contacts[$user['email']] = $user['realname'];
            } elseif ($config['alert']['users'] == true && in_array($user['user_id'], $uids)) {
                $contacts[$user['email']] = $user['realname'];
            }
        }

        $tmp_contacts = array();
        foreach ($contacts as $email => $name) {
            if (strstr($email, ',')) {
                $split_contacts = preg_split('/[,\s]+/', $email);
                foreach ($split_contacts as $split_email) {
                    if (!empty($split_email)) {
                        $tmp_contacts[$split_email] = $name;
                    }
                }
            } else {
                $tmp_contacts[$email] = $name;
            }
        }

        if (!empty($tmp_contacts)) {
            // Validate contacts so we can fall back to default if configured.
            $mail = new PHPMailer();
            foreach ($tmp_contacts as $tmp_email => $tmp_name) {
                if ($mail->validateAddress($tmp_email) != true) {
                    unset($tmp_contacts[$tmp_email]);
                }
            }
        }

        # Copy all email alerts to default contact if configured.
        if (!isset($tmp_contacts[$config['alert']['default_mail']]) && ($config['alert']['default_copy'])) {
            $tmp_contacts[$config['alert']['default_mail']] = '';
        }

        # Send email to default contact if no other contact found
        if ((count($tmp_contacts) == 0) && ($config['alert']['default_if_none']) && (!empty($config['alert']['default_mail']))) {
            $tmp_contacts[$config['alert']['default_mail']] = '';
        }

        return $tmp_contacts;
    }

    public static function getRules($device_id)
    {
        $query = "SELECT DISTINCT a.* FROM alert_rules a
        LEFT JOIN alert_device_map d ON a.id=d.rule_id
        LEFT JOIN alert_group_map g ON a.id=g.rule_id
        LEFT JOIN device_group_device dg ON g.group_id=dg.device_group_id
        WHERE a.disabled = 0 AND ((d.device_id IS NULL AND g.group_id IS NULL) OR d.device_id=? OR dg.device_id=?)";

        $params = [$device_id, $device_id];
        return dbFetchRows($query, $params);
    }

    /**
     * Check if device is under maintenance
     * @param int $device_id Device-ID
     * @return bool
     */
    public static function isMaintenance($device_id)
    {
        $device = \App\Models\Device::find($device_id);
        return !is_null($device) && $device->isUnderMaintenance();
    }

    /**
     * Process Macros
     * @param string $rule Rule to process
     * @param int $x Recursion-Anchor
     * @return string|boolean
     */
    public static function runMacros($rule, $x = 1)
    {
        global $config;
        krsort($config['alert']['macros']['rule']);
        foreach ($config['alert']['macros']['rule'] as $macro => $value) {
            if (!strstr($macro, " ")) {
                $rule = str_replace('%macros.'.$macro, '('.$value.')', $rule);
            }
        }
        if (strstr($rule, "%macros.")) {
            if (++$x < 30) {
                $rule = runMacros($rule, $x);
            } else {
                return false;
            }
        }
        return $rule;
    }
}
