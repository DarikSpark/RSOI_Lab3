<?php

$URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$code = $_GET['code'];
if ($_SESSION['USER_LOGIN_IN'] == 1 and $code and $_GET['response_type'] == 'code') {
    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `client_id` FROM `oauth_apps_codes` WHERE `code`='$code'"));
    $client_id = $arr['client_id'];
    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `client_secret` FROM `oauth_apps` WHERE `client_id`='$client_id'"));
    $client_secret = $arr['client_secret'];
    $state_tok = $_GET['state'];
    $response_type = $_GET['response_type'];
    require_once 'requests/library/Requests.php'; Requests::register_autoloader();
    $data = array('client_id'=>$client_id, 'client_secret'=>$client_secret, 'code'=>$code, 'response_type'=>$response_type);
    $response = Requests::post('http://rosescrm.brottys.ru/account/oauth_token', array(), $data);
    $json_de = json_decode($response->body);
    $token_request = $json_de->token;
//    echo $response->body.'<br>';
//    echo 'Token: '.$token_request;
//    exit();
//    echo $response->body;
    MessageSend(3, 'Токен отправлен: '.$token_request.'', '/profile?code='.$code);
}

if ($_SESSION['USER_LOGIN_IN'] != 1) exit(header("Location: /oauth_login?$URL_Query"));
else exit(header("Location: /permissions?$URL_Query"));
?>
