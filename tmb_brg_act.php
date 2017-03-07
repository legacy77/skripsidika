<?php 
include 'config.php';
$barang=$_POST['nama_barang'];
$jenis=$_POST['jenis'];
$supplier=$_POST['supplier'];
$jumlah=$_POST['jumlah'];
$lokasi=$_POST['lokasi'];


mysql_query("insert into barang values('','$barang','$supplier','$jumlah','$lokasi','$jenis')") or die(mysql_error());
header("location:barang.php");

 ?>