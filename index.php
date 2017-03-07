<?php include 'header.php'; ?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Saran Masuk</h3>
<br/>
<br/>


<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from bot");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>
<div class="col-md-12">
	<table class="col-md-2">
		<tr>
			<td>Jumlah Record</td>		
			<td><?php echo $jum; ?></td>
		</tr>
		<tr>
			<td>Jumlah Halaman</td>	
			<td><?php echo $halaman; ?></td>
		</tr>
	</table>
</div>
<form action="" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
		<select type="submit" name="tanggal" class="form-control" onchange="this.form.submit()">
			<option>Pilih tanggal ..</option>
			<?php 
			$pil=mysql_query("select distinct tanggal from bot order by tanggal desc");
			while($p=mysql_fetch_array($pil)){
				?>
				<option><?php echo $p['tanggal'] ?></option>
				<?php
			}
			?>			
		</select>
	</div>

</form>
<br/>
<table class="table table-hover">
	<tr>
		<th class="col-md-1">No</th>
		<th class="col-md-1">NIP/NIK</th>
		<th class="col-md-1">Nama Pengirim</th>
		<th class="col-md-1">Waktu</th>
		<th class="col-md-1">Tanggal</th>
		<th class="col-md-1">Ruangan</th>
		<th class="col-md-3">Pesan</th>
		<!-- <th class="col-md-1">Sisa</th>		 -->
		<th class="col-md-1">Opsi</th>
		<th class="col-md-1">Status</th>
	</tr>
	<?php 
	if(isset($_GET['carirk'])){
		$cari=mysql_real_escape_string($_GET['carirk']);
		$brg=mysql_query("select * from bot where pesan like '$carirk'");
	}else{
		$brg=mysql_query("select * from bot join admin on bot.id_induk = admin.nomor_induk order by tanggal desc limit $start, $per_hal "); /* Data yg muncul hanya yg sudah verifikasi */
	}
	$no=1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $b['nomor_induk']?></td>
			<td><?php echo $b['nama'] ?></td>
			<td><?php echo $b['waktu'] ?></td>
			<td><?php echo $b['tanggal']?></td>
			<td><?php echo $b['pesan']?></td>
			<td><?php echo $b['pesan2']?></td>
			<td>
				<!--<a href="det_barang.php?id=<?php echo $b['no']; ?>" class="btn btn-info">Detail</a>
				<a href="edit.php?id=<?php echo $b['no']; ?>" class="btn btn-warning">Edit</a> -->
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_saran.php?id=<?php echo $b['no']; ?>' }" class="btn btn-danger">Hapus</a>
			</td>
			<td><a 	href="<?php if($b['status']=='0'){?> edit_saran.php?no=<?php echo $b['no'];?> <?php } ?> "
					class="<?php if($b['status']=='0'){?>btn btn-warning <?php } else{?> btn btn-primary <?php } ?> " ><?php if($b['status']=='0'){?> Submitted <?php } else{?> Done  <?php } ?>			 
			</a>
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
						<label>Nama Barang</label>
						<input name="nama_barang" type="text" class="form-control" placeholder="Nama Barang ..">
					</div>
					<div class="form-group">
						<label>Jenis</label>
						<input name="jenis" type="text" class="form-control" placeholder="Jenis Barang ..">
					</div>
					<div class="form-group">
						<label>Suplier</label>
						<input name="suplier" type="text" class="form-control" placeholder="Suplier ..">
					</div>
					<div class="form-group">
						<label>Jumlah</label>
						<input name="jumlah" type="text" class="form-control" placeholder="Jumlah">
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