<?php
include_once 'setting.php';
session_start();
$CONNECT = mysqli_connect(HOST, USER, PASS, DB);

if ($_SESSION['USER_LOGIN_IN'] != 1 and $_COOKIE['user']) {
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `managerID`
    FROM `userlist` WHERE `pass` = '$_COOKIE[user]'"));
    $_SESSION['USER_ID'] = $Row['managerID'];
    $_SESSION['USER_LOGIN_IN'] = 1;
}


if ($_SERVER['REQUEST_URI'] == '/') {
    $Page = 'index';
    $Module = 'index';
} else {
    $URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $URL_Parts = explode('/', trim($URL_Path, ' /'));
    $Page = array_shift($URL_Parts);
    $Module = array_shift($URL_Parts);


    if (!empty($Module)) {
        $Param = array();
        for ($i = 0; $i < count($URL_Parts); $i++) {
            $Param[$URL_Parts[$i]] = $URL_Parts[++$i];
        }
    }
}

//
//if ($Page == 'index') include('page/index.php');
//else if ($Page == 'login') include('page/login.php');
//else if ($Page == 'register') include('page/register.php');
//else if ($Page == 'account') include('form/account.php');
//else if ($Page == 'profile') include('page/profile.php');
//else if ($Page == 'restore') include('page/restore.php');
//else if ($Page == 'oauth_authorize') include('page/oauth_authorize.php');
//else if ($Page == 'permissions') include('page/permissions.php');
//else if ($Page == 'oauth_login') include('page/oauth_login.php');
//else include('page/error.php');

if ($Page == 'index' or $Page == 'index.php' and $_SESSION['USER_LOGIN_IN'] == 1) include('bargain.php');
else if ($Page == 'index' or $Page == 'index.php' and $_SESSION['USER_LOGIN_IN'] != 1) include('page/login.php');
else if ($Page == 'bargain' or $Page == 'bargain.php') include('bargain.php');
else if ($Page == 'client' or $Page == 'client.php') include('client.php');
else if ($Page == 'analytic' or $Page == 'analytic.php') include('analytic.php');
else if ($Page == 'analytic_personal' or $Page == 'analytic_personal.php') include('analytic_personal.php');
else if ($Page == 'new_client' or $Page == 'new_client.php') include('new_client.php');
else if ($Page == 'new_bargain' or $Page == 'new_bargain.php') include('new_bargain.php');
else if ($Page == 'add_client' or $Page == 'add_client.php') include('add_client.php');
else if ($Page == 'add_bargain' or $Page == 'add_bargain.php') include('add_bargain.php');
else if ($Page == 'edit_bargain' or $Page == 'edit_bargain.php') include('edit_bargain.php');
else if ($Page == 'edit_bargain_form' or $Page == 'edit_bargain_form.php') include('edit_bargain_form.php');
else if ($Page == 'edit_client' or $Page == 'edit_client.php') include('edit_client.php');
else if ($Page == 'edit_client_form' or $Page == 'edit_client_form.php') include('edit_client_form.php');

else if ($Page == 'dateupdate' or $Page == 'dateupdate.php') include('dateupdate.php');
else if ($Page == 'exit' or $Page == 'exit.php') include('exit.php');
else if ($Page == 'filter' or $Page == 'filter.php') include('filter.php');
else if ($Page == 'livesearch' or $Page == 'livesearch.php') include('livesearch.php');
else if ($Page == 'maps' or $Page == 'maps.php') include('maps.php');
else if ($Page == 'maps_a' or $Page == 'maps_a.php') include('maps_a.php');
//else if ($Page == 'api' or $Page == 'api.php') include('api.php');

else if ($Page == 'login') include('page/login.php');
else if ($Page == 'register') include('page/register.php');
else if ($Page == 'account') include('form/account.php');
else if ($Page == 'profile') include('page/profile.php');
else if ($Page == 'restore') include('page/restore.php');
else if ($Page == 'oauth_authorize') include('page/oauth_authorize.php');
else if ($Page == 'permissions') include('page/permissions.php');
else if ($Page == 'oauth_login') include('page/oauth_login.php');
else if ($Page == 'api') include('form/api.php');
else if ($Page == 'api_bargain') include('form/api_bargain.php');
else if ($Page == 'api_client') include('form/api_client.php');
else include('page/error.php');




