ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map('map', {
            center: [55.76, 37.64],// ������
            zoom: 2,
            controls: ['zoomControl']
        }),
        ymapsmlButton = $('.load-ymapsml'),
        kmlButton = $('.load-kml');

    // ���������� ����������� �������� disabled � Firefox.
    ymapsmlButton.get(0).disabled = false;
    kmlButton.get(0).disabled = false;

    // ��� ������� �� ������ ��������� ��������������� XML-����.
    // � ���������� ��� ������ �� �����.
    ymapsmlButton.click(function (e) {
        ymaps.geoXml.load('https://maps.yandex.ru/export/usermaps/93jfWjoXws37exPmKH-OFIuj3IQduHal/')
            .then(onGeoXmlLoad);
        e.target.disabled = true;
    });
    kmlButton.click(function (e) {
        ymaps.geoXml.load('http://skyinet.org/Skyinet.kml')
            .then(onGeoXmlLoad);
        e.target.disabled = true;
    });

    // ���������� �������� XML-������.
    function onGeoXmlLoad (res) {
        myMap.geoObjects.add(res.geoObjects);
        if (res.mapState) {
            res.mapState.applyToMap(myMap);
        }
    }
}