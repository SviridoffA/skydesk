console.clear();
///////////////////////////////////////////////////////////////////////////////////////////////
ymaps.ready(init);
function init() {
    var myMap = new ymaps.Map("map", {
            center: [44.492124, 34.158581],
            zoom: 16
    });
///////////////////////////////////////////////////////////////////////////////////////////////	
	myMap.controls.add('routeEditor');
	myMap.controls.add(
  new ymaps.control.Button({
    data: {
      content: "wtf",
      image: ""
    },
    options: {
      maxWidth: 150
    }
  }
));

///////////////////////////////////////////////////////////////////////////////////////////////
var myListBox = new ymaps.control.ListBox({
    data: {
        content: 'Тип сети'
    },
    items: [
        new ymaps.control.ListBoxItem('Медь'),
        new ymaps.control.ListBoxItem('Оптика 100 Мбит'),
        new ymaps.control.ListBoxItem('Оптика 1Гбит')
    ]
});
///////////////////////////////////////////////////////////////////////////////////////////////
	myMap.controls.add(myListBox);
    var searchControl = new ymaps.control.SearchControl({

        options: {
            provider: 'yandex#search'
        }
    });
///////////////////////////////////////////////////////////////////////////////////////////////	
    myMap.events.add('contextmenu', function (e) {
        if (!myMap.balloon.isOpen()) {
            var coords = e.get('coords');
			
            myMap.balloon.open(coords, {
                contentHeader:'Координаты данной точки',
                contentBody:'<p>Координаты щелчка: ' + [
                    coords[0].toPrecision(6),
                    coords[1].toPrecision(6)
                    ].join(', ') + '</p>',
                contentFooter:'<sup> </sup>'
            });
        }
        else {
            myMap.balloon.close();
        }
    });
///////////////////////////////////////////////////////////////////////////////////////////////
    //myMap.controls.add(searchControl);
    searchControl.search('Магазин | Бар | Кафе | ООО | ИП | Клуб | Организация');
///////////////////////////////////////////////////////////////////////////////////////////////
    var coords = [];
    var names = [];
	var description = [];
	var switchip = [];
	var numberofusers = [];
	var description = [];
	var id = [];
	var image = [];
	var linktype = [];
	var linkbuild = [];
	var geo = [];
	var linkbuildgeo = [];
	var advanced4 = [];
	var advanced5 = [];
	var advanced6 = [];
	var advanced7 = [];
	var linkcolor = [];
///////////////////////////////////////////////////////////////////////////////////////////////	
$.getJSON(
        "http://skydesk.tk/sky-maps/data.json",
            function(data) {
            for (var key in data) {
                coords.push(data[key].fields.coords);
                names.push(data[key].fields.name);
				switchip.push(data[key].fields.switchip);
				numberofusers.push(data[key].fields.numberofusers);
				description.push(data[key].fields.description);
				id.push(data[key].fields.id);
				image.push(data[key].fields.image);
				linktype.push(data[key].fields.linktype);
				linkbuild.push(data[key].fields.linkbuild);
				advanced4.push(data[key].fields.advanced4);
				advanced5.push(data[key].fields.advanced5);
				advanced6.push(data[key].fields.advanced6);
				advanced7.push(data[key].fields.advanced7);		
				linkcolor.push(data[key].fields.linkcolor);	
 				geo.push(data[key].fields.geo);
				linkbuildgeo.push(data[key].fields.linkbuildgeo);	
            }

    var myCollection = new ymaps.GeoObjectCollection();
        for (var i = 0, l = id.length; i < l; i++) {
            var _coords = JSON.parse(coords[i]);
			var _geo = JSON.stringify(geo[i]);
			var _linkbuildgeo = JSON.stringify(linkbuildgeo[i]);
			var str = _geo + "," + _linkbuildgeo;
			var myPolyline = new ymaps.Polyline([
			//[parseFloat(_geo[0]),parseFloat(_geo[1])],[parseFloat(_linkbuildgeo[0]),parseFloat(_linkbuildgeo[1])]
			//[44.498797, 34.150731],[44.498514, 34.153579]
			str
			], {
			balloonContent: "Линк"
        }, {
 
            balloonCloseButton: true,
            strokeColor: "#000000",
            strokeWidth: 4,
            strokeOpacity: 0.5
        });
///////////////////////////////////////////////////////////////////////////////////////////////
			var group = myCollection;

			myCollection.add(new ymaps.Placemark([parseFloat(_coords[0]),parseFloat(_coords[1])],
            {
				iconContent: numberofusers[i],
                balloonContentHeader:names[i],
				balloonContent: "wtf?",
				balloonContentBody: [

			'<p align="center"><strong>Оборудование</strong></p>',
			'<strong>ID дома:</strong>',
			id[i],
			'<br/>',
			'<strong>Фото:</strong>', 
			image[i],
			'<br/>',
			'<strong>Описание:</strong>',
			description[i],
			'<br/>',
			'<strong>Линк приходит с </strong>',
			linkbuild[i],
			'<br/>',
			'<strong>Координаты:</strong>',
			coords[i],
			'<br/>',
			'<strong>IP Свича:</strong>', 
			switchip[i],
			'<br/>',
			'<p align="center"><strong>Абоненты</strong></p>',
			'<br/>',
			'<strong>Кол-во абонентов:</strong>',
			numberofusers[i],
			'<br/>',
			'<strong>Кол-во заявок на подключение:</strong>',
			advanced4[i],
			'<br/>',
			'<strong>Кол-во заявок на ремонт:</strong>',
			advanced5[i],
			'<br/>',
			'<strong>-----выполненых:</strong>',
			advanced6[i],
			'<br/>',
			'<strong>-----невыполненых::</strong>',
			advanced7[i],
			'<br/>'
			
        ].join('')
				}, {
            preset: 'islands#icon',
			iconColor: 
			linkcolor[i]
            }));



///////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////			
		console.log(str);
///////////////////////////////////////////////////////////////////////////////////////////////	
        }

    myMap.geoObjects.add(myPolyline);
	myMap.geoObjects.add(myCollection);
	})
	
	
	
	////////////////////////////////////////////
    var coords1 = [];
	var photo1 = [];
$.getJSON(
        "http://skydesk.tk/sky-maps/photo/data-mufty.json",
            function(data1) {
            for (var key in data1) {
                coords1.push(data1[key].fields.coords1);
				photo1.push(data1[key].fields.photo1);	
            }

    var myCollection1 = new ymaps.GeoObjectCollection();
        for (var i = 0, l = coords1.length; i < l; i++) {
            var _coords1 = JSON.parse(coords1[i]);
			var _photo1 = JSON.stringify(photo1[i]);

			myCollection1.add(new ymaps.Placemark([parseFloat(_coords1[0]),parseFloat(_coords1[1])],
            {
				iconContent: 'M',
                balloonContentHeader:coords[i],
				balloonContent: "wtf?",
				balloonContentBody: [
				"Я муфта"
        ].join('')
				}, {
            preset: 'islands#circleIcon',
			iconColor:'#663300'
            }));
        }

	myMap.geoObjects.add(myCollection1);
	})			
	
	
}
