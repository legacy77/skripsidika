<?php include 'header.php';	?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Penjadwalan Perbaikan</h3>
<div class="col-md-12">
	<a style="margin-bottom:10px" href="sendmail.php"  class="btn btn-default pull-right"><span class='glyphicon glyphicon-envelope'></span>  Email</a>
	<a style="margin-bottom:10px" href="jadwal_planning.php"  class="btn btn-default pull-right"><span class='glyphicon glyphicon-calendar'></span>  Planning</a>
</div>


<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-pencil"></span>  Entry</button>
<form action="" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
		<select type="submit" name="startdate" class="form-control" onchange="this.form.submit()">
			<option>Pilih tanggal ..</option>
			<?php 
			$pil=mysql_query("select distinct startdate from calendar order by startdate desc");
			while($p=mysql_fetch_array($pil)){
				?>
				<option><?php echo $p['startdate'] ?></option>
				<?php
			}
			?>			
		</select>
	</div>

</form>
<br/>
<?php 
if(isset($_GET['startdate'])){
	$startdate=mysql_real_escape_string($_GET['startdate']);
	$tg="penjadwalan.php?startdate='$startdate'";
	?><?php
}else{
	$tg="penjadwalan.php";
}
?>

<br/>
<?php 
if(isset($_GET['startdate'])){
	echo "<h4> Data Kegiatan Tanggal  <a style='color:blue'> ". $_GET['startdate']."</a></h4>";
}
?>
<table class="table">
	<tr>
		<th>No</th>
		<th>Kegiatan</th>
		<th>Ruangan</th>
		<th>Tanggal Mulai</th>
		<th>Tanggal Selesai</th>			
		<th>Opsi</th>
	</tr>
	<?php 
	if(isset($_GET['startdate'])){
		$tanggal=mysql_real_escape_string($_GET['startdate']);
		$brg=mysql_query("select * from calendar where startdate like '$tanggal' order by startdate desc");
	}else{
		$brg=mysql_query("select * from calendar order by startdate desc");
	}
	$no=1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr align="center">
			<td><?php echo $no++ ?></td>
			<td><?php echo $b['title'] ?></td>
			<td><?php echo $b['ruangan_perbaikan']?></td>
			<td><?php echo $b['startdate'] ?></td>
			<td><?php echo $b['enddate']?></td>
			<td>		
				<!--<a href="edit_laku.php?id=<?php echo $b['id']; ?>" class="btn btn-warning">Edit</a>-->
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_jadwal.php?id=<?php echo $b['id']; ?>' }" class="btn btn-danger">Hapus</a>
			</td>
			
		</tr>

		<?php 
	}
	?>
</table>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Atur Jadwal
				</div>
				<div class="modal-body">				
					<form action="penjadwalan_act.php" method="post">
						<div class="form-group">
							<label>Title</label>
							<input name="title" type="text" class="form-control" autocomplete="off" required="true">
						</div>	
						<div class="modal-body">
						<form action="tmb_saran_act.php" method="post">
					<div class="form-group">
						<label>Barang</label>
						<select name="id_barang" class="form-control">
						<option>--Pilih Barang--</option>
							<?php 
							$pil=mysql_query("select id, nama_barang from barang order by nama_barang asc ");
							while($p=mysql_fetch_array($pil)){
								?>
								<option value="<?php echo $p['id'] ?>"><?php echo $p['nama_barang'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
				<form action="tmb_saran_act.php" method="post">
					<div class="form-group">
						<label>Ruangan</label>
						<select name="ruangan_perbaikan" class="form-control">
						<option>--Pilih Lokasi--</option>
							<?php 
							$pil=mysql_query("select id, nama_ruangan from ruangan order by nama_ruangan asc");
							while($p=mysql_fetch_array($pil)){
								?>
								<option value="<?php echo $p['nama_ruangan'] ?>"><?php echo $p['nama_ruangan'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
						<div class="form-group">
							<label>Tanggal Mulai</label>
							<input name="startdate" type="text" class="form-control" autocomplete="off" required="true" id="startdate">
						</div>
						<div class="form-group">
							<label>Tanggal selesai</label>
							<input name="enddate" type="text" class="form-control" autocomplete="off" required="true" id="enddate">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input type="reset" class="btn btn-danger" value="Reset">												
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#startdate").datepicker({dateFormat : 'yy/mm/dd'});							
		});
	</script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#enddate").datepicker({dateFormat : 'yy/mm/dd'});							
		});
	</script>

	<?php include 'footer.php'; ?>