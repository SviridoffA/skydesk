<?php
require 'function.inc.php';
mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
$result = mysql("sky_switch", "SELECT * from __dom_list where coordinates > 0");
$num=mysql_num_rows($result);
$row = mysql_fetch_array($result, MYSQL_BOTH);
$i=0;

   do {
        $i++;
		$buil=$row[0];
		$mem=linkinfo1($buil);
		$linktype=$mem['linktype'];
		$linkbuild=$mem['linkbuild'];
		$linkcolor=$mem['linkcolor'];
		$linktypexxx=$mem['linktypexxx'];
		$result2 = mysql("sky_switch", " select links_optica.*,__dom_list.*  from __dom_list,links_optica where __dom_list.id=links_optica.linkbuild and links_optica.buildid=$buil");
		//$result2 = mysql("sky_switch", "SELECT coordinates from __dom_list where id=$buil");
		$num=mysql_num_rows($result2);
		if ($num > 0) {
			
		$coor=mysql_result($result2,0,"coordinates");
   }
		
		echo ('
		['.$coor.'],['.$row[2].']');
    if ($i<$row) {echo (',');}
        }
    while ($row = mysql_fetch_array( $result,MYSQL_BOTH));

?>