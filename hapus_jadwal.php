<?php 
include 'config.php';
$id=$_GET['id'];
mysql_query("delete from calendar where id='$id'");
header("location:penjadwalan.php");

?>