<?php
require 'function.inc.php';
mysql_connect("91.223.48.15","root","zabbix");
mysql_set_charset("utf8");
$result = mysql("sky_switch", "SELECT * from __dom_list where coordinates > 0");
$num=mysql_num_rows($result);
$row = mysql_fetch_array($result, MYSQL_BOTH);
$i=0;
		$misha=misha;
		$nuts=2;
		$beer=x;
		$beer2=xyz;
   do {
        $i++;
		$buil=$row[0];
		$mem=linkinfo1($buil);
		$linktype=$mem['linktype'];
		$linkbuild=$mem['linkbuild'];
		$linkcolor=$mem['linkcolor'];
		$linktypexxx=$mem['linktypexxx'];

		$result2 = mysql("sky_switch", " select links_optica.*,__dom_list.*  from __dom_list,links_optica where __dom_list.id=links_optica.linkbuild and links_optica.buildid=$buil");
		$num=mysql_num_rows($result2);
		if ($num > 0) {
			
		$coor=mysql_result($result2,0,"coordinates");
   }
		
		echo $buil,$beer,$linkcolor,$beer,$nuts,$beer,$misha,$beer,$row[2],$beer2,$coor,$beer,$row[1] . "\n";
    
	if ($i<$row) {echo (' ');}
        }
    while ($row = mysql_fetch_array( $result,MYSQL_BOTH));
?>