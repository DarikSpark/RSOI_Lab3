<?php Head('Главная страница') ?>
<body>
<div class="wrapper">
    <?php HeaderLink(); ?>
    <div class="content">
        <?php Menu();
        MessageShow()
        ?>
        <div class="Page">
            Главная страница
        </div>
    </div>

    <?php Footer() ?>
</div>
</body>
</html>