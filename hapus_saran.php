<?php 
include 'config.php';
$id=$_GET['id'];
mysql_query("delete from bot where no ='$id'");
header("location:index.php");

?>