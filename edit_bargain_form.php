<?php
include("blocks/lock.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Форма редактирования сделки</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">



  <!-- КАРТА -->



<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<!--// подключение 2-го API -->
<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<!--// подключение 1-го API -->
<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AEj0sFMBAAAAOJBYSwIAH6Mwn6PFwSS_0dwYCKykbcezyqoAAAAAAAAAAAD3-94pRU2iMmpXkRPL8ZkyA5y0ZA==" type="text/javascript"></script>

<!--
<script type="text/javascript">
    // Создает обработчик события window.onLoad
    YMaps.jQuery(function () {
        // Создает экземпляр карты и привязывает его к созданному контейнеру
        var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);

        // Устанавливает начальные параметры отображения карты: центр карты и коэффициент масштабирования
        map.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);

        var router = new YMaps.Router(['Москва, Арбатская', 'Москва, метро Третьяковская']);
        YMaps.Events.observe(router, router.Events.Success, function() {
            router.getWayPoint(0).setIconContent('Точка отправления');
            router.getWayPoint(1).setIconContent('Точка прибытия');
            map.addOverlay(router);
            //alert("OK");
            //var route1 = router.getRoute(0);
            //alert(route1.getNumRouteSegments());
            //map.addOverlay(router);
        });

        YMaps.Events.observe(router, router.Events.GeocodeError, function (link, number) {
            alert('Ошибка при геокодировании');
        })
    })
</script>-->

