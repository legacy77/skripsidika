<?php include'header.php';
$logs = mysql_query("select * from bot  order by tanggal desc limit 0,20");
$r2=mysql_query("select * from barang");
$r3=mysql_query("select * from bot");
$r4 = mysql_query("select * from admin");
$r5=mysql_query("select * FROM calendar WHERE datediff(startdate,now())=3");
$countitem=mysql_num_rows($r3);
$countuser = mysql_num_rows($r4);
$countbarang=mysql_num_rows($r2);
$countjadwal=mysql_num_rows($r5);


$periksa=mysql_query("select * FROM calendar WHERE datediff(startdate,now())=3");
while($q=mysql_fetch_array($periksa)){	
	if($periksa== true){	
		?>	
		<script>
			$(document).ready(function(){
				$('#pesan_sedia').css("color","red");
				$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
			});
		</script>
		<?php
		echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Jadwal untuk :   <a style='color:red'>". $q['title']."</a> sudah mendekati hari perbaikan . silahkan hubungi vendor !!</div>";	
	}
}
?>


 <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tint fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $countitem; ?></div>
                                        <div>Saran/Masukan!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="index.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


 <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $countuser; ?></div>
                                        <div>Users!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="user_data.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


 <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-truck fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $countbarang; ?></div>
                                        <div>Barang!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="barang.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

  <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-truck fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $countjadwal; ?></div>
                                        <div>Jadwal!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="penjadwalan.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


  <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Logs</h3>
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                                    <?php while($row = mysql_fetch_array($logs)): ?>
                                    <a href="#" class="list-group-item">
                                        <span class="badge"><?php echo $row['pesan'];?></span>
                                        <i class="fa fa-fw fa-calendar"></i>
                                        <?php echo  $row['nama'].', Menuliskan : '.$row['pesan2']; ?>
                                    </a>
                                    <?php endwhile; ?>
                                </div>
                                <div class="text-right">
                                    <a href="reports.php">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>




<?php include'footer.php';?>