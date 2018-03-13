<?php
require 'function.inc.php';
mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
$result = mysql("sky_switch", "SELECT * from __dom_list where coordinates > 0");
$num=mysql_num_rows($result);
$row = mysql_fetch_array($result, MYSQL_BOTH);
$i=0;

echo ('
[');

   do {
        $i++;
		$buil=$row[0];
		$mem=linkinfo1($buil);
		$mem2=getnumberusers1($buil);
		$linktype=$mem['linktype'];
		$getus=$mem2;
		$linkbuild=$mem['linkbuild'];
		$linkcolor=$mem['linkcolor'];
		$linktypexxx=$mem['linktypexxx'];
		mysql_connect("localhost","root","zabbix");
		mysql_set_charset("utf8");
		$result2 = mysql("sky_switch", " select links_optica.*,__dom_list.*  from __dom_list,links_optica where __dom_list.id=links_optica.linkbuild and links_optica.buildid=$buil");
		$num=mysql_num_rows($result2);
	    $result3 = mysql ("sky_switch", " select switch.ip,__dom_list.*  from __dom_list,switch where switch.buildid=__dom_list.id and __dom_list.id=$buil");
	
		$num2=mysql_num_rows($result3);
		if ($num > 0) {			
		$coor=mysql_result($result2,0,"coordinates");
		$coor2=mysql_result($result2,0,"name");
   }
   
   if ($num2 > 0) {
	//for ($l=0;$l<$num2;$l++){	   
	//	$ip=$ip." ".mysql_result($result3,$l,"ip");
	$ip=mysql_result($result3,0,"ip");
	//}
   } else {
	   $ip="неуправляемый";
   }
		
		echo ('
	{
        "fields": {
			"coords": "['.$row[2].']",
			"name": "'.$row[1].'",
			"switchip": "'.$ip.'",
			"numberofusers": "'.$mem2.'",
			"description": "'.$linktypexxx.'",
			"id": "'.$row[0].'",
			"image": "$image",
			"geo": ['.$row[2].'],
			"linktype": "'.$linktype.'",
			"linkbuild": "'.$coor2.'",
			"linkcolor": "'.$linkcolor.'",
			"linkbuildgeo": ['.$coor.'],
			"advanced4": "$advanced4",
			"advanced5": "$advanced5",
			"advanced6": "$advanced6",
			"advanced7": "$advanced7",
			"geoS": "",
			"geoD": ""
		
        }
    }');
    if ($i<$row) {echo (',');}
        }
    while ($row = mysql_fetch_array( $result,MYSQL_BOTH));

echo ('
	]');
//echo (getusers($buil));
	
?>