<?php

### Database config
$config['db_host'] = "localhost";
$config['db_user'] = "observer";
$config['db_pass'] = "password";
$config['db_name'] = "observer";

### Installation Location
$config['install_dir'] 	= "/opt/observer/";
$config['html_dir']	= $config['install_dir'] . "html";
$config['rrd_dir'] 	= $config['install_dir'] . "rrd";
$rrd_dir = $config['rrd_dir'];

$config['mibs_dir']	= "/usr/share/snmp/mibs/";

### Default community
$config['community'] = "v05tr0n82";
$community = $config['community'];

$config['base_url'] = "http://dev.project-observer.org";

### Location of executables

$config['sipcalc'] = "/usr/bin/sipcalc";

$config['rrdtool'] = "/usr/bin/rrdtool";
$rrdtool = $config['rrdtool'];

$config['fping'] = "/usr/sbin/fping";
$fping = $config['fping'];

$config['ipcalc'] = "/usr/bin/ipcalc";
$ipcalc = $config['ipcalc'];

$config['snmpwalk'] = "/usr/bin/snmpwalk";
$snmpwalk = $config['snmpwalk'];

$config['snmpget'] = "/usr/bin/snmpget";
$snmpget = $config['snmpget'];

### RRDGraph Settings

# Set the general colours and other settings for rrdtool graphs

$config['rrdgraph_defaults'] = array("-c", "BACK#FFFFFF", "-c", "SHADEA#E5E5E5", "-c", "SHADEB#E5E5E5",
                                     "-c", "FONT#000000", "-c", "CANVAS#FFFFFF", "-c", "GRID#aaaaaa",
                                     "-c", "MGRID#FFAAAA", "-c", "FRAME#5e5e5e", "-c", "ARROW#5e5e5e",
                                     "-R", "normal");

$config['overlib_defaults'] = ",FGCOLOR,'#e5e5e5', BGCOLOR, '#e5e5e5'";


### List of networks to allow scanning-based discovery
##  This should probably be set to just the IP space you own!
$config['nets'] =  array ("89.21.224.0/19", "10.0.0.0/8", "172.22.0.0/16", "213.253.1.0/24");

### Your domain name and specifics
$config['mydomain'] = "vostron.net";
$config['header_color'] = "#163275";
$config['page_title']  = "Observer Test Install";
$config['title_image'] = "images/observer-header.png";
$config['stylesheet']  = "css/styles.css"; 
$config['mono_font'] = $config['install_dir'] . "/fonts/DejaVuSansMono.ttf";
$mono_font = $config['mono_font'];
$config['favicon'] = "favicon.ico";

$config['page_refresh'] = "60";  ## Refresh the page every xx seconds

$config['email_default']  = "you@yourdomain";
$config['email_from']     = "Observer <observer@yourdomain>";
$config['email_headers']  = "From: " . $config['email_from'] . "\r\n";


### Which interface sections should we show?

$config['int_customers'] = 1;   # Enable Customer Port Parsing
$config['int_transit'] = 1;     # Enable Transit Types
$config['int_peering'] = 1;     # Enable Peering Types
$config['int_core'] = 1;        # Enable Core Port Types
$config['int_l2tp'] = 1;        # Enable L2TP Port Types

$config['show_locations'] = 1;  # Enable Locations on menu

### Which additional features should we enable?

$config['enable_bgp'] = 1; # Enable BGP session collection and display
$config['enable_syslog'] = 1;   # Enable Syslog

## If a syslog entry contails these strings it is deleted from the database
$config['syslog_filter'] = array("last message repeated", "Connection from UDP: [127.0.0.1]:"); 

$config['syslog_age']    = "1 month"; ## Time to keep syslog for in 
                                      ## MySQL DATE_SUB format (eg '1 day', '1 month')

### Interface name strings to ignore
$config['bad_if'] = array("null", "virtual-", "unrouted", "eobc", "mpls", "sl0", "lp0", "faith0",
             "-atm layer", "-atm subif", "-shdsl", "-adsl", "-aal5", "-atm",
             "async", "plip", "-physical", "-signalling", "control plane",
             "bri", "-bearer", "ng", "bluetooth", "isatap", "ras", "qos", "miniport");

### Mountpoints to ignore

$config['ignore_mount'] = array("/kern", "/mnt/cdrom", "/dev", "/dev/pts", "/proc/bus/usb");

### Style Options

$list_colour_a = "#ffffff";
$list_colour_b = "#e5e5e5";

$warn_colour_a = "#ffeeee";
$warn_colour_b = "#ffcccc";

?>
