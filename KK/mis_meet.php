<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh'>
<center>
    <form  method="post" action="mis_meet.php" >
        <h1>Количество пропущенных заседаний каждого члена комиссии в определенный промежуток</h1>
        <br>
        <p >ID комиссии: <input class='inp1' type="integer" name="ID_com"> 
        <p>Даты: <input class='inp1' placeholder='2019-01-01'  type="date" name="d1">  ---  <input class='inp1' placeholder='2019-01-01' type="date" name="d2"></p>
        <br>
        <p><input class='but1' type="submit"  name='show' value="Вывести" /></p>
        <p><input class='but1' type="submit"  name='show1' value="Стереть"  onclick="res()"/></p>
    </form>
    <?php 
        if (isset($_POST['show'])) {
            if (!is_numeric($_POST['ID_com'])) echo "Вы некорректно ввели ID комиссии";
            else  {$mysqli=new mysqli("localhost","root","","kk");
                $mysqli->set_charset("utf8");
                $stmt=$mysqli->prepare("call Missed_meetings(?, ?, ?)");           
                $ID_com = strip_tags(trim($_POST['ID_com']));
                $d1 = strip_tags(trim($_POST['d1']));
                $d2 = strip_tags(trim($_POST['d2']));
                $stmt->bind_param('iss', $ID_com, $d1, $d2);
                $stmt->execute();
                $res = $stmt->get_result();
                while  ( $output = $res->fetch_row() )
                {?>
                    Член комиссии: <?php echo $output[0]."<br>" ?>
                    Количество пропущенных заседаний: <?php echo $output[1]."<br>" ?>  
                    <hr />              
            <?php }}} ?>
    <br><br>
     <p ><a href='home.php'>Главное меню</a>  </p>
     </center>
</body>
</html>