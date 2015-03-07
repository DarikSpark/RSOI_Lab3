<?php

Logit('['.date( "d.m.y H:i" ).'] Обращение к бэкенду сессии: http://www.rosescrm.brottys.ru/account');


if ($Module == 'oauth_logout' and $_SESSION['USER_LOGIN_IN'] == 1) {
    if ($_COOKIE['user']) {
        setcookie('user', '', strtotime('-1 days'), '/');
        unset($_COOKIE['user']);
    }
    session_unset();
    $URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    Logit('['.date( "d.m.y H:i" ).'] Завершение сессии Oauth 2.0');
    header("Location: /oauth_login?$URL_Query");
}



if ($Module == 'logout' and $_SESSION['USER_LOGIN_IN'] == 1) {
    if ($_COOKIE['user']) {
        setcookie('user', '', strtotime('-1 days'), '/');
        unset($_COOKIE['user']);
    }
    session_unset();
    Logit('['.date( "d.m.y H:i" ).'] Пользователь закрыл сессию');
    exit(header('Location: /login'));

}


if ($Module == 'edit' and $_POST['enter']) {
    ULogin(1);
    $_POST['opassword'] = FormChars($_POST['opassword']);
    $_POST['npassword'] = FormChars($_POST['npassword']);
//    $_POST['name'] = FormChars($_POST['name']);
//    $_POST['country'] = FormChars($_POST['country']);

    if ($_POST['opassword'] or $_POST['npassword']) {
        if (!$_POST['opassword']) MessageSend(2, 'Не указан старый пароль');
        if (!$_POST['npassword']) MessageSend(2, 'Не указан новый пароль');
        if ($_SESSION['USER_PASSWORD'] != GenPass($_POST['opassword'], 'DarikSpark')) MessageSend(2, 'Старый пароль указан не верно.');
        $Password = GenPass($_POST['npassword'], 'DarikSpark');
        mysqli_query($CONNECT, "UPDATE `userlist`  SET `pass` = '$Password' WHERE `id` = $_SESSION[USER_ID]");
        $_SESSION['USER_PASSWORD'] = $Password;
        setcookie('user', $Password, strtotime('+1 days'), '/');
    }


//    if ($_POST['name'] != $_SESSION['USER_NAME']) {
//        mysqli_query($CONNECT, "UPDATE `users_shift`  SET `name` = '$_POST[name]' WHERE `id` = $_SESSION[USER_ID]");
//        $_SESSION['USER_NAME'] = $_POST['name'];
//    }

//
//    if (UserCountry($_POST['country']) != $_SESSION['USER_COUNTRY']) {
//        mysqli_query($CONNECT, "UPDATE `users_shift`  SET `country` = $_POST[country] WHERE `id` = $_SESSION[USER_ID]");
//        $_SESSION['USER_COUNTRY'] = UserCountry($_POST['country']);
//    }


//    if ($_FILES['avatar']['tmp_name']) {
//        if ($_FILES['avatar']['type'] != 'image/jpeg') MessageSend(2, 'Не верный тип изображения.');
//        if ($_FILES['avatar']['size'] > 20000) MessageSend(2, 'Размер изображения слишком большой.');
//        $Image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
//        $Size = getimagesize($_FILES['avatar']['tmp_name']);
//        $Tmp = imagecreatetruecolor(120, 120);
//        imagecopyresampled($Tmp, $Image, 0, 0, 0, 0, 120, 120, $Size[0], $Size[1]);
//        if ($_SESSION['USER_AVATAR'] == 0) {
//            $Files = glob('resource/avatar/*', GLOB_ONLYDIR);
//            foreach($Files as $num => $Dir) {
//                $Num ++;
//                $Count = sizeof(glob($Dir.'/*.*'));
//                if ($Count < 250) {
//                    $Download = $Dir.'/'.$_SESSION['USER_ID'];
//                    $_SESSION['USER_AVATAR'] = $Num;
//                    mysqli_query($CONNECT, "UPDATE `users_shift`  SET `avatar` = $Num WHERE `id` = $_SESSION[USER_ID]");
//                    break;
//                }
//            }
//        }
//        else $Download = 'resource/avatar/'.$_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'];
//        imagejpeg($Tmp, $Download.'.jpg');
//        imagedestroy($Image);
//        imagedestroy($Tmp);
//    }




    MessageSend(3, 'Данные изменены.');
}


