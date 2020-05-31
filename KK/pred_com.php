<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh'>
<center>
    <form  method="post" action="pred_com.php" >
        <h1>Председатели комиссии за определенный промежуток времени</h1>
        <br>
        <p>Название комиссии: <input class='inp1' type="text " name="nam" maxlength="30" /> </p>
        <p>Даты: <input class='inp1' type="date" name="d1" placeholder='2019-01-01'>  ---  <input class='inp1' type="date" name="d2" placeholder='2019-01-01'></p>
        <br>
        <p><input class='but1' type="submit"  name='show' value="Вывести"  /></p>
        <p><input class='but1' type="submit"  name='show1' value="Стереть" /></p>
    </form>
    <?php 
        if (isset($_POST['show'])) {
            $mysqli=new mysqli("localhost","root","","kk");
            $mysqli->set_charset("utf8");
            $stmt=$mysqli->prepare("call Show_chairmens( ?, ?, ?)");
            $Name = strip_tags(trim($_POST['nam'])); 
            $d1 = strip_tags(trim($_POST['d1']));
            $d2 = strip_tags(trim($_POST['d2']));
            $stmt->bind_param('sss', $Name, $d1, $d2);
            $stmt->execute();
            $res = $stmt->get_result();
            echo "Председатели: ".'<br>' ; 
            while  ( $output = $res->fetch_row() )
            {
                echo $output[0];
                echo '<br/>';
            } }
    ?>
    <br><br>
     <p><a href='home.php'>Главное меню</a>  </p>
</center>
</body>
</html>