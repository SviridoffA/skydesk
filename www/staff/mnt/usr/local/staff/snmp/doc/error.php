<?php
include('groupswitch.php');
include('switch.php');
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

// mysql_connect("195.72.157.242","root","htvjyn");

 $a = new groupswitch();
 $a->error_all_switch();
?>