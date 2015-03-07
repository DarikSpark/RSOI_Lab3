<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Обработчик добавления клиента в базу</title>
</head>

<body>

<?php
// Сделать проверку заполнения с помощью JavaScript на предыдущем шаге

if (isset($_POST['statusClient'])) {$statusClient = $_POST['statusClient']; }// if ($statusClient == '') {unset($statusClient);} }
if (isset($_POST['lastName'])) {$lastName = $_POST['lastName']; }// if ($lastName == '') {unset($lastName);}}
if (isset($_POST['firstName'])) {$firstName = $_POST['firstName']; }// if ($firstName == '') {unset($firstName);}}
if (isset($_POST['secondName'])) {$secondName = $_POST['secondName']; }// if ($secondName == '') {unset($secondName);}}
if (isset($_POST['sex'])) {$sex = $_POST['sex']; }// if ($sex == '') {unset($sex);}}
if (isset($_POST['company'])) {$company = $_POST['company']; }// if ($company == '') {unset($company);}}
if (isset($_POST['carier'])) {$carier = $_POST['carier']; }// if ($carier == '') {unset($carier);}}

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);

//if (isset($_POST['statusClient']) && isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['secondName'])
// && isset($_POST['sex']) && isset($_POST['company']) && isset($_POST['carier']))
//{
$result = mysql_query("INSERT INTO clients (statusClient, lastName, firstName, secondName, sex, company, carier) 
VALUES (N'$statusClient', N'$lastName', N'$firstName', N'$secondName', N'$sex', N'$company', N'$carier')");

if ($result) {echo "Вы успешно добавили данные в базу данных";}
/*}
else
{
	echo "Вы ввели не полную информацию";
	
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
//}


?>


</body>
</html>