<script type="text/javascript">
        ymaps.ready(init);
        var myMap;

        function init(){
            myMap = new ymaps.Map("YMapsID", {
                center: [55.771280,37.691521],
                zoom: 10
            });

            // УЛК - склад № 1
            var placemark = new ymaps.Placemark([55.771280,37.691521], {
                balloonContent: 'Склад Рубцовская набережная, 2/18',
                iconContent: "Склад №1  >>"
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
                iconContent: "Склад №2  >>"
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
                iconContent: "Склад №3  >>"
            }, {
                preset: 'islands#blueStretchyIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);

            /*
            // Павелецкий вокзал - КЛИЕНТ
            placemark = new ymaps.Placemark([55.726064,37.642599], {
                balloonContent: 'ул. Летниковская, 10, стр. 3',
                iconContent: "КЛИЕНТ  >>"
            }, {
                preset: 'islands#redStretchyIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);*/

            /*
            // Застрявшая фура
            placemark = new ymaps.Placemark([55.740911,37.652924], {
                balloonContent: 'Фура №2. Ул. Летниковская, 10, стр. 3',
                iconContent: ""
            }, {
                preset: 'islands#redCircleDotIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);
            */

            /*
            // строим маршрут от Казанского вокзала к Павелецкому
            // (от склада № 2 до клиента)
            ymaps.route([{ type: 'wayPoint', point: [55.772898,37.655458] },
                         { type: 'wayPoint', point: [55.726064,37.642599] }], {
                mapStateAutoApply: true
            }).then(function (route) {
                    route.getPaths().options.set({
                        // в балуне выводим только информацию о времени движения с учетом пробок
                        //balloonContenBodyLayout: ymaps.templateLayoutFactory.createClass('$[properties.humanJamsTime]'),
                        // можно выставить настройки графики маршруту
                        strokeColor: '0000ffff',
                        opacity: 0.9,
                        strokeWidth: 5
                    });
                    // добавляем маршрут на карту
                    //myMap.geoObjects.add(route);
                    myMap.geoObjects.add(route.getPaths());
                    // Устанавливаем центр и масштаб карты так, чтобы отобразить все геообъекты целиком.
                    //myMap.setBounds(myMap.geoObjects.getBounds());
                });*/

            /*
            // отображаем застрявшую фуру по gps-координатам из БД
            var bargainGPSlong = document.getElementById('bargainGPSlong').value;
            var bargainGPSlat = document.getElementById('bargainGPSlat').value;
            placemark = new ymaps.Placemark([bargainGPSlong, bargainGPSlat], {
                balloonContent: 'ФУРА',
                iconContent: ""
            }, {
                preset: 'islands#greenCircleDotIcon',
                // Отключаем кнопку закрытия балуна.
                balloonCloseButton: true,
                // Балун будем открывать и закрывать кликом по иконке метки.
                hideIconOnBalloonOpen: false
            });
            myMap.geoObjects.add(placemark);*/

            // отображаем местонахождение клиента по адресу из БД
            var cityName = document.getElementById('cityName').value;
            var addressbarg = document.getElementById('addressbarg').value;

            ymaps.geocode(cityName, { results: 1 }).then(function (res)
                {
                    // Выбираем первый результат геокодирования
                    var firstGeoObject = res.geoObjects.get(0);
                    var clientCoords = firstGeoObject.geometry.getCoordinates();

                    //alert(clientCoords[0]+' '+clientCoords[1]);

                    placemark = new ymaps.Placemark([clientCoords[0], clientCoords[1]], {
                        balloonContent: 'КЛИЕНТ',
                        iconContent: "КЛИЕНТ"
                    }, {
                        preset: 'islands#darkGreenStretchyIcon',
                        // Отключаем кнопку закрытия балуна.
                        balloonCloseButton: true,
                        // Балун будем открывать и закрывать кликом по иконке метки.
                        hideIconOnBalloonOpen: false
                    });
                    myMap.geoObjects.add(placemark);

                    // строим маршрут от склада №2 до клиента
                    ymaps.route([{ type: 'wayPoint', point: [55.772898,37.655458] },
                        { type: 'wayPoint', point: clientCoords }], {
                        mapStateAutoApply: true
                    }).then(function (route) {
                        route.getPaths().options.set({
                            // в балуне выводим только информацию о времени движения с учетом пробок
                            //balloonContenBodyLayout: ymaps.templateLayoutFactory.createClass('$[properties.humanJamsTime]'),
                            // можно выставить настройки графики маршруту
                            strokeColor: '0000ffff',
                            opacity: 0.9,
                            strokeWidth: 5
                        });
                        // добавляем маршрут на карту
                        myMap.geoObjects.add(route.getPaths());

                        var length = route.getPaths().get(0).geometry.getLength();
                        //alert(length);
                        // рандом от 0 до length
                        var rand = Math.floor(Math.random() * length);
                        var randCoords = route.getPaths().get(0).geometry.get(rand);
                        placemark = new ymaps.Placemark([randCoords[0], randCoords[1]], {
                            balloonContent: 'ФУРА',
                            iconContent: "ФУРА"
                        }, {
                            preset: 'islands#redStretchyIcon',
                            // Отключаем кнопку закрытия балуна.
                            balloonCloseButton: true,
                            // Балун будем открывать и закрывать кликом по иконке метки.
                            hideIconOnBalloonOpen: false
                        });
                        myMap.geoObjects.add(placemark);

                        /*
                        for (var i = 0; i  length; i++) {
                            if (i == 5)
                                break;
                            else {
                                var coords = route.getPaths().get(0).geometry.get(i);
                                //alert(coords);



                                placemark = new ymaps.Placemark([coords[0], coords[1]], {
                                    balloonContent: 'КЛИЕНТ',
                                    iconContent: "КЛИЕНТ"
                                }, {
                                    preset: 'islands#darkGreenStretchyIcon',
                                    // Отключаем кнопку закрытия балуна.
                                    balloonCloseButton: true,
                                    // Балун будем открывать и закрывать кликом по иконке метки.
                                    hideIconOnBalloonOpen: false
                                });
                                myMap.geoObjects.add(placemark);
                            }
                        }*/

                        //var wayPoints = route.getWayPoints();
                        //alert(wayPoints.length);

                        /*
                        var router = new YMaps.Router(['Москва, Арбатская', 'Москва, метро Третьяковская']);
                        YMaps.Events.observe(router, router.Events.Success, function() {
                            //router.getWayPoint(0).setIconContent('Точка отправления');
                            //router.getWayPoint(1).setIconContent('Точка прибытия');
                            //map.addOverlay(router);
                            //alert("OK");
                            //var route1 = router.getRoute(0);
                            //alert(route1.getNumRouteSegments());
                            //var map = new YMaps.Map(document.getElementById("map"));
                            //map.addOverlay(router);
                        });

                        YMaps.Events.observe(router, router.Events.GeocodeError, function (link, number) {
                            alert('Ошибка при геокодировании');
                        })*/

                    });

                    /*
                     for (var i = 0; i  segments.length; i++) {
                     alert("Hi");
                     }*/
                },
                function (err)
                {
                    // Если геокодирование не удалось, сообщаем об ошибке
                    alert("Не удалось найти местоположение клиента");
                });

            // Устанавливаем центр и масштаб карты так, чтобы отобразить все геообъекты целиком.
            //myMap.setBounds(myMap.geoObjects.getBounds());
        }
    </script>



<!-- КАРТА END -->


<!-- edit -->


<link rel="stylesheet" type="text/css" href="stylesheets/style.css">

<style type="text/css">
body
{
   margin: 0;
   padding: 0;
   background-color: #FFFFFF;
   color: #000000;
}
</style>
<link href="cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<style type="text/css">
a
{
   color: #0000FF;
   text-decoration: underline;
}
a:visited
{
   color: #800080;
}
a:active
{
   color: #FF0000;
}
a:hover
{
   color: #0000FF;
   text-decoration: underline;
}
h1
{
   font-family: Arial;
   font-size: 32px;
   font-weight: bold;
   font-style: normal;
   text-decoration: none;
   color: #000000;
   background-color: transparent;
   margin: 0px 0px 0px 0px;
   padding: 0px 0px 0px 0px;
   display: inline;
}
</style>
<style type="text/css">
#TabMenu1
{
   text-align: left;
   float: left;
   margin: 0;
   width: 100%;
   font-family: Arial;
   font-size: 13px;
   font-weight: normal;
   border-bottom: 1px solid #C0C0C0;
   list-style-type: none;
   padding: 15px 0px 4px 10px;
   overflow: hidden;
}
#TabMenu1 li
{
   float: left;
}
#TabMenu1 li a.active, #TabMenu1 li a:hover.active
{
   background-color: #FFFFFF;
   color: #666666;
   position: relative;
   font-weight: normal;
   text-decoration: none;
   z-index: 2;
}
#TabMenu1 li a
{
   padding: 5px 14px 8px 14px;
   border: 1px solid #C0C0C0;
   border-top-left-radius: 5px;
   border-top-right-radius: 5px;
   background-color: #EEEEEE;
   color: #666666;
   margin-right: 3px;
   text-decoration: none;
   border-bottom: none;
   position: relative;
   top: 0;
   -webkit-transition: 200ms all linear;
   -moz-transition: 200ms all linear;
   -ms-transition: 200ms all linear;
   transition: 200ms all linear;
}
#TabMenu1 li a:hover
{
   background: #C0C0C0;
   color: #666666;
   font-weight: normal;
   text-decoration: none;
   top: -4px;
}
#jQueryButton1
{
   font-family: Arial;
   font-size: 13px;
   font-weight: normal;
   font-style: normal;
}
#wb_jQueryButton1 .ui-button-text
{
   padding: 0;
   line-height: 31px;
}
#jQueryButton1
{
   color: #2779AA;
}
#jQueryButton1 :hover
{
   color: #0070A3;
}
#jQueryButton1 :active
{
   color: #FFFFFF;
}
#wb_jQueryButton1 .ui-button-text-icon .ui-button-icon-primary,
#wb_jQueryButton1 .ui-button-text-icons .ui-button-icon-primary,
#wb_jQueryButton1 .ui-button-icons-only .ui-button-icon-primary
{
   left: auto;
   right: 10px;
}
#wb_jQueryButton1 .ui-button-text-icons .ui-button-icon-secondary,
#wb_jQueryButton1 .ui-button-icons-only .ui-button-icon-secondary
{
   right: auto;
   left: 10px;
}
#wb_Text1 div
{
   text-align: left;
}
</style>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="jquery.ui.core.min.js"></script>
<script type="text/javascript" src="jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="jquery.ui.button.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
   $("#jQueryButton1").button();
});
</script>