function ULogin($p1) {
    if ($p1 <= 0 and $_SESSION['USER_LOGIN_IN'] != $p1) MessageSend(1, 'Данная страница доступна только для гостей.', '/');
    else if ($_SESSION['USER_LOGIN_IN'] != $p1) MessageSend(1, 'Данная сртаница доступна только для пользователей.', '/');
}

function OAuthLink($state = '') {
    $state = 'That\'s_Good';
    if ($state) {echo '<a href="/oauth_authorize?response_type=code&client_id='.CID.'&state='.$state.'">
    <div class="Menu">OAuth</div></a>';}
    else {echo '<a href="/oauth_authorize?response_type=code&client_id='.CID.'">
    <div class="Menu">OAuth</div></a>';}

}

function Menu ($query) {
    if ($_SESSION['USER_LOGIN_IN'] != 1) $Menu =
        OAuthLink().


//    '<a href="/oauth_login?'.$query.'"><div class="Menu">Войти</div></a>'.
    '<a href="/register"><div class="Menu">Регистрация</div>
    </a><a href="/login"><div class="Menu">Вход</div></a>';//<a href="/restore">';
//    <div class="Menu">Восстановить пароль</div></a>';
    else $Menu =
        OAuthLink().
//        '<a href="/permissions?'.$query.'"><div class="Menu">Разрешения</div></a></div>'.
        '<a href="/bargain"><div class="Menu">Сделки</div></a>
        <a href="/client"><div class="Menu">Клиенты</div></a>
        <a href="/analytic_personal"><div class="Menu">Персонал</div></a>
        <a href="/analytic"><div class="Menu">Аналитика</div></a>
        <a href="/profile"><div class="Menu">Профиль</div></a>';
    echo '<div class="MenuHead">';
//    <a href="/"><div class="Menu">Главная</div></a>'.
        echo $Menu.'</div>';
}


function MessageSend($p1, $p2, $p3 = '') {
    if ($p1 == 1) $p1 = 'Ошибка';
    else if ($p1 == 2) $p1 = 'Подсказка';
    else if ($p1 == 3) $p1 = 'Информация';
    $_SESSION['message'] = '<div class="MessageBlock"><b>'.$p1.'</b>: '.$p2.'</div>';
    if ($p3) $_SERVER['HTTP_REFERER']  = $p3;
    exit(header('Location: '.$_SERVER['HTTP_REFERER']));
}



function MessageShow() {
    if ($_SESSION['message'])$Message = $_SESSION['message'];
    echo $Message;
    $_SESSION['message'] = array();
}


function UserCountry($p1) {
    if ($p1 == 0) return 'Не указан';
    else if ($p1 == 1) return 'Украина';
    else if ($p1 == 2) return 'Россия';
    else if ($p1 == 3) return 'США';
    else if ($p1 == 4) return 'Канада';
}


function RandomString($p1) {
    $Char = '0123456789abcdefghijklmnopqrstuvwxyz';
    for ($i = 0; $i < $p1; $i ++) $String .= $Char[rand(0, strlen($Char) - 1)];
    return $String;
}

function HideEmail($p1) {
    $Explode = explode('@', $p1);
    return $Explode[0].'@*****';
}


function FormChars ($p1) {
    return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}


function GenPass ($p1, $p2) {
    return md5('MRSHIFT'.md5('321'.$p1.'123').md5('678'.$p2.'890'));
}


function Head($p1) {
    echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>'.$p1.'</title><meta name="keywords" content="" />
    <meta name="description" content="" /><link href="resource/style.css" rel="stylesheet"></head>';
}

function HeadCss($p1, $css) {
    echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>'.$p1.'</title><meta name="keywords" content="" />
    <meta name="description" content="" /><link href="resource/style.css" rel="stylesheet">'.$css.'</head>';
}

function HeaderLink() {
    echo '<div class="header"><a href="/"></a></div>';
}

function Logit($message){
    $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи
    $test = fwrite($fp, $message.chr(10)); // Запись в файл
//    if ($test) echo 'Данные в файл успешно занесены.';
//    else echo 'Ошибка при записи в файл.';
    fclose($fp); //Закрытие файла
}


function Footer () {
    echo '<footer class="footer" style="text-align: center">RSOI 2015</footer>';
}
?>