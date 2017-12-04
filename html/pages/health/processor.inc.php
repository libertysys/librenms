<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       http://librenms.org
 * @copyright  2017 LibreNMS
 * @author     LibreNMS Contributors
*/

$pagetitle[] = "Health :: Processor";
?>

<div class="panel panel-default panel-condensed">
    <div class="panel-heading">
        <strong>Health :: Processor</strong>
        <div class="pull-right">
            <?php echo $displayoptions; ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="processor" class="table table-hover table-condensed processor">
            <thead>
                <tr>
                    <th data-column-id="hostname">Device</th>
                    <th data-column-id="processor_descr">Processor</th>
                    <th data-column-id="graph" data-sortable="false" data-searchable="false"></th>
                    <th data-column-id="processor_usage" data-searchable="false">Usage</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    var grid = $("#processor").bootgrid({
        ajax: true,
        rowCount: [50,100,250,-1],
        post: function ()
        {
            return {
                id: "processor",
                view: '<?php echo $vars['view']; ?>'
            };
        },
        url: "ajax_table.php"
    });

    $(".actionBar").append('<?php echo $navbar; ?>');
</script>
