<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
	<meta charset="ср1251">
	<meta charset="utf-8">
	<title>Члены Думы и комиссии, в которых они состояли</title>
</head>
<body style="background-color: rgb(120, 230, 230); font-size: 20px; color: blue;">
<center>
	<h1 align=center >Члены Думы и комиссии, в которых они состояли</h1>
<?php
include_once("db.php");

$stmt = mysqli_query($connection, " SELECT * FROM Member_commissions ");


if ($stmt){
	while($row = mysqli_fetch_assoc($stmt))
		{?>
		Член Думы: <?php echo $row['Члены Думы'];
		echo ' <br/>'?> 
		Коммиссии: <?php echo $row['Комиссии']?>
		<hr color='DimGrey' width="500" >
		
	<?php }
}

/*mysqli_close($connection);*/

?>
<p><a href="home.php">Главное меню</a></p>
</center>
</body>
</html>