if ($Module == 'oauth_accept' and $_POST['oauth_accept']) {
    Logit('['.date( "d.m.y H:i" ).'] Получение кода пользователя');
    $_POST['permission1'] = FormChars($_POST['permission1']);
    $_POST['permission2'] = FormChars($_POST['permission2']);
    $_GET['client_id'] = FormChars($_GET['client_id']);
    $_GET['response_type'] = FormChars($_GET['response_type']);
    if (!$_POST['permission1'] or !$_POST['permission1']) MessageSend(1, 'Невозможно обработать форму.');
    if  (!$_SESSION['USER_ID'] or !$_GET['client_id']) MessageSend(1, 'Отсутствует идентификатор пользователя или приложения');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `client_id`, `user_id`, `code` FROM `oauth_apps_codes` WHERE
    `user_id`='$_SESSION[USER_ID]' and `client_id`='$_GET[client_id]'"));
    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `callback_url` FROM `oauth_apps` WHERE `client_id`='$_GET[client_id]'"));
    $callback_url = $arr['callback_url'];
    $state = $_GET['state'];
    $expired_tok = strtotime('+1 day');
    if ($Row['client_id'] == $_GET['client_id'] and $Row['user_id'] == $_SESSION['USER_ID']){
        $code = $Row['code'];
        if ($state) {Logit('['.date( "d.m.y H:i" ).'Ответ бэкенда сессии: аккаунт уже был зарегистрирован в приложении. <b>Код: '.$code);
            MessageSend(3, 'Аккаунт уже был зарегистрирован в приложении. <b>Код: '.$code.'</b>', $callback_url.'?code='.$code.'&state='.$state);
        }
        else {
            Logit('['.date( "d.m.y H:i" ).'Ответ бэкенда сессии: аккаунт уже был зарегистрирован в приложении. <b>Код: '.$code);
            MessageSend(3, 'Аккаунт уже был зарегистрирован в приложении. <b>Код: '.$code.'</b>', $callback_url.'?code='.$code);
        }
    }
    else {
        $code = GenPass($_POST['client_id'], $_SESSION['USER_ID']);
        $token = GenPass($_POST['client_id'], $code);
        $refresh_token = GenPass($_POST['client_id'], $token);
        mysqli_query($CONNECT, "INSERT INTO `oauth_apps_codes`  VALUES ('', '$_GET[client_id]', '$_SESSION[USER_ID]', '$code', '$token', '$refresh_token', '$expired_tok')");
        if ($state) {
            Logit('['.date( "d.m.y H:i" ).'Регистрация акаунта в приложении успешно завершена. <b>Код: '.$code);
            MessageSend(3, 'Регистрация акаунта в приложении успешно завершена. <b>Код: '.$code.'</b>', $callback_url.'?code='.$code.'&state='.$state);
        }


        else {
            Logit('['.date( "d.m.y H:i" ).'Регистрация акаунта в приложении успешно завершена. <b>Код: '.$code);
            MessageSend(3, 'Регистрация акаунта в приложении успешно завершена. <b>Код: '.$code.'</b>', $callback_url.'?code='.$code);
        }
    }


}

