<?php
//ULogin(1);
if ($_SESSION['USER_LOGIN_IN'] != 1) {
    $URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    exit(header("Location: /oauth_login?$URL_Query"));
}
Head('Запрос разрешений') ?>
<body>
<div class="wrapper">
    <?php HeaderLink(); ?>
    <div class="content">
        <?php

        $URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        Menu($URL_Query);
        MessageShow();
//        echo '<div class="Block-permissions"><br></div>';

        echo '<div class="Block-permissions">
        <form method="POST" action="/account/oauth_accept?'.$URL_Query.'"  enctype="multipart/form-data">';
        echo'   <input type="checkbox" name="permission1" checked> Разрешить доступ к персональным данным
                <br><input type="checkbox" name="permission2" checked> Разрешить редактирование личных данных
                ';

        echo '<br><br><input type="submit" style=" cursor: pointer;" name="oauth_accept" value="Разрешить">
            <a href="/account/oauth_logout?'.$URL_Query.'" class="button ProfileOauth">Выйти</a>
            </form>';
        echo '</div>';
//        echo '<a href="/account/oauth_accept?'.$URL_Query.'
//        " class="button ProfileOauth">Разрешить</a>';
        ?>
    </div>

    <?php Footer() ?>
</div>
</body>
</html>