<!doctype html>
<html>
<head>
    <meta charset="ср1251">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <?php session_start(); $_SESSION['user']=''; $_SESSION['adm']=0; ?>
</head>
<body class='forms'>
<div class="form">
    <h2>Форма входа</h2>
    <form action='log.php' method='post'>
        <input class='inp' name="login" type='text' placeholder="Логин"><br>
        <input class='inp' name="password" type='password' placeholder="Пароль"><br><br>
        <input class='but' name="enter" type='submit' value="Войти"><br><br>
        <a href="reg_form.php">Регистрация</a>
    </form>
</div>
</body>
</html>