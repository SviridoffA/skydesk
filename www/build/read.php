<?php
echo "set charset utf8;\n";
$fp=fopen("coor","r");
while(!feof($fp)) {
$str=fgets($fp,1024);
$str=trim(fgets($fp,1024));
  $name=$str;
  $name=trim(ereg_replace("<TD HEIGHT=17 ALIGN=LEFT>","",$name));
  $name=trim(ereg_replace("</TD>","",$name));
$str=trim(fgets($fp,1024));
  $gps=$str;
  $gps=trim(ereg_replace("<TD ALIGN=LEFT>","",$gps));
  $gps=trim(ereg_replace("</TD>","",$gps));
$str=fgets($fp,1024);
echo "update __dom_list set coordinates='$gps' where name like '$name';\n";
}
?>