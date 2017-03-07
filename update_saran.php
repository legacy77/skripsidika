<?php 
include 'config.php';
$id=$_POST['no'];
$saran=$_POST['pesan2'];
$ruangan=$_POST['pesan'];
$tindakan=$_POST['tindakan'];


$sql=mysql_query("update bot set pesan2='$saran', pesan='$ruangan', tindakan='$tindakan', status='1' where no='$id'");

if ($sql==true){
$message = '<div class="alert alert-success" role="alert">Success</div>';
}
else
{
echo ''.mysql_error();
}

header("location:index.php");
?>