<?php 
include 'admin/config.php';
$user=$_POST['uname'];
$baru=$_POST['pass'];
$ulang=$_POST['ulang'];
$induk=$_POST['nomor_induk'];

if($baru==$ulang){
		$b = md5($baru);
		mysql_query("insert into admin (id,uname,pass,nomor_induk) values ('','$user','$b','$induk')");

		header("location:index.php?pesan=oke");
	}
else{
	header("location:index.php?pesan=gagal");
}

 ?>