<style type="text/css">
body
{
   margin: 0;
   padding: 0;
   background-color: #FFFFFF;
   color: #000000;
}
</style>
<style type="text/css">
a
{
   color: #0000FF;
   text-decoration: underline;
}
a:visited
{
   color: #800080;
}
a:active
{
   color: #FF0000;
}
a:hover
{
   color: #0000FF;
   text-decoration: underline;
}
</style>


<!-- ################# -->



    <script src="http://yandex.st/jquery/1.7.2/jquery.min.js"></script>
	
    <style>


        #search_box{
		  position:absolute;
		  width: 200px;
		  padding: 2px;
		  margin: 1px;
		  border: 1px solid #000;
		  left: 120px;
        }
		#statusBargain {position:absolute; left:120px;width:200px;}
		#bargainID {position:absolute; left:120px;width:200px;}
		#plantation	{position:absolute; left:120px;width:200px;}
		#sort	{position:absolute; left:120px;width:200px;}
		#length	{position:absolute; left:120px;width:200px;}
		#count	{position:absolute; left:120px;width:200px;}
		#city	{position:absolute; left:120px;width:200px;}
		#budget	{position:absolute; left:120px;width:200px;}
		#note   {width:320px;}		
		#submit {position:absolute; left:120px;width:200px;}


 
        #search_advice_wrapper{
            display:none;
            width: 200px;
            background-color: rgb(80, 80, 114);
            color: rgb(255, 227, 189);
            -moz-opacity: 0.95;
            opacity: 0.95;
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=95);
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=95);
            filter:alpha(opacity=95);
            z-index:999;
            position: absolute;
            top: 58px; left: 120px;
        }
 
        #search_advice_wrapper .advice_variant{
            cursor: pointer;
            padding: 5px;
            text-align: left;
        }
        #search_advice_wrapper .advice_variant:hover{
            color:#FEFFBD;
            background-color:#818187;
        }
        #search_advice_wrapper .active{
            cursor: pointer;
            padding: 5px;
            color:#FEFFBD;
            background-color:#818187;		
			
        }
		
		
