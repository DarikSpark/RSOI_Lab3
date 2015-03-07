<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Быстрый старт. Размещение интерактивной карты на странице</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);
        var myMap;

        function init(){ 
            myMap = new ymaps.Map("map", {
                center: [55.771280,37.691521],
                zoom: 10
            });

            // УЛК - склад № 1
            var placemark = new ymaps.Placemark([55.771280,37.691521], {
                balloonContent: 'Склад Рубцовская набережная, 2/18',
                iconContent: "Склад №1"
            }, {
                preset: 'islands#darkGreenStretchyIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);

            // Казанский вокзал - склад № 2
            placemark = new ymaps.Placemark([55.772898,37.655458], {
                balloonContent: 'Склад Рязанский пр-д, 2',
                iconContent: "Склад №2"
            }, {
                preset: 'islands#violetStretchyIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);

            // Арбат - склад № 3
            placemark = new ymaps.Placemark([55.748126,37.586362], {
                balloonContent: 'Склад ул. Арбат, 44, стр. 1',
                iconContent: "Склад №3"
            }, {
                preset: 'islands#blueStretchyIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);

            // Павелецкий вокзал - КЛИЕНТ
            placemark = new ymaps.Placemark([55.726064,37.642599], {
                balloonContent: 'Склад ул. Летниковская, 10, стр. 3',
                iconContent: "КЛИЕНТ"
            }, {
                preset: 'islands#redStretchyIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);

            // Застрявшая фура
            placemark = new ymaps.Placemark([55.740911,37.652924], {
                balloonContent: 'Склад ул. Летниковская, 10, стр. 3',
                iconContent: ""
            }, {
                preset: 'islands#redCircleDotIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);

            // строим маршрут от Казанского вокзала к Павелецкому
            // (от склада № 2 до клиента)
            ymaps.route([{ type: 'wayPoint', point: [55.772898,37.655458] },
                { type: 'wayPoint', point: [55.726064,37.642599] }], {
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
            });

            // строим маршрут от Арбата к Павелецкому
            // (от склада № 3 до клиента)
            ymaps.route([{ type: 'wayPoint', point: [55.748126,37.586362] },
                { type: 'wayPoint', point: [55.726064,37.642599] }], {
                mapStateAutoApply: true
            }).then(function (route) {
                route.getPaths().options.set({
                    // в балуне выводим только информацию о времени движения с учетом пробок
                    balloonContenBodyLayout: ymaps.templateLayoutFactory.createClass('$[properties.humanJamsTime]'),
                    // можно выставить настройки графики маршруту
                    strokeColor: '00ff0000',
                    opacity: 0.9
                });
                //myMap.geoObjects.clear();
                // добавляем маршрут на карту
                myMap.geoObjects.add(route);
            });
        }
    </script>
</head>

<body>
    <div id="map" style="width: 800px; height: 600px"></div>
    <div id="barginfo" style="left: 600px; top: 10px; width: 250px;">
      <form>
    <p>Введите телефон в формате 2-xxx-xxx, где вместо x 
    должна быть цифра:</p>
    <p><input type="tel" pattern="2-[0-9]{3}-[0-9]{3}"></p>
    <p><input type="submit" value="Отправить"></p>
   </form>
    </div>

    <?php
    $bargainID = 70;
    $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
    mysql_select_db("user43199_roses", $db);
    mysql_set_charset('utf8');

    $result = mysql_query("SELECT city from city where cityID = (Select cityID from bargain where bargainID = $bargainID)");
    $cityName = mysql_fetch_array($result);

    $result = mysql_query("SELECT address from clients where clientID = (Select clientID from bargain where bargainID = $bargainID)");

    ?>
</body>

</html>