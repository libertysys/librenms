<?php

use Illuminate\Database\Seeder;

class DefaultConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config_values = [
            [
                "config_name" => "alert.ack_until_clear",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Default acknowledge until alert clears",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.admins",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "Alert administrators",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.default_copy",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "Copy all email alerts to default contact",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.default_if_none",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Send mail to default contact if no other contacts are found",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.default_mail",
                "config_value" => "",
                "config_default" => "",
                "config_descr" => "The default mail contact",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.default_only",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "Only alert default mail contact",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.disable",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Stop alerts being generated",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.fixed-contacts",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "If TRUE any changes to sysContact or users emails will not be honoured whilst alert is active",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.globals",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "Alert read only administrators",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.syscontact",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "Issue alerts to sysContact",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.tolerance_window",
                "config_value" => 5,
                "config_default" => 5,
                "config_descr" => "Tolerance window in seconds",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "alert.transports.mail",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Mail alerting transport",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "transports",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0",
            ],
            [
                "config_name" => "alert.users",
                "config_value" => 0,
                "config_default" => 0,
                "config_descr" => "Issue alerts to normal users",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_auto_tls",
                "config_value" => true,
                "config_default" => true,
                "config_descr" => "Enable / disable Auto TLS support",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_backend",
                "config_value" => "mail",
                "config_default" => "mail",
                "config_descr" => "The backend to use for sending email, can be mail, sendmail or smtp",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_from",
                "config_value" => null,
                "config_default" => null,
                "config_descr" => "Email address used for sending emails (from)",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_html",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Send HTML emails",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_sendmail_path",
                "config_value" => "/usr/sbin/sendmail",
                "config_default" => "/usr/sbin/sendmail",
                "config_descr" => "Location of sendmail if using this option",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_auth",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable / disable smtp authentication",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_host",
                "config_value" => "localhost",
                "config_default" => "localhost",
                "config_descr" => "SMTP Host for sending email if using this option",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_password",
                "config_value" => null,
                "config_default" => null,
                "config_descr" => "SMTP Auth password",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_port",
                "config_value" => 25,
                "config_default" => 25,
                "config_descr" => "SMTP port setting",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_secure",
                "config_value" => "",
                "config_default" => "",
                "config_descr" => "Enable / disable encryption (use tls or ssl)",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_timeout",
                "config_value" => 10,
                "config_default" => 10,
                "config_descr" => "SMTP timeout setting",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_smtp_username",
                "config_value" => null,
                "config_default" => null,
                "config_descr" => "SMTP Auth username",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "email_user",
                "config_value" => "LibreNMS",
                "config_default" => "LibreNMS",
                "config_descr" => "Name used as part of the from address",
                "config_group" => "alerting",
                "config_group_order" => "0",
                "config_sub_group" => "general",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "fping",
                "config_value" => "/usr/sbin/fping",
                "config_default" => "fping",
                "config_descr" => "Path to fping",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "paths",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "fping6",
                "config_value" => "/usr/sbin/fping6",
                "config_default" => "fping6",
                "config_descr" => "Path to fping6",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "paths",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "geoloc.api_key",
                "config_value" => "",
                "config_default" => "",
                "config_descr" => "Geocoding API Key (Required to function)",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "location",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "geoloc.engine",
                "config_value" => "",
                "config_default" => "",
                "config_descr" => "Geocoding Engine",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "location",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "oxidized.default_group",
                "config_value" => "",
                "config_default" => "",
                "config_descr" => "Set the default group returned",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "oxidized",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "oxidized.enabled",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable Oxidized support",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "oxidized",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "oxidized.features.versioning",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable Oxidized config versioning",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "oxidized",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "oxidized.group_support",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable the return of groups to Oxidized",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "oxidized",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "oxidized.reload_nodes",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Reload Oxidized nodes list, each time a device is added",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "oxidized",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "oxidized.url",
                "config_value" => "",
                "config_default" => "",
                "config_descr" => "Oxidized API url",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "oxidized",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "peeringdb.enabled",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable PeeringDB lookup (data is downloaded with daily.sh)",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "peeringdb",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "rrd.heartbeat",
                "config_value" => 600,
                "config_default" => 600,
                "config_descr" => "Change the rrd heartbeat value (default 600)",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "rrdtool",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "rrd.step",
                "config_value" => 300,
                "config_default" => 300,
                "config_descr" => "Change the rrd step value (default 300)",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "rrdtool",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "rrdtool",
                "config_value" => "/usr/bin/rrdtool",
                "config_default" => "/usr/bin/rrdtool",
                "config_descr" => "Path to rrdtool",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "rrdtool",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "rrdtool_tune",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Auto tune maximum value for rrd port files",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "rrdtool",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "snmpgetnext",
                "config_value" => "/usr/bin/snmpgetnext",
                "config_default" => "snmpgetnext",
                "config_descr" => "Path to snmpgetnext",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "paths",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "unix-agent.connection-timeout",
                "config_value" => 10,
                "config_default" => 10,
                "config_descr" => "Unix-agent connection timeout",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "unix-agent",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "unix-agent.port",
                "config_value" => 6556,
                "config_default" => 6556,
                "config_descr" => "Default port for the Unix-agent (check_mk)",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "unix-agent",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "unix-agent.read-timeout",
                "config_value" => 10,
                "config_default" => 10,
                "config_descr" => "Unix-agent read timeout",
                "config_group" => "external",
                "config_group_order" => "0",
                "config_sub_group" => "unix-agent",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.availability_map_box_size",
                "config_value" => 165,
                "config_default" => 165,
                "config_descr" => "Input desired tile width in pixels for box size in full view",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.availability_map_compact",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Availability map old view",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.availability_map_sort_status",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Sort devices and services by status",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.availability_map_use_device_groups",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable usage of device groups filter",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.default_dashboard_id",
                "config_value" => 0,
                "config_default" => 0,
                "config_descr" => "Global default dashboard_id for all users who do not have their own default set",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "dashboard",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.dynamic_graphs",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Enable dynamic graphs",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.global_search_result_limit",
                "config_value" => 8,
                "config_default" => 8,
                "config_descr" => "Global search results limit",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "search",
                "config_sub_group_order" => "0",
                "config_hidden" => "1",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.graph_stacked",
                "config_value" => false,
                "config_default" => false,
                "config_descr" => "Display stacked graphs instead of inverted graphs",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.graph_type",
                "config_value" => "png",
                "config_default" => "png",
                "config_descr" => "Set the default graph type",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "0",
                "config_disabled" => "0"
            ],
            [
                "config_name" => "webui.min_graph_height",
                "config_value" => 300,
                "config_default" => 300,
                "config_descr" => "Minimum Graph Height",
                "config_group" => "webui",
                "config_group_order" => "0",
                "config_sub_group" => "graph",
                "config_sub_group_order" => "0",
                "config_hidden" => "1",
                "config_disabled" => "0"
            ]
        ];

        $existing = DB::table('config')->pluck('config_name');

        \DB::table('config')->insert(array_map(function ($entry) {
            $entry['config_value'] = serialize($entry['config_value']);
            $entry['config_default'] = serialize($entry['config_default']);
            return $entry;
        }, array_filter($config_values, function ($entry) use ($existing) {
            return !$existing->contains($entry['config_name']);
        })));
    }
}
