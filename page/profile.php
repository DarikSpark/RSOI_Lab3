<?php
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `firstName`, `secondName`,`lastName`,`email`
    FROM `manager` WHERE `managerID` = '$_SESSION[USER_ID]'"));

//$_SESSION['USER_FIRSTNAME'] = $Row['firstName'];
//$_SESSION['USER_SECONDNAME'] = $Row['secondName'];
//$_SESSION['USER_LASTNAME'] = $Row['lastName'];
//$_SESSION['USER_EMAIL'] = $Row['email'];
//echo 'WTF '.$Row['firstName'];
//exit();
ULogin(1);
Head('Профиль пользователя') ?>
<body>
<div class="wrapper">
    <?php HeaderLink(); ?>
    <div class="content">
        <?php Menu();
        MessageShow()
        ?>
        <div class="Page">

            <?php
            if ($_SESSION['USER_AVATAR'] == 0) $Avatar = 0;
            else $Avatar = $_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'];

            echo '
<img src="/resource/avatar/'.$Avatar.'.jpg" width="120" height="120" alt="Аватар" align="left">
<div class="Block">
ID '.$_SESSION['USER_ID'].//'
//<br>Имя '.$_SESSION['USER_NAME'].'
//<br>E-mail '.$_SESSION['USER_EMAIL'].'
//<br>Страна '.$_SESSION['USER_COUNTRY'].'
//<br>Дата регистрации '.$_SESSION['USER_REGDATE'].'
'<br>Фамилия:  '.$Row['lastName'].
'<br>Имя:  '.$Row['firstName'].
'<br>Отчество:  '.$Row['secondName'].
'<br>E-mail:  '.$Row['email'].
'</div>
<a href="/account/logout" class="button ProfileB">Быстрый выход</a><br><br>
<div class="ProfileEdit">
<form method="POST" action="/account/edit" enctype="multipart/form-data">
<br><input type="password" name="opassword" placeholder="Старый пароль" maxlength="15" pattern="[A-Za-z-0-9]{1,15}" title="Не менее 5 и неболее 15 латинских символов или цифр.">
<br><input type="password" name="npassword" placeholder="Новый пароль" maxlength="15" pattern="[A-Za-z-0-9]{1,15}" title="Не менее 5 и неболее 15 латинских символов или цифр.">'.
//<br><input type="text" name="name" placeholder="Имя" maxlength="10" pattern="[А-Яа-яЁё]{4,10}" title="Не менее 4 и неболее 10 латинских символов или цифр." value="'.$_SESSION['USER_NAME'].'" required>
//<br><select size="1" name="country">'.str_replace('>'.$_SESSION['USER_COUNTRY'], 'selected>'.$_SESSION['USER_COUNTRY'], '<option value="0">Не скажу</option><option value="1">Украина</option><option value="2">Россия</option><option value="3">США</option><option value="4">Канада</option>').'</select>
//'<br><input type="file" name="avatar">
'<br><br><input type="submit" name="enter" value="Сохранить"> <input type="reset" value="Очистить">
</form>
<br>
</div>
';
            ?>


        </div>
    </div>

    <?php Footer() ?>
</div>
</body>
</html>