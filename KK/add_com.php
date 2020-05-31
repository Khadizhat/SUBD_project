<!doctype html>
<html>
<head>
<?php session_start(); if (!$_SESSION['user']) header('Location: enter.php');?>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta charset="ср1251">
</head>
<body class='formh' >
<form  method="post" action="add_com.php" >
<br><br>
<table border="1" cellpadding="0" cellspacing="0" align="center">
 <tr>
  <td colspan="2" align="center"><strong>Добавление комиссии</strong></td>
 </tr>
  <td width="200">ID комиссии:</td>
  <td><input class='inp1' type="integer" name="ID_com" maxlength="30" /></td>
 </tr>
 </tr>
  <td width="150">Название комиссии:</td>
  <td><input class='inp1' type="text " name="Name" maxlength="30" /></td>
 </tr>
 </tr>
  <td width="150">ID председателя:</td>
  <td><input class='inp1' type="integer " name="ID_mem" maxlength="30" /></td>
 </tr>
  <td colspan="2" align="center">
   <input class='but1' type="submit"  name="send"  value="Отправить запрос" />
   <input class='but1' type="reset"  value="Очистить" />
  </td>
 </tr>
</table>
<br>
<center>
<input class='but1' type='submit' name='key' value='Подсказка'>
<p>	<a href="com_sost.php">Вернуться</a></p>
</form>
<?php


$mysqli=new mysqli("localhost","root","","kk");
$mysqli->set_charset("utf8");
if(isset($_POST['send']))
{
    if (!is_numeric($_POST['ID_com'])) echo "Некорректно введен ID комиссии";
    elseif (!is_numeric($_POST['ID_mem'])) echo "Некорректно введен ID председателя";
    else{ $q="INSERT INTO commission  VALUES(?, ?)";
    $q1="INSERT INTO mem_com  VALUES(?, ?, now(),?)";
    $q2="INSERT INTO chairmen  VALUES(?, ?, now(),?)";
    $stmt=$mysqli->prepare($q);
    $stmt1=$mysqli->prepare($q1);
    $stmt2=$mysqli->prepare($q2);    
    $stmt->bind_param('is', $ID_com, $Name);
    $stmt1->bind_param('iis', $ID_mem, $ID_com, $Exit_mem);
    $stmt2->bind_param('iis', $ID_mem, $ID_com, $Exit_mem);
	/* удаление пробелов вначале и конце и удаление тегов */
	$ID_mem = strip_tags(trim($_POST['ID_mem'])); 
    $ID_com = strip_tags(trim($_POST['ID_com']));
    $Name= strip_tags(trim($_POST['Name']));
    $Exit_mem=null;
	/* выполнение подготовленного запроса */
	$stmt->execute();	
	$stmt1->execute();	
	$stmt2->execute();	
	
	/* закрываем запрос */
	$stmt->close();
	$stmt1->close();
	$stmt2->close();
	
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
    $stmt->close();
    mysqli_close($mysqli);
}
?>	
</center>
</body>


</html>

