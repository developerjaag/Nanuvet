<?php
header('Content-Encoding: UTF-8');
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=nanuvet.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

echo utf8_decode($_POST['envioForm']);


?>