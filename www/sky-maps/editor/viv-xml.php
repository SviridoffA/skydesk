<?php
header("Content-type: text/xml; charset=utf-8");
include("config.php");
echo '<?xml version="1.0" encoding="utf-8"?>
<ymaps:ymaps xmlns:ymaps="http://maps.yandex.ru/ymaps/1.x" xmlns:repr="http://maps.yandex.ru/representation/1.x" xmlns:gml="http://www.opengis.net/gml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://maps.yandex.ru/schemas/ymaps/1.x/ymaps.xsd"> 
    <repr:Representation>
		<repr:Style gml:id="customStyle"> 
			<repr:lineStyle> 
				<repr:strokeColor>FF9911</repr:strokeColor> 
				<repr:strokeWidth>4</repr:strokeWidth> 
			</repr:lineStyle> 
		</repr:Style> 
		<repr:Style gml:id="customStyle1"> 
			<repr:parentStyle>#customStyle</repr:parentStyle> 
			<repr:lineStyle> 
				<repr:strokeColor>FF00FF</repr:strokeColor> 
			</repr:lineStyle> 
		</repr:Style>		
	</repr:Representation> 
	<ymaps:GeoObjectCollection> 
		<gml:name>Полилинии из базы данных</gml:name>
		<gml:featureMembers>';
 
 
$result = mysql_query("SELECT id_line, coordinats FROM userslineymap");
if(mysql_num_rows($result)>0)
            {
			while ($mar = mysql_fetch_array($result))
            {
			echo '<ymaps:GeoObject>'; 
			echo '<gml:name>Маршрут-', $mar['id_line'], '</gml:name>';
			echo '	<gml:description>Маршрут в виде ломаной</gml:description>'; 
			echo '	<gml:LineString>';
 
			$str_exp1 = explode(";", $mar['coordinats']);
			for($i=0; $i<count($str_exp1); $i++)
			{
			$str_exp2 = explode(",", $str_exp1[$i]);
			echo '<gml:pos>', $str_exp2[0], ' ', $str_exp2[1], '</gml:pos>';
			}
 
			echo '</gml:LineString><ymaps:style>#customStyle1</ymaps:style></ymaps:GeoObject>';
 
			}
 
			}			
 
echo '</gml:featureMembers> 
	</ymaps:GeoObjectCollection> 
</ymaps:ymaps>';
?>