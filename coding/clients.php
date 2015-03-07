<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Вывод клиентов</title>
</head>

<link rel="stylesheet" type="text/css" href="stylesheets/style.css">

<body>

<h1 align="center"><strong>Клиенты</strong></h1>
<div id="sqlqueryresults" class="ajax"><table id="table_results" class="data ajax" align="center">
<thead><tr>
</th><th>Статус
</th><th>Фамилия
</th><th>Имя
</th><th>Отчество
</th><th>Компания
</th><th>Должность
</th><th>Телефон
</th><th>Город

</thead>
        
<tbody>
        
<?php 
	$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	mysql_select_db("user43199_roses", $db);
	
	mysql_set_charset('utf8');

    $result = mysql_query("Select * FROM clients");
	while ($myrow = mysql_fetch_array($result))
	{ 
	echo '<tr class="odd"><td align="right" class="data inline_edit not_null odd  nowrap ">'.$myrow['statusClient'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['lastName'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['firstName'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['secondName'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['company'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['carier'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['telephone'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow['city'].'</td>';
	echo '</tr>';
	}

?>

</tbody>
</table>


</body>
</html>