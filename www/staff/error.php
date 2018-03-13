#!/usr/local/bin/php -q
<?php
include('/home/sl/staff/groupswitch.php');
include('/home/sl/staff/switch.php');
include_once('/home/sl/staff/connect.inc');

 $a = new groupswitch();
 $a->error_all_switch();
?>