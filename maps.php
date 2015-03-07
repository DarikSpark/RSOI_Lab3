<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Maps</title>
    <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>

<body>

<div id="map" style="width: 600px; height: 400px"></div>

<script type="text/javascript">
    ymaps.ready(init);
    var myMap;

    function init(){     
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10
        });
        
        //findRoute();
    }
    
    function findRoute() {
        var toFind = document.getElementById('toFind').value;
        //alert(toFind);
        ymaps.route(['Королев', toFind], {
         mapStateAutoApply: true
     }).then(function (route) {
         route.getPaths().options.set({
             // в балуне выводим только информацию о времени движения с учетом пробок
             balloonContenBodyLayout: ymaps.templateLayoutFactory.createClass('$[properties.humanJamsTime]'),
             // можно выставить настройки графики маршруту
             strokeColor: '0000ffff',
             opacity: 0.9
         });
         //myMap.geoObjects.clear();
         // добавляем маршрут на карту
         myMap.geoObjects.add(route);

        var balloon = myMap.balloon.open(myMap.getCenter(), { content: 'Длина пути: ' + route.getLength() }, { closeButton: true });
     });
    }

</script>




<?php

$bargainID = 70;
$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

$result = mysql_query("SELECT city from city where cityID = (Select cityID from bargain where bargainID = $bargainID)");
$cityName = mysql_fetch_array($result);

$result = mysql_query("SELECT address from clients where clientID = (Select clientID from bargain where bargainID = $bargainID)");
$addressbarg  = mysql_fetch_array($result);

$query = mysql_query('CALL get_gps(' . $bargainID . ')');
$bargainGPS = mysql_fetch_array($query);

echo '<input type="text" value="' . $cityName[0] . ', ' . $addressbarg[0] . '" id="toFind">';
echo '<input type="button" onclick="findRoute()" value="Find me completely">';

echo '<br>';
echo '<input type="button" onclick="getRoute()" value="Your bunny route">';

echo '<input type="text" value="' . $bargainGPS[0] . ', ' . $bargainGPS[1] . '">';

?>

</body>
</html>