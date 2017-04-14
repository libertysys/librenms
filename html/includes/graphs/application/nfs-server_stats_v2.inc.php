<?php
require 'includes/graphs/common.inc.php';
$scale_min     = 0;
$colours       = 'mixed';
$unit_text     = 'NFS v2 Operations';
$unitlen       = 10;
$bigdescrlen   = 15;
$smalldescrlen = 15;
$dostack       = 0;
$printtotal    = 0;
$addarea       = 1;
$transparency  = 33;
$rrd_filename  = $config['rrd_dir'].'/'.$device['hostname'].'/app-nfs-server-proc2-'.$app['app_id'].'.rrd';
$array         = array(
                 'proc2_null' => array('descr' => 'Null'),
                 'proc2_getattr' => array('descr' => 'Get attributes'),
                 'proc2_setattr' => array('descr' => 'Set attributes'),
                 'proc2_root' => array('descr' => 'Root'),
                 'proc2_lookup' => array('descr' => 'Lookup'),
                 'proc2_readlink' => array('descr' => 'ReadLink'),
                 'proc2_read' => array('descr' => 'Read'),
                 'proc2_wrcache' => array('descr' => 'Wrcache'),
                 'proc2_write' => array('descr' => 'Write'),
                 'proc2_create' => array('descr' => 'Create'),
                 'proc2_remove' => array('descr' => 'Remove'),
                 'proc2_rename' => array('descr' => 'Rename'),
                 'proc2_link' => array('descr' => 'Link'),
                 'proc2_symlink' => array('descr' => 'Symlink'),
                 'proc2_mkdir' => array('descr' => 'Mkdir'),
                 'proc2_rmdir' => array('descr' => 'Rmdir'),
                 'proc2_readdir' => array('descr' => 'Readdir'),
                 'proc2_fsstat' => array('descr' => 'fsstat')
                );

$i = 0;

if (is_file($rrd_filename)) {
    foreach ($array as $ds => $var) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = $var['descr'];
        $rrd_list[$i]['ds']       = $ds;
        $rrd_list[$i]['colour']   = $config['graph_colours']['default'][$i];
        $i++;
    }
} else {
    echo "file missing: $rrd_filename";
}

require 'includes/graphs/generic_v3_multiline.inc.php';
