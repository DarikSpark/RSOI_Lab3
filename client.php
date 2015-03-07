<?php
ULogin(1);
HeadCss('Клиенты', '<link href="resource/bootstrap/dist/css/bootstrap.css" rel="stylesheet">') ?>

<body>
<div class="wrapper">
    <?php HeaderLink(); ?>
    <div class="content">
        <?php Menu();
        MessageShow()
        ?>



<div id="sqlqueryresults" class="ajax"><table id="table_results"  style="cursor: default;"
                                              class="data ajax table table-hover" align="center">
<thead><tr>
<th>Статус</th>
<th>ФИО</th>
<th>Компания</th>
<th>Должность</th>
<th>Телефон</th>
</thead>
        
<tbody>
        
<?php
//    $managerID = $_SESSION['USER_ID'];
//	$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
//	mysql_select_db("user43199_roses", $db);
//
//	mysql_set_charset('utf8');
//
//    $result = mysql_query("Select * FROM clients");
//	while ($myrow = mysql_fetch_array($result))
//	{

require_once 'requests/library/Requests.php';
Requests::register_autoloader();

$managerID = $_SESSION['USER_ID'];
$arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `token` FROM `oauth_apps_codes` WHERE `user_id`='$managerID'"));
$token = $arr['token'];
//echo $token;
$headers = array('Authorization'=>'Bearer '.$token);
Logit('['.date( "d.m.y H:i" ).'] Фронтенд посылает GET-запрос бэкенду клиентов: http://www.rosescrm.brottys.ru/api_client/client?per_page=all');
$response = Requests::get('http://www.rosescrm.brottys.ru/api_client/client?per_page=all', $headers);
$myrow = json_decode($response->body, true);
Logit('['.date( "d.m.y H:i" ).'] Бэкенд клиентов отправил JSON ответ со списком клиентов');
//echo var_dump($table);
$i = 0;
//$table = $myrow;

while ($i <= floatval($myrow['count_entry']))
{
	echo '<tr class="odd"><td class="data inline_edit not_null odd  nowrap ">'.$myrow[$i]['statusClient'].'</td>';
	echo '<td  class="data inline_edit  odd  " onClick=""> 
	<a title="редактировать запись" href="'.$myrow[$i]['link'].'">'.$myrow[$i]['fio'].'</a></td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow[$i]['company'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow[$i]['carier'].'</td>';
	echo '<td  class="data inline_edit  odd  ">'.$myrow[$i]['telephone'].'</td>';
	echo '</tr>';
    $i++;
}

?>

</tbody>
</table>

    <?php Footer() ?>
</div>
</body>
</html>