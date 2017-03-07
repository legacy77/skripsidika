<?php 
include 'header.php';
?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Detail Ruangan</h3>
<a class="btn" href="ruangan.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>

<?php
$id_brg=mysql_real_escape_string($_GET['id']);


$det=mysql_query("select * from ruangan where id='$id_brg'")or die(mysql_error());
while($d=mysql_fetch_array($det)){
	?>					
	<table class="table">
		<tr>
			<td>Ruangan</td>
			<td><?php echo $d['nama_ruangan'] ?></td>
		</tr>
		
	</table>
	<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from barang where id_ruangan='$id_brg'");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>
<div class="col-md-12">
	
	
	<a style="margin-bottom:10px" href="lap_det_ruangan.php?id=<?php echo $d['id'];?>" target="_blank" class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span>  Cetak</a>
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
		<th class="col-md-2">Nama Barang</th>
		<th class="=col-md-1">Jenis Barang</th>
		<th class="col-md-1">Jumlah</th>
		
	</tr>
	<?php 
	if(isset($_GET['cari'])){
		$cari=mysql_real_escape_string($_GET['cari']);
		$brg=mysql_query("select * from barang where id_ruangan='$id_brg' and (nama_barang like '$cari' or jenis like '$cari')");
	}else{
		$brg=mysql_query("select * from barang join jenis_barang on barang.id_jenis = jenis_barang.id where id_ruangan='$id_brg' limit $start, $per_hal");
	}
	$no=1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $b['nama_barang'] ?></td>
			<td><?php echo $b['nama_jenis']?></td>
			<td><?php echo $b['jumlah'] ?></td>
			
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
	<?php 
}
?>
<?php include 'footer.php'; ?>