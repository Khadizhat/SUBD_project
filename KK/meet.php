<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh'>
    <center>
    <form  method="post" action="meet.php" >
        <h1>Все  заседания за определенный  период времени</h1>
        <p>Даты: <input class='inp1' placeholder='2019-01-01' type="date" name="d1">  ---  <input class='inp1' placeholder='2019-01-01' type="date" name="d2"></p>
        <br>
        <p><input class='but1' type="submit"  name='show' value="Вывести заседания"  onclick="cl()"/></p>
        <p><input class='but1' type="submit"  name='show1' value="Стереть"  onclick="res()"/></p>
    </form>
    <?php 
        if (isset($_POST['show'])) {
            $mysqli=new mysqli("localhost","root","","kk");
            $mysqli->set_charset("utf8");
            $stmt=$mysqli->prepare("call meetings( ?, ?)");
            $d1 = strip_tags(trim($_POST['d1']));
            $d2 = strip_tags(trim($_POST['d2']));
            $stmt->bind_param('ss', $d1, $d2);
            $stmt->execute();
            $res = $stmt->get_result();
            echo "Заседания: " ; ?><br><?php
            while  ( $output = $res->fetch_row() )
            {?>
                Коммиссия: <?php echo $output[0];
                echo  ' <br/>'?>
                Дата: <?php echo $output[1];
                echo ' <br/>'?>
                Состав: <?php echo $output[2]?>
                <hr color='DimGrey' width="800" >
        <?php } }
    if ($_SESSION['adm']==1) {?>
    <p ><a href='add_meet.php'>Добавить заседание</a>  </p> <?php }  ?>
     <p ><a href='home.php'>Главное меню</a>  </p>
     </center>
</body>
</html>