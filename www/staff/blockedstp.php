<?php
include('groupswitch.php');
include('switch.php');
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

 $a = new groupswitch();
 $a->stp_all_switch();
?>