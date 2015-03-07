<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Соединение с базой</title>
</head>

<body>

<?php

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);

$result = mysql_query("INSERT INTO bargain (clientID, managerID, zakazID) VALUES 


?>


</body>
</html>