if ($Module == 'oauth_token' and $_POST['code'] and $_POST['client_secret'] and $_POST['client_id'] and $_POST['response_type']) {
    header('Content-type: application/json');
    if ($_POST['response_type'] == 'token'){
//        Logit('['.date( "d.m.y H:i" ).'] Получение токена');
    $code = $_POST['code'];
    $client_secret = $_POST['client_secret'];
    $client_id_post = $_POST['client_id'];
    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `client_id` FROM `oauth_apps`
    WHERE `client_secret`='$client_secret'"));
    $client_id = $arr['client_id'];
    if ($client_id == $client_id_post) {
        $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `token`, `refresh_token`, `expired` FROM `oauth_apps_codes`
          WHERE `client_id`='$client_id' and `code`='$code'"));
        $token = $arr['token'];
        $refresh_token = $arr['refresh_token'];
        $expired_tok = $arr['expired'];
        if ($token){
            $response_tok = array(
                "token"=>$token,
                "refresh_token" => $refresh_token,
                "expired" => $expired_tok
            );
            Logit('['.date( "d.m.y H:i" ).'Успешное получение токена: '.json_encode($response_tok));
        }
        else {$response_tok = array(
            "error"=> "invalid_code",
            "error_description"=> "Application with this specified code not found or disabled."
        );
        Logit('['.date( "d.m.y H:i" ).'Ошибка при получении токена: '.json_encode($response_tok));
        };
    }
    else{
        $response_tok = array(
            "error"=> "invalid_client",
            "error_description"=> "Application with this specified client_id not found or disabled. Any given parameter client_secret does not correspond to the application."
        );
        Logit('['.date( "d.m.y H:i" ).'Ошибка при получении токена: '.json_encode($response_tok));
    }

    $jsonString = json_encode($response_tok);
    echo $jsonString;
    exit();
    }
    else if ($_POST['response_type'] == 'refresh_token') {
        Logit('['.date( "d.m.y H:i" ).'] Обновление токена');
        $code = $_POST['code'];
        $client_secret = $_POST['client_secret'];
        $client_id_post = $_POST['client_id'];
        $refresh_token_old = $_POST['refresh_token'];
        $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `client_id` FROM `oauth_apps`
    WHERE `client_secret`='$client_secret'"));
        $client_id = $arr['client_id'];
        if ($client_id == $client_id_post) {
            $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `token`, `refresh_token`, `expired` FROM `oauth_apps_codes`
          WHERE `client_id`='$client_id' and `refresh_token`='$refresh_token_old'"));
            $token = $arr['token'];
            $refresh_token = $arr['refresh_token'];
            $expired_tok = $arr['expired'];
            if ($refresh_token){
                $expired_tok = strtotime('+1 day');
                $token = GenPass($expired_tok, $code);
//                $refresh_token = GenPass($_POST['client_id'], $token);


                mysqli_query($CONNECT, "UPDATE `oauth_apps_codes` SET `token`='$token', `refresh_token`='$refresh_token',
                    `expired`='$expired_tok' WHERE `refresh_token`='$refresh_token_old'");

                $response_tok = array(
                    "token"=>$token,
                    "refresh_token" => $refresh_token,
                    "expired" => $expired_tok
                );
                Logit('['.date( "d.m.y H:i" ).'Успешное обновление токена: '.json_encode($response_tok));
            }
            else {$response_tok = array(
                "error"=> "invalid_code",
                "error_description"=> "Application with this specified code not found or disabled."
            );
                Logit('['.date( "d.m.y H:i" ).'Ошибка при обновлении токена: '.json_encode($response_tok));
            };
        }
        else{
            $response_tok = array(
                "error"=> "invalid_client",
                "error_description"=> "Application with this specified client_id not found or disabled. Any given parameter client_secret does not correspond to the application."
            );
            Logit('['.date( "d.m.y H:i" ).'Ошибка при обновлении токена: '.json_encode($response_tok));
        }

        $jsonString = json_encode($response_tok);
        echo $jsonString;

        exit();
    }
}


//if ($Module == 'me' and $_POST['code'] and $_POST['client_secret'] and $_POST['client_id']) {
//    $code = $_POST['code'];
//    $client_secret = $_POST['client_secret'];
//    $client_id_post = $_POST['client_id'];
//    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `client_id` FROM `oauth_apps`
//    WHERE `client_secret`='$client_secret'"));
//    $client_id = $arr['client_id'];
//    if ($client_id == $client_id_post) {
//        $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `token`, `refresh_token`, `expired` FROM `oauth_apps_codes`
//          WHERE `client_id`='$client_id' and `code`='$code'"));
//        $token = $arr['token'];
//        $refresh_token = $arr['refresh_token'];
//        $expired_tok = $arr['expired'];
//        if ($token){
//            $response_tok = array(
//                "token"=>$token,
//                "refresh_token" => $refresh_token,
//                "expired" => $expired_tok
//            );
//        }
//        else {$response_tok = array(
//            "error"=> "invalid_code",
//            "error_description"=> "Application with this specified code not found or disabled."
//        );};
//    }
//    else{
//        $response_tok = array(
//            "error"=> "invalid_client",
//            "error_description"=> "Application with this specified client_id not found or disabled. Any given parameter client_secret does not correspond to the application."
//        );
//    }
//
//    $jsonString = json_encode($response_tok);
//    echo $jsonString;
//
//    exit();
//}



ULogin(0);
if ($Module == 'restore' and !$Param['code'] and substr($_SESSION['RESTORE'], 0, 4) == 'wait') MessageSend(2, 'Вы уже отправили заявку на восстановление пароля. Проверьте ваш E-mail адрес <b>'.HideEmail(substr($_SESSION['RESTORE'], 5)).'</b>');
if ($Module == 'restore' and $_SESSION['RESTORE'] and substr($_SESSION['RESTORE'], 0, 4) != 'wait') MessageSend(2, 'Ваш пароль ранее уже был изменен. Для входа используйте нвоый пароль <b>'.$_SESSION['RESTORE'].'</b>', '/login');





if ($Module == 'restore' and $Param['code']) {
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, 'SELECT `email` FROM `users_shift` WHERE `id` = '.str_replace(md5($Row['email']), '', $Param['code'])));
    if (!$Row['email']) MessageSend(1, 'Невозможно восстановить пароль.', '/login');
    $Random = RandomString(15);
    $_SESSION['RESTORE'] = $Random;
    mysqli_query($CONNECT, "UPDATE `users_shift` SET `password` = '".GenPass($Random, $Row['login'])."' WHERE `login` = '$Row[login]'");
    MessageSend(2, 'Пароль успешно изменен, для входа используйте новый пароль <b>'.$Random.'</b>', '/login');
}



