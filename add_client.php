<?php
include("blocks/lock.php");
?>


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
if (isset($_POST['company'])) {$company = $_POST['company']; }
if (isset($_POST['carier'])) {$carier = $_POST['carier']; }
if (isset($_POST['telephone'])) {$telephone = $_POST['telephone']; }// if ($company == '') {unset($company);}}
if (isset($_POST['email'])) {$email = $_POST['email']; }// if ($carier == '') {unset($carier);}}
if (isset($_POST['city'])) {$city = $_POST['city']; }
if (isset($_POST['web'])) {$web = $_POST['web']; }
if (isset($_POST['skype'])) {$skype = $_POST['skype']; }
if (isset($_POST['address'])) {$address = $_POST['address']; }
if (isset($_POST['verificity'])) {$verificity = $_POST['verificity']; }
if ($verificity == "on") 
{$verificity = "Подтвержден";} else {$verificity = "Не подтвержден";}

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);

//if (isset($_POST['statusClient']) && isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['secondName'])
// && isset($_POST['sex']) && isset($_POST['company']) && isset($_POST['carier']))
//{
$result = mysql_query("INSERT INTO clients (statusClient, lastName, firstName, secondName, sex, company, carier, telephone, email, city, web, skype, address, verificity) 
VALUES (N'$statusClient', N'$lastName', N'$firstName', N'$secondName', N'$sex', N'$company', N'$carier', N'$telephone', N'$email', N'$city', N'$web', N'$skype', N'$address', N'$verificity')");

if ($result) 
{
	
	echo "Вы успешно добавили данные в базу данных";    
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://www.rosescrm.brottys.ru/client.php");
    exit();
	
}

else
{
	echo "Вы ввели не полную информацию";
	
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
}


?>


</body>
</html>