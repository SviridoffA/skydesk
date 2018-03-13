#!/usr/bin/php -q
<?php
mysql_connect("91.223.48.25","root","");
$query="select * from dv_calls where nas_id=2";
$res=mysql("abills",$query);
$up = mysql_num_rows($res);
print "$up\n";
print "$up\n";
print "0\n";
print "0\n";
?>