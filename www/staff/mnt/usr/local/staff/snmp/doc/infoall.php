<?php
include('groupswitch.php');
include('switch.php');
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

 $a = new groupswitch();
 echo $a->info_all_switch();
?>