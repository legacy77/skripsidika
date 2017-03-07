<?php include 'header.php'; ?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Barang</h3>
<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</button>
<br/>
<br/>
<br/>


<?php 
$periksa=mysql_query("select * from barang where jumlah <=3 and id_jenis = 1");
while($q=mysql_fetch_array($periksa)){	
	if($q['jumlah']<=3){	
		?>	
		<script>
			$(document).ready(function(){
				$('#pesan_sedia').css("color","red");
				$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
			});
		</script>
		<?php
		echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'>". $q['nama_barang']."</a> yang tersisa sudah kurang dari 3 . silahkan pesan lagi !!</div>";	
	}
}
?>
<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from barang");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>
<div class="col-md-12">
	
	
	<a style="margin-bottom:10px" href="lap_barang.php" target="_blank" class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span>  Cetak</a>
</div>
<form action="cari_act.php" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
		<input type="text" class="form-control" placeholder="Cari barang di sini .." aria-describedby="basic-addon1" name="cari">	
	</div>
</form>
<br/>
<table class="table table-hover">
	<tr>
		<th class="col-md-1">No</th>
		<th class="col-md-4">Nama Barang</th>
		<th class="col-md-4">Lokasi</th>
		<th class="col-md-1">Jumlah</th>
		
		<!-- <th class="col-md-1">Sisa</th>		 -->
		<th class="col-md-2">Opsi</th>
	</tr>
	<?php 
	if(isset($_GET['cari'])){
		$cari=mysql_real_escape_string($_GET['cari']);
		$brg=mysql_query("select * from barang join jenis_barang on barang.id_jenis = jenis_barang.id join ruangan on barang.id = ruangan.id where nama_barang like '$cari' or nama_jenis like '$cari'");
	}else{
		$brg=mysql_query("select * from barang join jenis_barang on barang.id_jenis = jenis_barang.id join ruangan on barang.id = ruangan.id limit $start, $per_hal");
	}
	$no=1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr>
			<td><center><?php echo $no++ ?></td>
			<td><center><?php echo $b['nama_barang'] ?></td>
			<td><center><?php echo $b['nama_ruangan'] ?></td>
			<td><center><?php echo $b['jumlah'] ?></td>
			
			<td ><left>
				<a href="det_barang.php?id=<?php echo $b['id']; ?>" class="btn btn-info">Detail</a>
				<a href="edit.php?id=<?php echo $b['id']; ?>" class="btn btn-warning">Edit</a>
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus.php?id=<?php echo $b['id']; ?>' }" class="btn btn-danger">Hapus</a>
			</td>
		</tr>		
		<?php 
	}
	?>
</table>
<ul class="pagination">			
			<?php 
			for($x=1;$x<=$halaman;$x++){
				?>
				<li><a href="?page=<?php echo $x ?>"><?php echo $x ?></a></li>
				<?php
			}
			?>						
		</ul>
<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Barang Baru</h4>
			</div>
			<div class="modal-body">
				<form action="tmb_brg_act.php" method="post">
					
					<div class="form-group">
						<label>Merk Barang</label>
						<input name="nama_barang" type="text" class="form-control" placeholder="Merk Barang .." required="true">
					</div>

					<div class="form-group">
						<label>Jenis</label>
						<select name="jenis" class="form-control">
						<option>--Pilih Jenis Barang--</option>
								<?php
								$pil=mysql_query("select id, nama_jenis from jenis_barang");
								while ($p=mysql_fetch_array($pil)) {
									?>
									<option value="<?php echo $p['id']?>"><?php echo $p['nama_jenis']?></option>
									<?php
								}
								?>
						</select>
					</div>
					<div class="form-group">
						<label>Suplier</label>
						<input name="supplier" type="text" class="form-control" placeholder="Supplier .." required="true">
					</div>
					<div class="form-group">
						<label>Jumlah</label>
						<input name="jumlah" type="text" class="form-control" placeholder="Jumlah ..">
					</div>
					<div class="form-group">
						<label>Lokasi Barang</label>
						<select name="lokasi" class="form-control">
						<option>--Pilih Lokasi--</option>
							<?php 
							$pil=mysql_query("select id, nama_ruangan from ruangan order by nama_ruangan asc");
							while($p=mysql_fetch_array($pil)){
								?>
								<option value="<?php echo $p['id'] ?>"><?php echo $p['nama_ruangan'] ?></option>
								<?php
							}
							?>
						</select>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<input type="submit" class="btn btn-primary" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>



<?php 
include 'footer.php';

?>