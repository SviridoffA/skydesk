<?php
require 'function.inc.php';
mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
$result = mysql("sky_switch", "SELECT * from __dom_list where coordinates > 0");
$num=mysql_num_rows($result);
$row = mysql_fetch_array($result, MYSQL_BOTH);
$i=0;

echo ('
<?xml version="1.0" encoding="UTF-8"?>
<ymaps:ymaps xmlns:ymaps="http://maps.yandex.ru/ymaps/1.x"
             xmlns:repr="http://maps.yandex.ru/representation/1.x"
             xmlns:gml="http://www.opengis.net/gml"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:schemaLocation="http://maps.yandex.ru/schemas/ymaps/1.x/ymaps.xsd">
    <repr:Representation>
        <repr:Style gml:id="customStyle">
            <repr:lineStyle>
                <repr:strokeColor>FF9911</repr:strokeColor>
                <repr:strokeWidth>7</repr:strokeWidth>
            </repr:lineStyle>
        </repr:Style>
        <repr:Style gml:id="customStyle1">
            <repr:parentStyle>#customStyle</repr:parentStyle>
            <repr:lineStyle>
                <repr:strokeColor>FF0000</repr:strokeColor>
            </repr:lineStyle>
        </repr:Style>
    </repr:Representation>
    <ymaps:GeoObjectCollection>
        <gml:name>Ломаная и её стиль</gml:name>
        <gml:featureMembers>
');

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
		
		echo ('
            <ymaps:GeoObject>
                <gml:name>'.$row[1].'</gml:name>
                <gml:description>'.$linktypexxx.'</gml:description>
                <gml:LineString>
                    <gml:pos>'.$row[2].'</gml:pos>
                    <gml:pos>'.$coor.'</gml:pos>
                </gml:LineString>
                <ymaps:style>#customStyle1</ymaps:style>
            </ymaps:GeoObject>');
    
	if ($i<$row) {echo (' ');}
        }
    while ($row = mysql_fetch_array( $result,MYSQL_BOTH));

echo ('
        </gml:featureMembers>
    </ymaps:GeoObjectCollection>
</ymaps:ymaps>
');
?>