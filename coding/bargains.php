<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Вывод клиентов</title>
</head>

<link rel="stylesheet" type="text/css" href="stylesheets/style.css">

<body>

<h1 align="center"><strong>Клиенты</strong></h1>
<div id="sqlqueryresults" class="ajax"><table id="table_results" class="data ajax" align="center">
<thead><tr>
</th><th>Компания
</th><th>Контактное лицо
</th><th>Телефон
</th><th>Статус сделки
</th><th>Бюджет (руб)


</thead>
        
<tbody>
        
<?php 
	$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	mysql_select_db("user43199_roses", $db);
	
	mysql_set_charset('utf8');

    $selbargain = mysql_query("SELECT * FROM bargain");

	while ($myrowbargain = mysql_fetch_array($selbargain))
	{ 
	$selclient = mysql_query("SELECT * FROM clients WHERE clientID='".$myrowbargain['clientID']."'");
	$myrowclient = mysql_fetch_array($selclient);
	echo '<tr class="odd"><td align="right" class="data inline_edit not_null odd  nowrap ">'.$myrowclient['clientID'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrowclient['lastName'].$myrowclient['firstName'].$myrowclient['secondName'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrowclient['telephone'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrowbargain['statusBargain'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrowbargain['budget'].'</td>';
	echo '</tr>';
	}

?>

</tbody>
</table>


</body>
</html>