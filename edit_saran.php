<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Tindakan</h3>
<a class="btn" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
$id_brg=mysql_real_escape_string($_GET['no']);
$det=mysql_query("select * from bot where no='$id_brg'")or die(mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="update_saran.php" method="post">
		<table class="table">
			<tr>
				<td></td>
				<td><input type="hidden" name="no" value="<?php echo $d['no'] ?>"></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td><input type="text" class="form-control" name="nama" value="<?php echo $d['nama'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Saran / Masukkan</td>
				<td><input type="text" class="form-control" name="pesan2" value="<?php echo $d['pesan2'] ?>" readonly></td>
			</tr>
			
			<tr>
				<td>Lokasi</td>
				<td>
					<input type="text" class="form-control" name="pesan" value="<?php echo $d['pesan']?>" readonly>
				</td>
			</tr>
			<tr>
			<tr>
				<td>Tanggal Saran/Masukkan</td>
				<td>
					<input type="text" class="form-control" name="tanggal" value="<?php echo $d['tanggal']?>" readonly>
				</td>
			</tr>
			<tr>
			<tr>
				<td>Action</td>
				<td>
					<input type="text" class="form-control" name="tindakan" value="<?php echo $d['tindakan']?>">
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="btn btn-info" value="Simpan"></td>
			</tr>
		</table>
	</form>
	<?php 
}
?>
<?php include 'footer.php'; ?>