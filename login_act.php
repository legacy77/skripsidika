<?php 
session_start();
include 'admin/config.php';
$uname=$_POST['uname'];
$pass=$_POST['pass'];

$pas=md5($pass);
$query=mysql_query("select * from admin where uname='$uname'and pass='$pas'")or die(mysql_error());
$data = mysql_fetch_array($query);
if($data['id']=='1') {
	$_SESSION['uname']=$uname;
	header("location:admin/halamanmuka.php");
}
elseif ($data['id']>'1') {
	$_SESSION['uname']=$uname;
	header("location:user/saran.php");
}
else{
	header("location:index.php?pesan=gagal")or die(mysql_error());
}

 ?>