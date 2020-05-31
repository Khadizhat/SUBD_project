<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body  class='formh' >
<form  method="post" action="add_meet.php" >
&nbsp;
<table border="1" cellpadding="0" cellspacing="0" align="center">
 <tr>
  <td colspan="2" align="center"><strong>Добавление заседания</strong></td>
 </tr>
 <tr>
 <td width="300">Количество присутствующих:</td>
  <td><input class='inp1' type="integer" name="K" maxlength="30" /></td>
 </tr>
 <?php if (isset($_POST['add']) && !isset($_POST['send'])) {if  (isset($_POST['K'])) $k=$_POST['K'];
   if (!is_numeric($_POST["K"])) echo "Неверно введено количество присутствующих";
   else {
  $_SESSION["K"]=$k;
  for ($i=0; $i<$k; $i++)  {?>
    <tr>
    <td width="150">ID члена Думы:</td>
    <td><input class='inp1'  type="integer" name=<?php echo $i ?> maxlength="30" /></td>
    </tr>
  <?php }}} ?>
  <td colspan="2" align="center">
    <input class='inp1' type="submit" name="add"  value="Добавить ячейки для  ввода ID">
    </td>
 <tr>
  <td width="150">ID заседания:</td>
  <td><input class='inp1' type="integer " name="ID_meet" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="150">ID комиссии:</td>
  <td><input class='inp1' type="integer " name="ID_com" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="150">Место:</td>
  <td><input class='inp1' type="text" name="place" maxlength="30" /></td>
 </tr>

 <td colspan="2" align="center">
   <input class='but1' type="submit"  name="send"  value="Отправить запрос" />
   <input class='but1' type="reset"  value="Очистить" />
  </td>
 </tr>
</table>
<p align=center>	<a href="meet.php">Вернуться</a></p>
</form>
<div class='formd'>
<?php
$mysqli=new mysqli("localhost","root","","kk");
$mysqli->set_charset("utf8");
if(isset($_POST['send']))
{
  if (!is_numeric($_POST["ID_meet"])) echo "Вы неверно ввели ID заседания";
  elseif (!is_numeric($_POST["ID_com"])) echo "Вы неверно ввели ID комиссии";
  else{
    $q="INSERT INTO meeting  VALUES(?, ?, ?, now())";
    $q1="INSERT INTO meet_mem VALUES(?, ?)";
    $stmt=$mysqli->prepare($q);
    $stmt1=$mysqli->prepare($q1);   
    $stmt->bind_param('iis', $ID_meet, $ID_com, $place);
    #$stmt1->bind_param('ii', $ID_meet, $ID_mem);
	  /* удаление пробелов вначале и конце и удаление тегов */
	  $ID_meet = strip_tags(trim($_POST['ID_meet'])); 
    $ID_com = strip_tags(trim($_POST['ID_com']));
    $place= strip_tags(trim($_POST['place']));

    $stmt->execute();	
    for ($i=0; $i<$_SESSION["K"]; $i++)
    {
      $stmt1->bind_param('ii', $ID_meet, $in);
      $in= strip_tags(trim($_POST[$i]));
	    $stmt1->execute();	
    }
	#$stmt1->execute();	
	
	/* закрываем запрос */
	$stmt->close();
	$stmt1->close();
	
	/* закрываем подключение */
	mysqli_close($mysqli);
}}
elseif (isset($_POST['K'])){?>
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

