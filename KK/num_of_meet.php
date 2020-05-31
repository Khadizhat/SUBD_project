<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh'>
<center>
    <form  method="post" action="num_of_meet.php" >
        <h1 >Количество заседаний каждой комиссии в определенный промежуток</h1>
        <p >Даты: <input class='inp1' placeholder='2019-01-01' type="date" name="d1">  ---  <input class='inp1' placeholder='2019-01-01' type="date" name="d2"></p>
        <br>
        <p ><input class='but1' type="submit"  name='show' value="Посчитать"  onclick="cl()"/></p>
        <p ><input class='but1' type="submit"  name='show1' value="Стереть"  onclick="res()"/></p>
    </form>
    <?php 
        if (isset($_POST['show'])) {
            $mysqli=new mysqli("localhost","root","","kk");
            $mysqli->set_charset("utf8");
            $stmt=$mysqli->prepare("call Number_of_meeting( ?, ?)");
            $d1 = strip_tags(trim($_POST['d1']));
            $d2 = strip_tags(trim($_POST['d2']));
            $stmt->bind_param('ss', $d1, $d2);
            $stmt->execute();
            $res = $stmt->get_result();
            while  ( $output = $res->fetch_row() )
            {?>
                Комиссия: <?php echo $output[0]."<br>" ?>
                Количество заседаний: <?php echo $output[1]."<br>" ?>  
                <hr color='DimGrey' width="500">              
        <?php } } ?>
    <br><br>
     <p ><a href='home.php'>Главное меню</a>  </p>
     </center>
</body>
</html>