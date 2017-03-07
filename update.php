<?php 
include 'config.php';
$id=$_POST['id'];
$nama=$_POST['nama_barang'];
$jenis=$_POST['jenis'];
$suplier=$_POST['suplier'];
$jumlah=$_POST['jumlah'];
$lokasi=$_POST['lokasi'];

mysql_query("update barang set jumlah='$jumlah', id_ruangan='$lokasi' where id='$id'");
header("location:barang.php");

?>