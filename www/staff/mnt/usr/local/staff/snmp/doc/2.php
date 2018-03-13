<?php
$str="Cisco IOS Software, C3560 Software (C3560-ADVIPSERVICESK9-M), Version 12.2(35)SE, RELEASE SOFTWARE (fc2)
Copyright (c) 1986-2006 by Cisco Systems, Inc.
Compiled Sun 03-Dec-06 14:38 by yenanh";
$ss=ereg_replace("","",$str);
// echo $ss."\n";
$ss=ereg_replace("\n","",$str);
echo $ss;

?>