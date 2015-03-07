<?php
include("blocks/lock.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Обработчик добавления сделки в базу</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">

</head>
<body>



<?php
// Сделать проверку заполнения с помощью JavaScript на предыдущем шаге

if (isset($_POST['managerName'])) {$managerName = $_POST['managerName']; if ($managerName == '') {unset($managerName);} }
if (isset($_POST['clientID'])) {$clientID = $_POST['clientID']; if ($clientID == '') {unset($clientID);} }
if (isset($_POST['plantation'])) {$plantation = $_POST['plantation']; if ($plantation == '') {unset($plantation);} }
if (isset($_POST['sort'])) {$sort = $_POST['sort']; if ($sort == '') {unset($sort);} }
if (isset($_POST['length'])) {$length = $_POST['length']; if ($length == '') {unset($length);} }
if (isset($_POST['count'])) {$count = $_POST['count']; if ($count == '') {unset($count);} }
//if (isset($_POST['managerID'])) {$managerID = $_POST['managerID'];if ($managerID == '') {unset($managerID);}}
//if (isset($_POST['zakazID'])) {$zakazID = $_POST['zakazID'];if ($zakazID == '') {unset($zakazID);}}
if (isset($_POST['city'])) {$city = $_POST['city'];if ($city == '') {unset($city);}}
if (isset($_POST['statusBargain'])) {$statusBargain = $_POST['statusBargain'];if ($statusBargain == '') {unset($statusBargain);}}
if (isset($_POST['budget'])) {$budget = $_POST['budget'];if ($budget == '') {unset($budget);}}
if (isset($_POST['note'])) {$note = $_POST['note'];if ($note == '') {unset($note);}}

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);


// Добавляем сорт
if (isset($sort) && isset($plantation) && isset($length))
{
$result = mysql_query("INSERT INTO sort (sort, plantation, length) 
VALUES ('$sort', '$plantation', $length)");

$sortID = mysql_insert_id($db);
}
else
{
	echo "<br> <br>Вы ввели не полную информацию по сорту";
	exit;
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
}

// Добавляем заказ
if (isset($sortID) && isset($count))
{
$result = mysql_query("INSERT INTO zakaz (sortID, count) 
VALUES ('$sortID', '$count')");

$zakazID = mysql_insert_id($db);
}
else
{
	echo "<br> <br>Вы ввели не полную информацию по заказу ";
	exit;
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
}

// Находим cityID
$result = mysql_query("SELECT cityID FROM city WHERE city='$city'");
$cityrow = mysql_fetch_array($result);
$cityID = $cityrow['cityID'];


// Добавляем сделку
if (isset($clientID) && isset($managerID) && isset($zakazID) && isset($cityID)
 && isset($statusBargain) && isset($budget) && isset($note))
{
$result = mysql_query("INSERT INTO bargain (clientID, managerID, zakazID, cityID, statusBargain, budget, note) 
VALUES ($clientID, $managerID, $zakazID, $cityID, '$statusBargain', $budget, '$note')");
	
	echo "<br> <br> Вы успешно добавили данные в базу данных";    
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://www.rosescrm.brottys.ru/bargain.php");
}
else
{
	echo "<br> <br>Вы ввели не полную информацию по сделке";
	
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
}


?>


</body>
</html>