?>
		
 
    </style>
    <style type="text/css">
    </style>


</head>
<body>




<div id="wb_TabMenu1" style="position:absolute;left:0px;top:0px;width:281px;height:60px;z-index:0;overflow:hidden;">
<ul id="TabMenu1">
<li><a href="./bargain.php" class="active">Сделки</a></li>
<li><a href="./client.php">Клиенты</a></li>
<li><a href="./analytic.php">Аналитика</a></li>
</ul>
</div>
<div id="wb_Text1" style="position:absolute;left:12px;top:43px;width:91px;height:24px;z-index:2;text-align:left;" class="Heading 1 <h1>">
<span style="color:#696969;font-family:Arial;font-size:21px;">Сделки</span></div>
 <div id="wb_jQueryButton1" style="position:absolute;left:13px;top:50px;width:152px;height:31px;z-index:1;">
<!--<a href="./new_bargain.php" id="jQueryButton1" style="width:100%;height:100%;">Добавить сделку</a></div> -->




<!-- ################################ -->


<?php
	$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	mysql_select_db("user43199_roses", $db);
	
	mysql_set_charset('utf8');

	if (isset($_GET['bargainID'])) {$bargainID = $_GET['bargainID']; }// if ($lastName == '') {unset($lastName);}}

    $result = mysql_query("Select * FROM bargain WHERE `bargain`.`bargainID` =".$bargainID);
	$myrow = mysql_fetch_array($result);

	$managerName = $myrow['managerName'];
	$clientID = $myrow['clientID'];
	$statusBargain = $myrow['statusBargain'];
	$budget = $myrow['budget'];
	$note = $myrow['note'];
	
	// Выборка города доставки выбранного заказа
	$result = mysql_query("
	SELECT lastName, firstName, secondName FROM clients WHERE clientID = (SELECT clientID FROM bargain WHERE bargainID =".$bargainID.")");
	$myrow = mysql_fetch_array($result);
	$lastName = $myrow['lastName'];
	$firstName = $myrow['firstName'];
	$secondName = $myrow['secondName'];
	
#получаю значения плантаций и сортов тупой вставкой запроса без хранимки
	#$result = mysql_query("SELECT sort, plantation, length FROM sort WHERE sortID = (SELECT sortID FROM zakaz WHERE zakazID = (SELECT zakazID FROM bargain WHERE bargainID=".$bargainID."))");
$result = mysql_query("CALL zakaz_inf2(".$bargainID.")");
	$myrow = mysql_fetch_array($result);
	$plantation = $myrow['plantation'];
	$sort =$myrow['sort'];
	$length = $myrow['length'];
	
	mysql_close($db);

/*
//тот же результат что и просто вызов хранимки без буферной sql переменной. Значение получаем, но при выводе в поле кроме нее никакие данные из базы больше не извлекаются
	$q=mysql_query("set @buf='$bargainID'");
	$result = mysql_query("CALL zakaz_inf(@buf)");
	$myrow = mysql_fetch_array($result);
	$plantation = $myrow['plantation'];
	$sort =$myrow['sort'];
	$length = $myrow['length'];
*/
	// Используя PDO
/*
	try { 
	
	 # MySQL через PDO_MYSQL 
	  
	$host="localhost"; //имя сервера 
	$dbname = "user43199_roses";
	$user="user43199_roses"; //имя пользователя 
	$pass="jGTlDnaC"; //пароль 
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); 
   
  # SQLite  
 // $DBH = new PDO("sqlite:user43199_roses");  
	}  
	catch(PDOException $e) {  
    	echo $e->getMessage();  
	}
*/

/*	
// неудавшаяся попытка использования prepare statement
	# STH означает "Statement Handle"  
	try {
	$STH = $DBH->prepare("SELECT sort, plantation, length FROM sort WHERE sortID = (SELECT sortID FROM zakaz WHERE zakazID = (SELECT zakazID FROM bargain WHERE bargainID=".$bargainID."))");  
	$STH->execute();
	$myrow = mysql_fetch_array($STH);
	$plantation = $myrow['plantation'];
	}
	catch (PDOException $e) {
			echo $e->getMessage();
	}
*/	

#########################################
# PDO :

//почти работающий вариант извлечения плантации использя pdo. Ошибок не выдает но извлекает пустое значение. Т.к. не получается подключиться к базе через PDO, судя по всему на сервере нет драйвера SQLITE PDO
/*
$DBH->exec("UPDATE  `user43199_roses`.`clients` SET  
`lastName` =  'ПроверкаPDO+',
WHERE  `clients`.`clientID` =1");
*/
#	$pdo = $DBH->exec("set @bargID='$bargainID'");//создаю переменную sql и присваиваю ей значение
#	$pdo = $DBH->exec("call zakaz_inf(@bargID)");//вызываю процедуру с переменной-аргументом
	
	#$pdo->setFetchMode(PDO::FETCH_ASSOC);
	
	#$myrow = $pdo->fetch();
	#$plantation = $myrow['plantation'];

/*
// выдает ошибку, ничего не выводится на страницу

	# поскольку это обычный запрос без placeholder’ов,
	# можно сразу использовать метод query()  
	$STH = $DBH->query("call zakaz_inf('bargainID')");  
  
	# устанавливаем режим выборки
	$STH->setFetchMode(PDO::FETCH_ASSOC);  
  
	$myrow = $STH->fetch();
	$plantation = $myrow['plantation'];
*/     
	
	
	
#######################################################

	$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	mysql_select_db("user43199_roses", $db);
	
	mysql_set_charset('utf8');
	
// Выборка города доставки выбранного заказа
	$result = mysql_query("SELECT city FROM city WHERE cityID = (SELECT cityID FROM bargain WHERE bargainID =".$bargainID.")");
	$myrow = mysql_fetch_array($result);
	$city = $myrow['city'];
	
	$result = mysql_query("SELECT count FROM zakaz WHERE zakazID = (SELECT zakazID FROM bargain WHERE bargainID =".$bargainID.")");
	$myrow = mysql_fetch_array($result);
	$count = $myrow['count'];
?>	


<script src="jquery.js"></script>

<form action="edit_bargain.php" method="post" name="bargainForm" target="_self" >
  <p> ID сделки:
  	<!-- <input name="clientID" type="text" id="clientID" readonly="readonly" > -->
    <?php  echo '<input name="bargainID" type="text" id="bargainID" value="'.$bargainID.'" readonly="readonly" />' ?>  
  </p>
  <p>
  <br>
  Клиент:  		      
    <label for="clientID"></label>
    <input type="text" name="query" id="search_box" value="<?php echo ($lastName.' '.$firstName.' '.$secondName); ?>" autocomplete="off" readonly> 
	<?php // echo '<input type="text" name="query" id="search_box" value="" autocomplete="off"> -->' ?>
    <!-- скрипты и какой-то невидимый слой -->
	<script>
	function replace() {
	 if(this.value.length==1) {
	  if(/^[^А-ЯЁ]$/.test(this.value)) this.value = String.fromCharCode(this.value.charCodeAt(this.value)-32);
	 } else if(/[^а-яё ]/.test(this.value[this.value.length-1])) {this.value = this.value.slice(0,-1)};
	} ;
	document.getElementById("clientID").onkeyup = replace ;
	</script>
   
    <label for="clientID"></label>
    <input type="text" name="clientID" id="clientID" style="position:absolute; left:400px; visibility:hidden;">
  <div id="search_advice_wrapper">


<br />
    <br />
    Выберите менеджера:
    <label for="managerName"></label>
    <select name="managerName" id="managerName">
      <?php
    
   
	  $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	  mysql_select_db("user43199_roses", $db);
	  
	  mysql_set_charset('utf8');
	  
	  $result = mysql_query("SELECT lastName, firstName FROM manager ");
	  $i=0;
	  while($row = mysql_fetch_array($result))
	  {
		  if($i=0) printf("<option selected=\"selected\">%s %s</option>", $row['lastName'], $row['firstName']);;
		  printf("<option>%s %s</option>", $row['lastName'], $row['firstName']);
		  $i++;
	  
	  }
    
 	?>    
    </select>
    <br />
    <br />
        <p>
  <em><strong>  Введите данные заказа: </strong></em><strong></strong> </p>
  </div>
 
    <p>Плантация: 
      <label for="plantation"></label>
    <select name="plantation" id="plantation">
    
	 <?php
    
		echo '<option selected=\"selected\">'.$plantation.'</option>';
	  $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	  mysql_select_db("user43199_roses", $db);
	  
	  mysql_set_charset('utf8');
	  
	  $result = mysql_query("SELECT plantation FROM sort ");
	  $row = mysql_fetch_array($result);
	  while($row = mysql_fetch_array($result))
	  {
		  if($row['plantation'] == $plantation) {} 
		  else
		  {printf("<option>%s</option>", $row['plantation']);} 
	  	
	  }
    
 	?>
    </select>
  </p>
  <p>Сорт:
    <label for="sort"></label>
    <select name="sort" id="sort">
	 <?php
    
		echo '<option selected=\"selected\">'.$sort.'</option>';
	  
	  $result = mysql_query("SELECT sort FROM sort ");
	  $row = mysql_fetch_array($result);
	  while($row = mysql_fetch_array($result))
	  {
		  if($row['sort'] == $sort) {} 
		  else
		  {printf("<option>%s</option>", $row['sort']);} 
	  	
	  }
    
 	?>   
    </select>
  </p>
  <p>Длина: 
    <label for="length"></label>
    <select name="length" id="length">
    <?php
    
		//echo '<option selected=\"selected\">'.$sort.'</option>';
	  
	  $result = mysql_query("SELECT length FROM sort ");
	  $row = mysql_fetch_array($result);
	  $i = 20;
	  while($i < 110)
	  {
		  if($i == $length) {echo '<option selected=\"selected\">'.$i.'</option>';} 
		  else
		  {printf("<option>%s</option>", $i);} 
		  $i = $i + 10;
	  	
	  }
    
 	?>
    </select>
  </p>
  <p>Количество:
    <label for="count"></label>
    <input type="text" name="count" id="count" 
    <?php echo 'value="'.$count.'">' ?>
  </p>



  <p>Город доставки:
    <label for="city"></label>
    <select name="city" id="city">
	 <?php
    
		echo '<option selected=\"selected\">'.$city.'</option>';
	  
	  $result = mysql_query("SELECT city FROM city ");
	  $row = mysql_fetch_array($result);
	  while($row = mysql_fetch_array($result))
	  {
		  if($row['city'] == $city) {} 
		  else
		  {printf("<option>%s</option>", $row['city']);} 
	  	
	  }
    
 	?> 
    </select>
  </p>
  <p>Статус сделки: 
    <label for="statusBargain"></label>
    <select name="statusBargain" id="statusBargain">
    <?php
		$stBarg[0] = "Первичный контакт";
		$stBarg[1] = "Переговоры";
		$stBarg[2] = "Принимают решение";
		$stBarg[3] = "Согласование договора";
		$stBarg[4] = "Заказ товара";
		$stBarg[5] = "Товар отгружен";
		$stBarg[6] = "Успешное завершение";
		$stBarg[7] = "Закрыто и не реализовано";
		$i = 0;
		while ($i < sizeof($stBarg))
		{
			if($stBarg[$i] == $statusBargain) {echo '<option selected=\"selected\">'.$stBarg[$i].'</option>';} 
		  else
		  {printf("<option>%s</option>", $stBarg[$i]);} 
		  $i++;
		}
	?>
    </select>
  </p>
  <p>Бюджет: 
    <label for="budget"></label>
     <?php  echo '<input type="text" name="budget" id="budget" value="'.$budget.'" />' ?>
  </p>
  <p>Введите дополнительный комментарий:</p>
  <p>
  <label for="note"></label>
    <textarea name="note" id="note" cols="45" rows="5"><?php echo $note ?></textarea>
  </p>
  <p>
    <label for="menu"></label>
    <input type="submit" name="submit" id="submit" value="Сохранить" />
    <br />
  </p>

</form>

<div id="YMapsID" style="width: 800px; height: 550px; left: 400px; top: 20px; position: absolute"></div>




<?php
/*
#$bargainID = 70;
$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

$result = mysql_query("SELECT city from city where cityID = (Select cityID from bargain where bargainID = $bargainID)");
$cityName = mysql_fetch_array($result);

$result = mysql_query("SELECT address from clients where clientID = (Select clientID from bargain where bargainID = $bargainID)");
$cityName = mysql_fetch_array($result);
*/

# вытаскиваем из базы gps-координаты фуры и отмечаем ее на карте

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

$query = mysql_query('CALL get_gps(' . $bargainID . ')');
$bargainGPS = mysql_fetch_array($query);

echo '<input type="hidden" id="bargainGPSlong" value="' . $bargainGPS[0] . '">';
echo '<input type="hidden" id="bargainGPSlat" value="' . $bargainGPS[1] . '">';

mysql_close($db);

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

$result = mysql_query("SELECT city from city where cityID = (Select cityID from bargain where bargainID = $bargainID)");
$cityName = mysql_fetch_array($result);

$result = mysql_query("SELECT address from clients where clientID = (Select clientID from bargain where bargainID = $bargainID)");
$addressbarg  = mysql_fetch_array($result);

echo '<input type="hidden" id="cityName" value="' . $cityName["city"] . '">';
echo '<input type="hidden" id="addressbarg" value="' . $addressbarg["address"] . '">';

mysql_close($db);

?>

</body>
</html>