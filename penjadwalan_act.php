<?php 

include 'config.php';
$tgl=$_POST['startdate'];
$tgl2=$_POST['enddate'];
$nama=$_POST['title'];
$rk=$_POST['ruangan_perbaikan'];
$ibar=$_POST['id_barang'];

mysql_query("insert  into calendar values('','$nama','$tgl','$tgl2','false','$rk','$ibar')")or die(mysql_error());
header("location:penjadwalan.php");

?>