<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
	<meta charset="ср1251">
    <link rel="stylesheet" href="style.css" type="text/css" />
	<title>Комиссии и их состав</title>
</head>
<body class='formh'>
	<center>
<h1 >Комиссии и их состав</h1>
<?php
include_once("db.php");

$stmt = mysqli_query($connection, " SELECT * FROM Commissions_members ");


if ($stmt){
	while($row = mysqli_fetch_assoc($stmt))
		{?>
		Коммиссия: <?php echo $row['Комиссия'];
		echo  ' <br/>'?>
		Председатель: <?php echo $row['Председатель'];
		echo ' <br/>'?>
		Состав: <?php echo $row['Состав']?>
		<hr color='DimGrey' width="900">
		
	<?php }}

if ($_SESSION['adm']==1){
?>
 <p ><a href='add_newmem.php'>Добавить нового члена</a>  </p>
 <p ><a href='add_mem.php'>Добавить существующего члена в комиссию</a></p>
 <p ><a href='del_mem.php'>Удалить члена Думы из комиссии</a>  </p>
 <p ><a href='add_com.php'>Добавить комиссию</a>  </p>
<?php } ?>
 <p ><a href='home.php'>Главное меню</a>  </p>
</center>
</body>
</html>