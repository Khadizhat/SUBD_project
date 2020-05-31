<!doctype html>
<html>
<head>
    <meta charset="ср1251">
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body class='forms'>
    <div class="form">
        <h2>Форма регистрации</h2>
        <form action='reg.php' method='post' >
            <input class='inp' name="login" type='text' placeholder="Логин" ><br>
            <input class='inp'  name="password" type='password' placeholder="Пароль"><br>
            <input class='inp' name="name" type='text' placeholder="ФИО"><br><br>
            <button name="enter" class='but' type='submit' >Зарегистрироваться</button><br><br>
            <a href="enter.php">Уже зарегистрированы</a>
        </form>
    </div>
    
</body>
</html>