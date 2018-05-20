<?php if(isset($_POST) || empty($_POST)){
    $link = mysqli_connect('localhost', 'admin', 'admin');
    $db = "diplom";
    $select = mysqli_select_db($link, $db);

    if ($_POST['user_email'] && $_POST['user_email'] != ''){
        $email = $_POST['user_email'];
        $query = "SELECT NAME_USER FROM diplom_users WHERE EMAIL = '$email'";
        $res = mysqli_query($link, $query);

        if (!mysqli_fetch_array($res)){
            $name = $_POST['user_name'];
            $login = $_POST['user_login'];
            $password = $_POST['user_password'];
            $query = "INSERT INTO diplom_users (NAME_USER, PASSWORD, LOGIN, EMAIL) VALUES ('$name', '$password', '$login', '$email')";
            $add_user = mysqli_query($link, $query);

            header('Set-cookie: authorize=1');
            header('Location: /diplom/index.php');
         } else {
            ?><script>alert ("Пользователь с таким e-mail уже существует")</script><?
        }

    } else if ($_POST['user_login']) {
        $login = $_POST['user_login'];
        $password = $_POST['user_password'];
        $query = "SELECT NAME_USER FROM diplom_users WHERE LOGIN = '$login' AND PASSWORD = '$password'";
        $res = mysqli_query($link, $query);

        if (mysqli_fetch_array($res)){
            header('Set-cookie: authorize=1');
            header('Location: /diplom/index.php');
        }else{
            ?><script>alert ("Неверно введен логин или пароль")</script><?
        }
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css?vs.1">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous">
    </script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="header">
    <hr>
    <nav class = "top_menu">
        <ul>
            <?php if ($_COOKIE['authorize']!=1):?>
            <li class="right"><a href = javascript:void(0); onClick = "openForm(back_reg, exitWindow_reg);">Зарегистрироваться</a></li>
            <?php endif;?>
            <li><a href = "/diplom/index.php">Главная</a></li>
            <li><a href = "/diplom/sale7.php">Цены www.sale7.com</a></li>
            <?php if ($_COOKIE['authorize']!=1):?>
            <li class="right"><a href = javascript:void(0); onClick = "openForm(back, exitWindow);">Вxод</a></li>
            <?php endif;?>
            <?php if ($_COOKIE['authorize']==1):?>
                <li class="right"><a href = javascript:void(0); onClick = "document.cookie = 'authorize=0'; location.reload();">Выxод</a></li>
            <?php endif;?>
        </ul>
    </nav>
</div>
<div id="back">
    <div id = "exitWindow">
        <div class="exit">
            <p>Вход</p>
            <img src="image/close.svg" style="width:20px; height: 20px" onClick = "closeForm(back, exitWindow);">
        </div>
        <form id="flogin" name="flogin" method="post">
            <div class="form-info-box first">
                <label for="lbl201">Логин</label><input type="text" id="lbl201" class="txt-inp" value="userlogin" name="user_login">
            </div>
            <div class="form-info-box">
                <label for="lbl200">Пароль</label><input type="password" id="lbl200" class="txt-inp" name="user_password">
            </div>
            <div class="clear"></div>
            <div class="line-box">
                <div class="form-info-box first">
                    <input type="checkbox" value="1" name="is_save_me" id="is_save_me" style="float:left;" class="niceCheck"><label for="is_save_me" style="width: 150px;padding-left:30px;">Запомнить меня</label>
                </div>
                <div class="form-info-box"><a href="#">Забыли пароль?</a></div>
                <div class="clear"></div>
            </div>
            <div class="bottom-line"><input class="light-blue-btn" type="submit" value="Вход" onClick = "validate(array(lbl200, lbl201));"></div>
        </form>
    </div>
</div>
<div id="back_reg">
    <div id = "exitWindow_reg">
        <div class="exit">
            <p>Регистрация</p>
            <img src="image/close.svg" style="width:20px; height: 20px" onClick = "closeForm(back_reg, exitWindow_reg);">
        </div>
        <form id="flogin" name="flogin" method="post">
            <input type="hidden" value="1" name="is_auth"><div class="medium-title-box">Логин и пароль</div>
            <div class="form-info-box first">
                <label for="lbl201">Логин</label><input type="text" id="lbl201" class="txt-inp" value="userlogin" name="user_login">
            </div>
            <div class="form-info-box">
                <label for="lbl202">Пароль</label><input type="password" id="lbl202" class="txt-inp" value="userlogin" name="user_password">
            </div>
            <div class="form-info-box first">
                <label for="lbl203">Имя</label><input type="text" id="lbl203" class="txt-inp" value="username" name="user_name">
            </div>
            <div class="form-info-box">
                <label for="lbl204">Электронная почты</label><input type="email" id="lbl204" class="txt-inp" name="user_email">
            </div>
            <div class="clear"></div>
            <input class = "light-blue-btn" type="submit" value = "ОK" onClick = "validate(array(lbl201, lbl202, lbl203, lbl204));"/>
            <input class = "light-blue-btn" type = "button" value = "Отмена" onClick = "closeForm(back_reg, exitWindow_reg);"/>
        </form>
    </div>
</div>
