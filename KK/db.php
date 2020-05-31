<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
# Процедурный стиль
$connection =  mysqli_connect("localhost","root","","kk");
mysqli_set_charset($connection, "utf8");

/* проверка подключения */
if (!$connection){
	printf("Connect failed: %s\n", mysqli_connect_errno());
	exit();
}



?>