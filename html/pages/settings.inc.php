<?php

if ($_SESSION['userlevel'] == '10')
{
  foreach($_POST['cfg'] as $cfg_id=>$cfg_value) {
    if($_POST['disabled'][$cfg_id] != '1')
    {
      $cfg_disabled = 0;
    }
    else
    {
      $cfg_disabled = 1;
    } 
    dbUpdate(array('config_value' => "$cfg_value", 'config_disabled' => "$cfg_disabled"), 'config', '`config_id` = ?', array($cfg_id));
    $db_updated = 1;
  }

  if($db_updated == 1)
  {
    echo '<div class="alert alert-success">Config information has been updated.</div>';
  }
  elseif(isset($_POST['cfg']))
  {
    echo '<div class="alert alert-danger">Config failed to update.</div>';
  }

?>
    <div class="modal fade" id="new-config-form" role="dialog" aria-hidden="true" title="Create new config item">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <form role="form" class="new_config_form">
              <div class="form-group">
                <label for="new_conf_type">Config type</label>
                <select class="form-control" name="new_conf_type" id="new_conf_type" onChange="showInput();">
                  <option>Single</option>
                  <option>Standard Array</option>
                  <option>Multi Array</option>
                  <option>Single Array</option>
                </select>
              </div>
              <div class="form-group">
                <label for="new_conf_name">Config name</label>
                <input type="text" class="form-control" name="new_conf_name" id="new_conf_name" placeholder="Enter the config name">
              </div>

              <div class="form-group" id="single_value">
                <label for="new_conf_value">Config value</label>
                <input type="text" class="form-control" name="new_conf_single_value" id="new_conf_single_value" placeholder="Enter the config value">
              </div>
              <div class="form-group" id="multi_value">
                <label for="new_conf_value">Config value</label>
                <textarea class="form-control" rows="3" name="new_conf_multi_value" id="new_conf_multi_value" placeholder="Enter the config value, each item must be on a new line"></textarea>
              </div>
<script>
  function showInput()
  {
    confType = $("#new_conf_type").val();
    if(confType == 'Single' || confType == 'Single Array')
    {
      $('#multi_value').hide();
      $('#single_value').show();
    }
    else if(confType == 'Standard Array' || confType == 'Multi Array')
    {
      $('#single_value').hide();
      $('#multi_value').show();
    }
  }
$('#multi_value').toggle();
</script>
              <div class="form-group">
                <label for="new_conf_desc">Description</label>
                <input type="text" class="form-control" name="new_conf_desc" id="new_conf_desc" placeholder="Enter the description of this config item">
              </div>
            </div>
          </form>
            <div class="modal-footer">
              <button class="btn btn-success" id="submit">Add config</button>
              <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>
      </div>
    </div>

<?php

  $found=0;
  echo('
      <div class="row">
        <div class="col-md-12">
          <span id="thanks"></span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-9">
          <h4>System Settings</h4>
        </div>
        <div class="col-md-3">
          <div class="btn-toolbar" role="toolbar">
            <div class="btn-group">
              <button type="button" name="options" id="expand" class="btn btn-xs btn-default"> Expand
              <button type="button" name="options" id="collapse" class="btn btn-xs btn-default"> Collapse
              <button type="button" name="new_config" id="new_config_item" data-toggle="modal" data-target="#new-config-form" class="btn btn-xs btn-default"> New config item
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info">If you would like to disable a config option then ensure the tickbox is selected.</div>
        </div>
      </div>
      <form class="form-horizontal" role="form" action="" method="post">
      <div class="panel-group" id="accordion">
');

  foreach (dbFetchRows("SELECT config_id,config_group FROM `config` WHERE config_hidden='0' GROUP BY config_group ORDER BY config_group ASC") as $group)
  {
    list($grp_num,$grp_title) = explode("_",$group['config_group']);
    $found++;
    echo('
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#'.$grp_num.'_expand">
                '.$grp_title.'
              </a>
            </h4>
          </div>
          <div id="'.$grp_num.'_expand" class="panel-collapse collapse">
            <div class="panel-body">
');
    foreach (dbFetchRows("SELECT * FROM `config` WHERE config_group='".$group['config_group']."' ORDER BY config_sub_group ASC, config_name ASC") as $cfg)
    {
      $cfg_ids[] = $cfg['config_id'];
      $cfg_disabled = '';
      if($cfg['config_disabled'] == '1')
      {
        $cfg_disabled = 'checked';
      }
      echo('
              <div class="form-group">
                <label for="'.$cfg['config_id'].'" class="col-sm-3">'.$cfg['config_name'].': </label>
                <div class="col-sm-6">
                  <input type="input" class="form-control input-sm" name="cfg['.$cfg['config_id'].']" id="'.$cfg['config_id'].'" value="'.$cfg['config_value'].'">
                </div>
                <div class="col-sm-1">
                  <div data-toggle="tooltip" title="'.$cfg['config_desc'].'" class="toolTip glyphicon glyphicon-question-sign"></div>
<script>
$(".toolTip").tooltip();
</script>
                </div>
                <div class="col-sm-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="disabled['.$cfg['config_id'].']" id="'.$cfg['config_id'].'" value="1" '.$cfg_disabled.'>
                    </label>
                  </div>
                </div>
              </div>
');

    }

    echo('
            </div>
          </div>
        </div>
');

  }


    echo('
        <script>
          $("#expand").click(function () {
            $(".collapse").collapse("show");
          });
          $("#collapse").click(function () {
            $(".collapse").collapse("hide");
          });
        </script>
');

  if($found > 0)
  {
    echo('
         <div class="form-group">
           <div class="col-sm-6">
');

    echo('
             <button type="submit" class="btn btn-default">Update Config</button>
           </div>
         </div>
');
  }
  echo('
      </div>
    </form>
');

  echo("<pre>");
  print_r($config);
  echo("</pre>");

?>
<script>

  $(function() {
    $("button#submit").click(function(){
      $.ajax({
        type: "POST",
        url: "form_new_config.php",
        data: $('form.new_config_form').serialize(),
        success: function(msg){
          $("#thanks").html('<div class="alert alert-info">'+msg+'</div>')
          $("#new-config-form").modal('hide');
        },
        error: function(){
          alert("failure");
        }
      });
    });
  });
</script>

<?php


} else {
  include("includes/error-no-perm.inc.php");
}

?>
