<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Обработчик добавления сделки в базу</title>
</head>

<body>

<?php
// Сделать проверку заполнения с помощью JavaScript на предыдущем шаге

if (isset($_POST['clientID'])) {$clientID = $_POST['clientID']; if ($clientID == '') {unset($clientID);} }
if (isset($_POST['managerID'])) {$managerID = $_POST['managerID'];if ($managerID == '') {unset($managerID);}}
if (isset($_POST['zakazID'])) {$zakazID = $_POST['zakazID'];if ($zakazID == '') {unset($zakazID);}}
if (isset($_POST['cityID'])) {$cityID = $_POST['cityID'];if ($cityID == '') {unset($cityID);}}
if (isset($_POST['statusBargain'])) {$statusBargain = $_POST['statusBargain'];if ($statusBargain == '') {unset($statusBargain);}}
if (isset($_POST['budget'])) {$budget = $_POST['budget'];if ($budget == '') {unset($budget);}}
if (isset($_POST['note'])) {$note = $_POST['note'];if ($note == '') {unset($note);}}

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);

if (isset($_POST['clientID']) && isset($_POST['managerID']) && isset($_POST['zakazID']) && isset($_POST['cityID'])
 && isset($_POST['statusBargain']) && isset($_POST['budget']) && isset($_POST['note']))
{
$result = mysql_query("INSERT INTO bargain (clientID, managerID, zakazID, cityID, statusBargain, budget, note) 
VALUES ($clientID, $managerID, $zakazID, $cityID, '$statusBargain', $budget, '$note')");

if ($result) {echo "Вы успешно добавили данные в базу данных";}
}
else
{
	echo "Вы ввели не полную информацию";
	
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
}


?>


</body>
</html>