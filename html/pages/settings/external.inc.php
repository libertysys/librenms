<?php

$no_refresh = true;

$config_groups = get_config_by_group('external');

$oxidized_conf = array(
    array('name'               => 'oxidized.enabled',
          'descr'              => 'Enable Oxidized support',
          'type'               => 'checkbox',
    ),
    array('name'               => 'oxidized.url',
          'descr'              => 'URL to your Oxidized API',
          'type'               => 'text',
    ),
    array('name'               => 'oxidized.features.versioning',
          'descr'              => 'Enable config versioning access',
          'type'               => 'checkbox',
    ),
    array('name'               => 'oxidized.group_support',
          'descr'              => 'Enable the return of groups to Oxidized',
          'type'               => 'checkbox',
    ),
    array('name'               => 'oxidized.default_group',
          'descr'              => 'Set the default group returned',
          'type'               => 'text',
    ),
    array('name'               => 'oxidized.reload_nodes',
          'descr'              => 'Reload Oxidized nodes list, each time a device is added',
          'type'               => 'checkbox',
    ),
);

$unixagent_conf = array(
    array('name'               => 'unix-agent.port',
          'descr'              => 'Default unix-agent port',
          'type'               => 'text',
    ),
    array('name'               => 'unix-agent.connection-timeout',
          'descr'              => 'Connection timeout',
          'type'               => 'text',
    ),
    array('name'               => 'unix-agent.read-timeout',
          'descr'              => 'Read timeout',
          'type'               => 'text',
    ),
);

$rrdtool_conf = array(
    array('name'               => 'rrdtool',
           'descr'             => 'Path to rrdtool binary',
           'type'              => 'text',
    ),
    array('name'               => 'rrdtool_tune',
          'descr'              => 'Tune all rrd port files to use max values',
          'type'               => 'checkbox',
    ),
);

echo '
<div class="panel-group" id="accordion">
    <form class="form-horizontal" role="form" action="" method="post">
';

echo generate_dynamic_config_panel('Oxidized integration', $config_groups, $oxidized_conf, true);
echo generate_dynamic_config_panel('Unix-agent integration', $config_groups, $unixagent_conf, true);
echo generate_dynamic_config_panel('RRDTool Setup', $config_groups, $rrdtool_conf, true);

echo '
    </form>
</div>
';
