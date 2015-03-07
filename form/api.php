<?php

if ($Module == 'me') {
    header('Content-type: application/json');
    $token = getallheaders();
    $token = $token['Authorization'];
    $token = substr($token, 7);

    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `user_id`, `expired` FROM `oauth_apps_codes`
    WHERE `token`='$token'"));
    $user_id = $arr['user_id'];
    if (floatval($arr['expired']) >= floatval(strtotime('now'))) {
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `firstName`, `secondName`,`lastName`,`email`
    FROM `manager` WHERE `managerID` = '$user_id'"));
    $response = array(
        "Фамилия"=>$Row['lastName'],
        "Имя"=>$Row['firstName'],
        "Отчество"=>$Row['secondName'],
        "E-mail"=>$Row['email']
    );
    $jsonString = json_encode($response);
    echo $jsonString;
//    echo 'Expired: '.floatval($arr['expired']).'     Текущее время: '.floatval(strtotime('now'));

    }
    else {
        $response = array(
            "Error"=>"Истекло время действия сессии"
        );
        $jsonString = json_encode($response);
        echo $jsonString;
        header("HTTP/1.0 401 Unauthorized");
//        echo 'Expired: '.floatval($arr['expired']).'     Текущее время: '.floatval(strtotime('now'));
    }
}

if ($Module == 'bargain') {
    header('Content-type: application/json');
    $token = getallheaders();
    $token = $token['Authorization'];
    $token = substr($token, 7);

    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `user_id`, `expired` FROM `oauth_apps_codes`
    WHERE `token`='$token'"));
    $user_id = $arr['user_id'];
    if (floatval($arr['expired']) >= floatval(strtotime('now'))) {
    $Row = mysqli_query($CONNECT, "SELECT * FROM bargain WHERE managerID='$user_id'");
    $response = array(
        "Текущая страница"=>$_GET['page'],
        "Всего записей"=>0,
        "Записей на страницу"=>5,
        "Всего страниц" => 0

    );
    $i = 0;

    while ($myrowbargain = mysqli_fetch_array($Row))
    {
        $selclient = mysqli_query($CONNECT, "SELECT * FROM clients WHERE clientID='$myrowbargain[clientID]'");
        $myrowclient = mysqli_fetch_array($selclient);


    $response[$i] = array(
        "Название компании"=>$myrowclient['company'],
        "ФИО"=>$myrowclient['lastName'].' '.$myrowclient['firstName'].' '.$myrowclient['secondName'],
        "Телефон"=>$myrowclient['telephone'],
        "Статус сделки"=>$myrowbargain['statusBargain'],
        "Бюджет"=>$myrowbargain['budget']
    );
    $i++;
    }

    $per_page = 5;
    if ($_GET['per_page']) {$per_page = $_GET['per_page'];}

    $page_count = round($i/$per_page, 0, PHP_ROUND_HALF_UP);
    if ($i%$per_page != 0) {$page_count++;}

    if ($_GET['page']){
        $response_paging = array_slice($response, ($_GET['page']-1)*5, $per_page);
    }
    else {$response_paging = $response;}

    $response_paging['Текущая страница']=$_GET['page'];
    $response_paging['Всего записей']=$i;
    $response_paging['Записей на страницу']=floatval($per_page);
    $response_paging['Всего страниц']= $page_count;

    $jsonString = json_encode($response_paging);
    echo $jsonString;
}
else {
        $response = array(
            "Error"=>"Истекло время действия сессии"
        );
        $jsonString = json_encode($response);
        echo $jsonString;
        header("HTTP/1.0 401 Unauthorized");
//        echo 'Expired: '.floatval($arr['expired']).'     Текущее время: '.floatval(strtotime('now'));
    }
}

if ($Module == 'managers') {
    header('Content-type: application/json');

    $Row = mysqli_query($CONNECT, "SELECT * FROM manager");
    $i = 0;

    while ($myrowmanager = mysqli_fetch_array($Row))
    {
        $response[$i] = array(
            "Фамилия"=>$myrowmanager['lastName'],
            "Имя"=>$myrowmanager['firstName'],
            "Отчество"=>$myrowmanager['secondName'],
            "Телефон"=>$myrowmanager['telephone'],
            "E-mail"=>$myrowmanager['email']
        );
        $i++;
    }

    $jsonString = json_encode($response);
    echo $jsonString;
}

?>

