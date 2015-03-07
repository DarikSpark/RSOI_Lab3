<?php
//ULogin(0);
if ($_SESSION['USER_LOGIN_IN'] == 1) {
    $URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    exit(header("Location: /permissions?$URL_Query"));
}
Head('Вход') ?>
<body>
<div class="wrapper">
    <?php HeaderLink(); ?>
    <div class="content">
        <?php
        $URL_Query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        Menu($URL_Query);
        MessageShow()
        ?>
        <div class="Page">
            <?php echo '<form method="POST" action="/account/oauth_login?'.$URL_Query.'">
                <br><input type="text" name="user" placeholder="Логин" maxlength="10" pattern="[A-Za-z-0-9]{3,10}" title="Не менее 3 и неболее 10 латынских символов или цифр." required>
                <br><input type="password" name="pass" placeholder="Пароль" maxlength="15" pattern="[A-Za-z-0-9]{1,15}" title="Не менее 5 и неболее 15 латынских символов или цифр." required>
                <div class="capdiv"><input type="text" class="capinp" name="captcha" placeholder="Капча" maxlength="10" pattern="[0-9]{1,5}" title="Только цифры." required> <img src="/resource/captcha.php" class="capimg" alt="Каптча"></div>
                <br><input type="checkbox" name="remember"> Запомнить меня
                <br><br><input type="submit" name="oauth_enter" value="Вход"> <input type="reset" value="Очистить">
            </form>';
            ?>
        </div>
    </div>

    <?php Footer() ?>
</div>
</body>
</html>