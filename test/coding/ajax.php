<?php

if(!empty($_GET['query'])) {
    $query = $_GET['query'];
	
	$dbhost = "localhost";
	$dbuser = "user43199_roses";
	$dbpass = "jGTlDnaC";
	$dbname = "user43199_roses";

	$array = array();

	// Соединиться с сервером БД
	mysql_connect($dbhost, $dbuser, $dbpass) or die (mysql_error ());

	// Выбрать БД
	mysql_select_db($dbname) or die(mysql_error());

	mysql_set_charset('utf8');
	
	// SQL-запрос
	$strSQL = "SELECT firstName, lastName FROM clients WHERE firstName LIKE N'%" . $query . "%' OR lastName LIKE N'%" . $query . "%'";

	// Выполнить запрос (набор данных $rs содержит результат)
	$rs = mysql_query($strSQL);

	// Цикл по recordset $rs
	// Каждый ряд становится массивом ($row) с помощью функции mysql_fetch_array
	$i=0;
	while(($row = mysql_fetch_array($rs)) and ($i<10)) {
		$array[] = $row['firstName']." ".$row['lastName'];
		$i=$i+1;
	}
	
	echo "['".implode("','", $array)."']";
	
	// Закрыть соединение с БД
	mysql_close();
}
exit();

?>