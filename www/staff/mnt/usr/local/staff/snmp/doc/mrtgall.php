#!/usr/local/bin/php -q
<?php
include('groupswitch.php');
//include('grp.php');
include('switch.php');
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

// echo "test";
 $a = new groupswitch();
 echo "WorkDir: /usr/local/apache/htdocs/mrtg1\n";
 echo "Options[_]: growright,bits\n";
 echo $a->mrtg_all_switch();
?>