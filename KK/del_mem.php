<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh'>
<form  method="post" action="del_mem.php">
<table border="1" cellpadding="0" cellspacing="0" align=center>
<br><br><br>
 <tr>
  <td colspan="2" align="center"><strong>Удаление члена комиссии</strong></td>
 </tr>
 <tr>
  <td width="200">ID члена комиссии:</td>
  <td><input class='inp1' type="integer " name="ID_mem" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">ID комиссии:</td>
  <td><input class='inp1' type="integer " name="ID_com" maxlength="30" /></td>
 </tr>
  <td colspan="2" align="center">
   <input class='but1' type="submit"  name="send" value="Отправить запрос" />
   <input class='but1' type="reset" value="Очистить" />
  </td>
 </tr>
</table>
<br>
<center>
<input class='but1' type='submit' name='key' value='Подсказка'>
<p>	<a href="com_sost.php">Вернуться</a></p>
</center>
</form>
<div class='formd'>
<?php

#include_once("db.php");

$mysqli=new mysqli("localhost","root","","kk");
$mysqli->set_charset("utf8");
if(isset($_POST['send']))
{
    if (!is_numeric($_POST['ID_mem'])) echo "Вы некорректно ввели ID члена Думы";
    elseif (!is_numeric($_POST['ID_com'])) echo "Вы некорректно ввели ID комиссии";
    else {
    $q="Update mem_com set Exit_mem=now() where (ID_mem= ? and ID_com= ?)";
    $stmt=$mysqli->prepare($q);
    $stmt->bind_param('ii', $ID_mem, $ID_com);
	#$stmt = mysqli_prepare($connection," INSERT INTO mem_com (ID_mem, ID_com, Enter, Exit_mem) VALUES(?, ?, now(), ?)");
    #mysqli_stmt_bind_param('sss', $stmt, $ID_mem, $ID_com, $Exit_mem);
	/* удаление пробелов вначале и конце и удаление тегов */
	$ID_mem = strip_tags(trim($_POST['ID_mem'])); 
    $ID_com = strip_tags(trim($_POST['ID_com']));

	/* выполнение подготовленного запроса */
	$stmt->execute();	
	#printf("%d строк вставлено.\n", mysqli_stmt_affected_rows($stmt));
	
	/* закрываем запрос */
	$stmt->close();
	
	/* закрываем подключение */
	mysqli_close($mysqli);
}}
if (isset($_POST['key'])){?>
    <table  border=2  bordercolor='black' style='margin-right: 50px'>
        <caption><h3>Члены Думы</h3></caption>
        <tr><th>ID</th><th>Фамилия</th><th>Имя</th>  
    <?php $q="Select ID_mem, Surname, Name from member";
    $stmt=$mysqli->prepare($q);
    $stmt->execute();
    $res=$stmt->get_result(); 
    while  ( $output = $res->fetch_row() )
            {?>
                <tr color='black'><th><?php echo $output[0]?></th><th><?php echo $output[1]?></th><th><?php echo $output[2]?></th>
            <?php } 
    $stmt->close();?>
    <table border=2 bordercolor='black' >
        <caption><h3>Комиссии</h3></caption>
        <tr><th>ID</th><th>Название</th>
    <?php $q="Select * from commission";
    $stmt=$mysqli->prepare($q);
    $stmt->execute();
    $res=$stmt->get_result(); 
    while  ( $output = $res->fetch_row() )
            {?>
                <tr><th><?php echo $output[0]?></th><th><?php echo $output[1]?></th>
            <?php } 
    $stmt->close();
    mysqli_close($mysqli);
}
?>
</body>
</div>
</html>


