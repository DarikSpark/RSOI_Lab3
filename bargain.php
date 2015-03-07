<?php
ULogin(1);
HeadCss('Сделки', '<link href="resource/bootstrap/dist/css/bootstrap.css" rel="stylesheet">') ?>

<body>
<div class="wrapper">
    <?php HeaderLink(); ?>
    <div class="content">
        <?php Menu();
        MessageShow()
        ?>


<div id="sqlqueryresults" class="ajax"><table id="table_results" class="data ajax table table-hover" align="center" style="cursor: default;">
<thead><tr>
<th>Компания</th>
<th>Контактное лицо</th>
<th>Телефон</th>
<th>Статус сделки</th>
<th>Бюджет (руб)</th>
</tr>

</thead>

<tbody>
        
<?php
//    $managerID = $_SESSION['USER_ID'];
//
//	$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
//	mysql_select_db("user43199_roses", $db);
//
//	mysql_set_charset('utf8');
//
//    $selbargain = mysql_query("SELECT * FROM bargain WHERE managerID=$managerID");
//
//	while ($myrowbargain = mysql_fetch_array($selbargain))
//	{
//	$selclient = mysql_query("SELECT * FROM clients WHERE clientID='".$myrowbargain['clientID']."'");
//	$myrowclient = mysql_fetch_array($selclient);

require_once 'requests/library/Requests.php';
Requests::register_autoloader();

$managerID = $_SESSION['USER_ID'];
$arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `token` FROM `oauth_apps_codes` WHERE `user_id`='$managerID'"));
$token = $arr['token'];
//echo $token;
$headers = array('Authorization'=>'Bearer '.$token);
Logit('['.date( "d.m.y H:i" ).'] Фронтенд посылает GET-запрос бэкенду сделок: http://www.rosescrm.brottys.ru/api_bargain/bargain?per_page=all');
$response = Requests::get('http://www.rosescrm.brottys.ru/api_bargain/bargain?per_page=all', $headers);
$bargain = json_decode($response->body, true);
Logit('['.date( "d.m.y H:i" ).'] Бэкенд сделок успешно отправил JSON ответ со списком сделок');
Logit('['.date( "d.m.y H:i" ).'] Фронтенд посылает GET-запрос фронтенду клиентов: http://www.rosescrm.brottys.ru/api_client/client_by_id?per_page=all');
$response2 = Requests::get('http://www.rosescrm.brottys.ru/api_client/client_by_id?per_page=all', $headers);
$client = json_decode($response2->body, true);
Logit('['.date( "d.m.y H:i" ).'] Бэкенд клиентов успешно отправил JSON ответ со списком клиентов');
//echo var_dump($table);
$i = 0;

while ($i <= floatval($bargain['count_entry']))
{
    $id = $bargain[$i]['clientID'];
    echo '<tr class="odd"><td  class="data inline_edit not_null odd  nowrap " style="display: block;">
        '.$client[$id]['company'].'</td>';
    echo '<td  class="data inline_edit  odd  "><a title="редактировать запись" href="http://www.rosescrm.brottys.ru/edit_bargain_form.php?bargainID='.
        $bargain[$i]['link'].'">
    '.$client[$id]['fio'].'</td>';
    echo '<td  class="data inline_edit  odd  ">'.$client[$id]['telephone'].'</td>';
    echo '<td  class="data inline_edit  odd  ">'.$bargain[$i]['statusBargain'].'</td>';
    echo '<td  class="data inline_edit  odd  ">'.$bargain[$i]['budget'].'</td>';
    echo '</tr>';
    $i++;
}
//	}

?>

</tbody>
</table>

    <?php Footer() ?>
</div>
</body>
</html>