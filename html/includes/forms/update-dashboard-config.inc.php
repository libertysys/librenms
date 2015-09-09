<?php

$status  = 'error';
$message = 'Error updating user dashboard config';

$data = json_decode($_POST['data'],true);
$sub_type = mres($_POST['sub_type']);
$widget_id = mres($_POST['widget_id']);
$dasboard_id = mres($_POST['dashboard_id']);

if ($sub_type == 'remove' && is_numeric($widget_id)) {
    if ($widget_id == 0 || dbDelete('users_widgets','`user_id`=? AND `user_widget_id`=? AND `dashboard_id`=?', array($_SESSION['user_id'],$widget_id,$dasboard_id))) {
        $status = 'ok';
        $message = '';
    }
}
elseif ($sub_type == 'remove-all') {
    if (dbDelete('users_widgets','`user_id`=? AND `dashboard_id`=?', array($_SESSION['user_id'],$dasboard_id))) {
        $status = 'ok';
        $message = '';
    }
}
elseif ($sub_type == 'add' && is_numeric($widget_id)) {
    $widget = dbFetchRow('SELECT * FROM `widgets` WHERE `widget_id`=?', array($widget_id));
    if (is_array($widget)) {
        list($x,$y) = explode(',',$widget['base_dimensions']);
        $item_id = dbInsert(array('user_id'=>$_SESSION['user_id'],'widget_id'=>$widget_id, 'col'=>1,'row'=>1,'refresh'=>60,'title'=>$widget['widget_title'],'size_x'=>$x,'size_y'=>$y,'settings'=>'','dashboard_id'=>$dasboard_id),'users_widgets');
        if (is_numeric($item_id)) {
            $extra = array('user_widget_id'=>$item_id,'widget_id'=>$item_id,'title'=>$widget['widget_title'],'widget'=>$widget['widget'],'refresh'=>60,'size_x'=>$x,'size_y'=>$y);
            $status = 'ok';
            $message = '';
        }
    }
}
else {
    $status = 'ok';
    $message = '';

    foreach ($data as $line) {
        if (is_array($line)) {
            $update = array('col'=>$line['col'],'row'=>$line['row'],'size_x'=>$line['size_x'],'size_y'=>$line['size_y']);
            dbUpdate($update, 'users_widgets', '`user_widget_id`=? AND `user_id`=? AND `dashboard_id`=?', array($line['id'],$_SESSION['user_id'],$dasboard_id));
        }
    }
}

$response = array(
    'status'        => $status,
    'message'       => $message,
    'extra'         => $extra,
);
echo _json_encode($response);
