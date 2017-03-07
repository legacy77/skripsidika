<?php 
include 'header.php';
?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Detail Barang</h3>
<a class="btn" href="barang.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>

<?php
$id_brg=mysql_real_escape_string($_GET['id']);


$det=mysql_query("select * from barang join ruangan on barang.id=ruangan.id   where barang.id='$id_brg' ")or die(mysql_error()); 

while($d=mysql_fetch_array($det)){
	?>					
	<table class="table">
		<tr>
			<td>Nama</td>
			<td><?php echo $d['nama_barang'] ?></td>
		</tr>
		
		<tr>
			<td>Suplier</td>
			<td><?php echo $d['supplier'] ?></td>
		</tr>
		
		<tr>
			<td>Jumlah</td>
			<td><?php echo $d['jumlah'] ?></td>
		</tr>
		
		<tr>
			<td>Lokasi</td>
			<td><?php echo $d['nama_ruangan'] ?></td>
		</tr>
	</table>
	<?php 
}
?>
<?php include 'footer.php'; ?>