if ($Module == 'restore' and $_POST['enter']) {
    $_POST['login'] = FormChars($_POST['login']);
    $_POST['captcha'] = FormChars($_POST['captcha']);
    if (!$_POST['login'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
    if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `email` FROM `users_shift` WHERE `login` = '$_POST[login]'"));
    if (!$Row['email']) MessageSend(1, 'Пользователь не найден.');
    mail($Row['email'], 'Mr.Shift', 'Ссылка для восстановления: http://mr-shift.ru/account/restore/code/'.md5($Row['email']).$Row['id'], 'From: web@mr-shift.ru');
    $_SESSION['RESTORE'] = 'wait_'.$Row['email'];
    MessageSend(2, 'На ваш E-mail адрес <b>'.HideEmail($Row['email']).'</b> отправлено подтерждение смены пароля');
}



//if ($Module == 'register' and $_POST['enter']) {
//    $_POST['login'] = FormChars($_POST['login']);
//    $_POST['email'] = FormChars($_POST['email']);
//    $_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['login']);
//    $_POST['name'] = FormChars($_POST['name']);
//    $_POST['country'] = FormChars($_POST['country']);
//    $_POST['captcha'] = FormChars($_POST['captcha']);
//    if (!$_POST['login'] or !$_POST['email'] or !$_POST['password'] or !$_POST['name'] or $_POST['country'] > 4 or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
//    if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
//    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login` FROM `users_shift` WHERE `login` = '$_POST[login]'"));
//    if ($Row['login']) exit('Логин <b>'.$_POST['login'].'</b> уже используеться.');
//    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `email` FROM `users_shift` WHERE `email` = '$_POST[email]'"));
//    if ($Row['email']) exit('E-Mail <b>'.$_POST['email'].'</b> уже используеться.');
//    mysqli_query($CONNECT, "INSERT INTO `users_shift`  VALUES ('', '$_POST[login]', '$_POST[password]', '$_POST[name]', NOW(), '$_POST[email]', $_POST[country], 0, 1)");
//    $Code = str_replace('=', '', base64_encode($_POST['email']));
//    mail($_POST['email'], 'Регистрация на блоге Mr.Shift', 'Ссылка для активации: http://mr-shift.ru/account/activate/code/'.substr($Code, -5).substr($Code, 0, -5), 'From: web@mr-shift.ru');
//    MessageSend(3, 'Регистрация акаунта успешно завершена. На указанный E-mail адрес <b>'.$_POST['email'].'</b> отправленно письмо о подтверждении регистрации.');
//}


if ($Module == 'register' and $_POST['enter']) {
    Logit('['.date( "d.m.y H:i" ).'] Регистрация пользователя в системе');
    $_POST['login'] = FormChars($_POST['login']);
    $_POST['email'] = FormChars($_POST['email']);
    $_POST['password'] = GenPass(FormChars($_POST['password']), 'DarikSpark');
    $_POST['lastName'] = FormChars($_POST['lastName']);
    $_POST['firstName'] = FormChars($_POST['firstName']);
    $_POST['secondName'] = FormChars($_POST['secondName']);
    $_POST['captcha'] = FormChars($_POST['captcha']);
    if (!$_POST['login'] or !$_POST['email'] or !$_POST['password'] or !$_POST['lastName'] or !$_POST['firstName']
        or !$_POST['secondName'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
    if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `user` FROM `userlist` WHERE `user` = '$_POST[login]'"));
    if ($Row['user']) exit('Логин <b>'.$_POST['login'].'</b> уже используеться.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `email` FROM `manager` WHERE `email` = '$_POST[email]'"));
    if ($Row['email']) exit('E-Mail <b>'.$_POST['email'].'</b> уже используеться.');
    mysqli_query($CONNECT, "INSERT INTO `manager`  VALUES ('', '$_POST[lastName]', '$_POST[firstName]', '$_POST[secondName]', '', '', '$_POST[email]', '$_POST[login]', '$_POST[password]')");
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `managerID` FROM `manager` WHERE `email` = '$_POST[email]'"));
    mysqli_query($CONNECT, "INSERT INTO `userlist`  VALUES ('', '$Row[managerID]', '$_POST[login]', '$_POST[password]')");
    $Code = str_replace('=', '', base64_encode($_POST['email']));
    mail($_POST['email'], 'Регистрация на блоге Mr.Shift', 'Ссылка для активации: http://mr-shift.ru/account/activate/code/'.substr($Code, -5).substr($Code, 0, -5), 'From: web@mr-shift.ru');
    MessageSend(3, 'Регистрация акаунта успешно завершена. На указанный E-mail адрес <b>'.$_POST['email'].'</b> отправленно письмо о подтверждении регистрации.');
}


else if ($Module == 'activate' and $Param['code']) {
    if (!$_SESSION['USER_ACTIVE_EMAIL']) {
        $Email = base64_decode(substr($Param['code'], 5).substr($Param['code'], 0, 5));
        if (strpos($Email, '@') !== false) {
            mysqli_query($CONNECT, "UPDATE `users_shift`  SET `active` = 1 WHERE `email` = '$Email'");
            $_SESSION['USER_ACTIVE_EMAIL'] = $Email;
            MessageSend(3, 'E-mail <b>'.$Email.'</b> подтвержден.', '/login');
        }
        else MessageSend(1, 'E-mail адрес не подтвержден.', '/login');
    }
    else MessageSend(1, 'E-mail адрес <b>'.$_SESSION['USER_ACTIVE_EMAIL'].'</b> уже подтвержден.', '/login');
}



//else if ($Module == 'login' and $_POST['enter']) {
//    $_POST['login'] = FormChars($_POST['login']);
//    $_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['login']);
//    $_POST['captcha'] = FormChars($_POST['captcha']);
//    if (!$_POST['login'] or !$_POST['password'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
//    if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
//    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `password`, `active` FROM `users_shift` WHERE `login` = '$_POST[login]'"));
//    if ($Row['password'] != $_POST['password']) MessageSend(1, 'Не верный логин или пароль.');
//    if ($Row['active'] == 0) MessageSend(1, 'Аккаунт пользователя <b>'.$_POST['login'].'</b> не подтвержден.');
//    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `regdate`, `email`, `country`, `avatar`, `password`, `login` FROM `users_shift` WHERE `login` = '$_POST[login]'"));
//    $_SESSION['USER_LOGIN'] = $Row['login'];
//    $_SESSION['USER_PASSWORD'] = $Row['password'];
//    $_SESSION['USER_ID'] = $Row['id'];
//    $_SESSION['USER_NAME'] = $Row['name'];
//    $_SESSION['USER_REGDATE'] = $Row['regdate'];
//    $_SESSION['USER_EMAIL'] = $Row['email'];
//    $_SESSION['USER_COUNTRY'] = UserCountry($Row['country']);
//    $_SESSION['USER_AVATAR'] = $Row['avatar'];
//    $_SESSION['USER_LOGIN_IN'] = 1;
//    if ($_REQUEST['remember']) setcookie('user', $_POST['password'], strtotime('+1 days'), '/');
//    exit(header('Location: /profile'));
//}

else if ($Module == 'login' and $_POST['enter']) {
    Logit('['.date( "d.m.y H:i" ).'] Авторизация пользователя в системе');
    $_POST['user'] = FormChars($_POST['user']);
    $_POST['pass'] = GenPass(FormChars($_POST['pass']), 'DarikSpark');
    $_POST['captcha'] = FormChars($_POST['captcha']);
    if (!$_POST['user'] or !$_POST['pass'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
    if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `pass` FROM `userlist` WHERE `user` = '$_POST[user]'"));
//    echo 'В Базе: '.$Row['pass'].'<br>В форме: '.$_POST['pass'];
//    exit();
    if ($Row['pass'] != $_POST['pass']) MessageSend(1, 'Не верный логин или пароль.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `managerID`, `pass`, `user` FROM `userlist` WHERE `user` = '$_POST[user]'"));
    $_SESSION['USER_LOGIN'] = $Row['user'];
    $_SESSION['USER_PASSWORD'] = $Row['pass'];
    $_SESSION['USER_ID'] = $Row['managerID'];
    $_SESSION['USER_LOGIN_IN'] = 1;
    if ($_REQUEST['remember']) setcookie('user', $_POST['pass'], strtotime('+1 days'), '/');
    Logit('['.date( "d.m.y H:i" ).'Авторизация пользователя прошла успешно: ');
    exit(header('Location: /'));
}

else if ($Module == 'oauth_login' and $_POST['oauth_enter']) {
    Logit('['.date( "d.m.y H:i" ).'] OAuth 2.0 авторизация пользователя');
    $_POST['user'] = FormChars($_POST['user']);
    $_POST['pass'] = GenPass(FormChars($_POST['pass']), 'DarikSpark');
    $_POST['captcha'] = FormChars($_POST['captcha']);
    if (!$_POST['user'] or !$_POST['pass'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
    if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Капча введена не верно.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `pass` FROM `userlist` WHERE `user` = '$_POST[user]'"));
//    echo 'В Базе: '.$Row['pass'].'<br>В форме: '.$_POST['pass'];
//    exit();
    if ($Row['pass'] != $_POST['pass']) MessageSend(1, 'Не верный логин или пароль.');
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `managerID`, `pass`, `user` FROM `userlist` WHERE `user` = '$_POST[user]'"));
    $_SESSION['USER_LOGIN'] = $Row['user'];
    $_SESSION['USER_PASSWORD'] = $Row['pass'];
    $_SESSION['USER_ID'] = $Row['managerID'];
    $_SESSION['USER_LOGIN_IN'] = 1;
    if ($_REQUEST['remember']) setcookie('user', $_POST['pass'], strtotime('+1 days'), '/');
    $URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    Logit('['.date( "d.m.y H:i" ).'Oauth 2.0 авторизация пользователя прошла успешно: ');
    header("Location: /permissions?$URL_Query");
}

?>