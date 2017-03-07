<?php 
include 'config.php';
$id=$_GET['id'];
mysql_query("delete from admin where id='$id'");
header("location:user_data.php");

?>