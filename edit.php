<?php 
include 'header.php';
?>
<h3><span class="glyphicon glyphicon-briefcase"></span>  Edit Barang</h3>
<a class="btn" href="barang.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<?php
$id_brg=mysql_real_escape_string($_GET['id']);
$det=mysql_query("select * from barang  where barang.id='$id_brg'")or die(mysql_error());
while($d=mysql_fetch_array($det)){
?>					
	<form action="update.php" method="post">
		<table class="table">
			<tr>
				<td></td>
				<td><input type="hidden" name="id" value="<?php echo $d['id'] ?>"></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td><input type="text" class="form-control" name="nama_barang" value="<?php echo $d['nama_barang'] ?>" readonly ></td>
			</tr>
			<tr>
				<td>Jenis</td>
				<td><input type="text" class="form-control" name="jenis_barang" value="<?php echo $d['id_jenis'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Suplier</td>
				<td><input type="text" class="form-control" name="suplier" value="<?php echo $d['supplier'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Jumlah</td>
				<td><input type="text" class="form-control" name="jumlah" value="<?php echo $d['jumlah'] ?>"></td>
			</tr>
			<tr>
				<td>Lokasi</td>
				<td>
				<select name="lokasi" class="form-control" >
						<option>--Pilih Lokasi--</option>
							<?php 
							$pil=mysql_query("select id, nama_ruangan from ruangan");
							while($p=mysql_fetch_array($pil)){
								?>
								<option <?php if($d['id_ruangan'] == $p['id']){ echo 'selected'; } ?> value="<?php echo $p['id'] ?>"><?php echo $p['nama_ruangan'] ?></option>
								<?php
							}
							?>
						</select>
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