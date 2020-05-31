<!doctype html>
<html>
<head>
    <meta charset="ср1251">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <p align='right'>Пользователь: <?php session_start(); echo $_SESSION['user']?> &nbsp;&nbsp; <a href='enter.php'>Выход</a></p>
    <?php if (!$_SESSION['user']) header('Location: enter.php');?>
</head>
<body class='formh'>
    <h1 align=center>ГЛАВНОЕ МЕНЮ</h1>
    <h2 align=center>	<a href="com_sost.php">Комиссии и их состав</a></h2>
    <h2 align=center>	<a href="pred_com.php">Все председатели комиссии за опрделенный промежуток</a></h2>
    <h2 align=center>	<a href="mem_com.php">Члены Думы и комисии, в которых они состояли/состоят</a></h2>
    <h2 align=center>	<a href="mis_meet.php">Количество пропущенных заседаний в определенный промежуток времени</a></h2>
    <h2 align=center>	<a href="meet.php">Заседания</a></h2>
    <h2 align=center>	<a href="num_of_meet.php">Количество заседаний каждой комиссии в определенный промежуток</a></h2>

</body>
</html>