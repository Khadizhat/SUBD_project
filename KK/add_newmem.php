<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh'>
<form  method="post" action="add_newmem.php">
<br><br>
<table border="1" cellpadding="0" cellspacing="0" align=center>
 <tr>
  <td colspan="2" align="center"><strong>Добавление члена комиссии</strong></td>
 </tr>
 <tr>
  <td width="300">ID члена комиссии:</td>
  <td><input class='inp1'  type="integer " name="ID_mem" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">ID комиссии:</td>
  <td><input class='inp1' type="integer " name="ID_com" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">Фамилия :</td>
  <td><input class='inp1' type="text" name="Surname" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">Имя :</td>
  <td><input class='inp1' type="text" name="Name" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">Отчество :</td>
  <td><input class='inp1' type="text" name="Second_name" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">Адрес :</td>
  <td><input class='inp1' type="text " name="Adress" maxlength="30" /></td>
 </tr>
 <tr>
  <td width="200">Телефон :</td>
  <td><input class='inp1' type="text " name="Telephone" maxlength="30" /></td>
 </tr>
 <tr>
  <td colspan="2" align="center">
   <input class='but1' type="submit"  name="send" value="Отправить запрос" />
   <input class='but1' type="reset" value="Очистить" />
  </td>
 </tr>
</table>
<br>
<center>
<input class='but1' type='submit' name='key' value='Подсказка'>
</form>
<p>	<a href="com_sost.php">Вернуться</a></p>
<?php

$mysqli=new mysqli("localhost","root","","kk");
$mysqli->set_charset("utf8");
if(isset($_POST['send']))
{
    if (!is_numeric($_POST['ID_mem'])) echo "Вы некорректно ввели ID члена Думы";
    elseif (!is_numeric($_POST['ID_com'])) echo "Вы некорректно ввели ID комиссии";
    else {
    $q=" INSERT INTO member VALUES(?, ?, ?, ?, ?, ?)";
    $q1= " INSERT INTO mem_com VALUES(?, ?, now(), ?)";
    $stmt=$mysqli->prepare($q);
    $stmt1=$mysqli->prepare($q1);
    $stmt->bind_param('isssss', $ID_mem, $Surname, $Name, $Second_name, $Adress, $Telephone );
    $stmt1->bind_param('iis', $ID_mem, $ID_com, $Exit_mem);
	/* удаление пробелов вначале и конце и удаление тегов */
	$ID_mem = strip_tags(trim($_POST['ID_mem'])); 
	$Surname = strip_tags(trim($_POST['Surname']));
	$Name = strip_tags(trim($_POST['Name']));
	$Second_name = strip_tags(trim($_POST['Second_name']));
    $Adress = strip_tags(trim($_POST['Adress']));
    if ($Adress=='') $Adress=null;
    $Telephone = strip_tags(trim($_POST['Telephone']));
    $ID_com = strip_tags(trim($_POST['ID_com']));
    #date_default_timezone_set('Russia/Moscow');
    $Exit_mem=null;

    /* выполнение подготовленного запроса */
    $stmt->execute();
    $stmt1->execute();	
    #printf("%d строк вставлено.\n", mysqli_stmt_affected_rows($stmt));

    /* закрываем запрос */
    $stmt->close();
    $stmt1->close();
    /* закрываем подключение */
    mysqli_close($mysqli);
}}

if (isset($_POST['key'])){?>
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
</center>
</body>
</html>

