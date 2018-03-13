<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
    <title>Skyinet EditLinks</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <script src="https://api-maps.yandex.ru/1.1/index.xml?coordorder=longlat" type="text/javascript"></script> 
 
	<script type="text/javascript"> 
 
	var polyline
 
        // Создание обработчика для события window.onLoad
        YMaps.jQuery(function () {
            // Создание экземпляра карты и его привязка к созданному контейнеру
            var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
 
            // Установка для карты ее центра и масштаба
            map.setCenter(new YMaps.GeoPoint(34.158581, 44.492124), 16);
 
			map.addControl(new YMaps.Zoom());
	        map.addControl(new YMaps.TypeControl());
	        map.addControl(new YMaps.ToolBar());
 
            // Создание ломанной
            var polyline = new YMaps.Polyline();
 
            // Установка параметров режима редактирования
            polyline.setEditingOptions({
			drawing: true,
                 menuManager: function (index, menuItems) {
                    menuItems.push({
                        id: "StopEditing",
                        title: '<span style="white-space:nowrap;">Завершить редактирование<span>',
                        onClick: function (polyline, pointIndex) {
                       polyline.stopEditing();	                      		
                       YMaps.jQuery("#coords").attr("value", polyline.getPoints().join('n'));
                       YMaps.jQuery.post("upload.php", {coords : polyline.getPoints().join(';')});					   
                        }
                    });
                    return menuItems;
                }
            });        
 
            // Добавление ломаной на карту
            map.addOverlay(polyline);		
 
 
            // Включение режима редактирования
            polyline.startEditing();
 
        })
    </script> 
</head> 
 
<body> 
<table> 
 <tr> 
  <td>
     <div id="YMapsID" style="width:1024px;height:750px"></div>
	</td>
	<td valign="top">
	 <textarea rows="15" cols="35" id="coords" name="coord"></textarea>
	</td>
	</tr>
	</table>
	<p><a href="/?p=" title="Skyinet EditLinks" target="_blank">Вернуться к картам</a></p>
 
</body> 
</html>