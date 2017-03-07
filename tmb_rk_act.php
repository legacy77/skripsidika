<?php 
include 'config.php';
$nama=$_POST['nama_ruangan'];

mysql_query("insert into ruangan values('','$nama')");
header("location:ruangan.php");

 ?>