<?php
include("blocks/lock.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Обработчик редактирования сделки в базе</title>
</head>

<body>

<?php

# Полученние всех необходимых данных с формы и из базы данных
if (isset($_POST['bargainID'])) {$bargainID = $_POST['bargainID']; if ($bargainID == '') {unset($bargainID);} }
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
# Получение ID сорта 
$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');
$result = mysql_query("SELECT sortID FROM zakaz WHERE zakazID = (SELECT zakazID FROM bargain WHERE bargainID=".$bargainID.")");
$myrow = mysql_fetch_array($result);
$sortID = $myrow['sortID'];



//if (isset($_POST['statusClient']) && isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['secondName'])
// && isset($_POST['sex']) && isset($_POST['company']) && isset($_POST['carier']))
//{
// $result = mysql_query("INSERT INTO clients (statusClient, lastName, firstName, secondName, sex, company, carier, telephone, email, city, web, skype, address, verificity) 
//VALUES (N'$statusClient', N'$lastName', N'$firstName', N'$secondName', N'$sex', N'$company', N'$carier', N'$telephone', N'$email', N'$city', N'$web', N'$skype', N'$address', N'$verificity')");


//обновляю данные плантации, сорта и необходимой длины розы

$result = mysql_query("UPDATE  `user43199_roses`.`sort` SET  
`sort` =  '$sort',
`plantation` =  '$plantation',
`length` =  '$length'
WHERE  `sort`.`sortID` =".$sortID);

$result = mysql_query("UPDATE  `user43199_roses`.`bargain` SET  
`statusBargain` =  '$statusBargain',
`budget` =  '$budget',
`note` =  '$note'
WHERE  `bargain`.`bargainID` =".$bargainID);

$result = mysql_query("select cityID from city where city ='$city'");
$myrow = mysql_fetch_array($result);
$cityID = $myrow['cityID'];

$result = mysql_query("UPDATE  `user43199_roses`.`bargain` SET  
`cityID` =  '$cityID'
WHERE  `bargain`.`bargainID` =".$bargainID);

$result = mysql_query("select zakazID from bargain where bargainID =".$bargainID);
$myrow = mysql_fetch_array($result);
$zakazID = $myrow['zakazID'];

$result = mysql_query("UPDATE  `user43199_roses`.`zakaz` SET  
`count` =  '$count'
WHERE  `zakaz`.`zakazID` =".$zakazID);

if ($result) 
{
	
	echo "<br> <br> Вы успешно добавили данные в базу данных";    
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://www.rosescrm.brottys.ru/bargain.php");
    exit();
	
}

else
{
	echo "<br> <br>Вы ввели не полную информацию по сделке";
	
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
}


?>


</body>
</html>