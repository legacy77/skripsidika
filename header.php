<!DOCTYPE html>
<html>
<head>
	<?php 
	session_start();
	include 'cek.php';
	include 'config.php';
	?>
	<title>Manajemen Ruang</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../assets/js/jquery-ui/jquery-ui.css">
	<link href="../assets/css/sb-admin.css" rel="stylesheet">
	<link href="../assets/css/mystyle.css" rel="stylesheet">
	<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="../assets/js/highcharts.js" type="text/javascript"></script>
	<script type="text/javascript" src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="../assets/js/moment.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-ui/jquery-ui.js"></script>	
	<script type="text/javascript" src="../assets/js/fullcalendar.min.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap-notify.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap-notify.min.js"></script>


<!-- DATE PICKER -->
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
<!---------------------------END ----------------->
	
<!-- STYLE EMAIL -->
<style>
	.mail{
		width: 730px;
		margin: 10px auto;
		border: 1px solid #ddd;
		padding: 10px;
	}
	.mail div{
		padding: 5px 0;
		border-bottom: 1px solid #ddd;
	}
	label{
		width: 100px;
		display: inline-block;
	}
	.bottom{
		font-size: 12px;
		text-align: right;
	}
	</style>

<!-- CHART ISSUE -->
<script>
var chart1; 
$(document).ready(function() {
 chart1 = new Highcharts.Chart({
chart: {
renderTo: 'mygraph',
type: 'column'
},   
title: {
text: 'Saran / Masukkan'

},
xAxis: {
categories: ['2016','2017']
},
yAxis: {
title: {
  text: 'Total Saran / Masukkan'
}
},
 series:             
[
<?php 
$con = mysqli_connect('localhost','root','','bot_db');
				  
$sql_total   = "SELECT COUNT(*) pesan2 FROM bot WHERE date_format(tanggal,'%Y')=2016";  
$sql_total2  = "SELECT COUNT(*) pesan2 FROM bot WHERE date_format(tanggal,'%Y')=2017";


$query_total = mysqli_query($con,$sql_total ) or die(mysql_error());
while( $data = mysqli_fetch_array( $query_total ) )
{
$total = $data['pesan2'];                 
}             

$query_total2 = mysqli_query($con,$sql_total2 ) or die(mysql_error());
while( $data2 = mysqli_fetch_array( $query_total2 ) )
{
$total2 = $data2['pesan2'];                 
} 

?>
{
 name: 'Saran / Masukkan',
 data: [<?php echo $total; ?>,<?php echo $total2;?>]
},
<?php 
?>
]
 });
  }); 
</script>

<!-- Chart 2 -->

<script>
var chart2; 
$(document).ready(function() {
 chart1 = new Highcharts.Chart({
chart: {
renderTo: 'graphdone',
type: 'column'
},   
title: {
text: 'Saran / Masukkan'

},
xAxis: {
categories: ['2016','2017']
},
yAxis: {
title: {
  text: 'Total Saran / Masukkan'
}
},
 series:             
[
<?php 
$con = mysqli_connect('localhost','root','','bot_db');
				  
$sql_total   = "SELECT COUNT(*) pesan2 FROM bot WHERE date_format(tanggal,'%Y')=2016 AND status='1'";  
$sql_total2  = "SELECT COUNT(*) pesan2 FROM bot WHERE date_format(tanggal,'%Y')=2017 AND status='1'";


$query_total = mysqli_query($con,$sql_total ) or die(mysql_error());
while( $data = mysqli_fetch_array( $query_total ) )
{
$total = $data['pesan2'];                 
}             

$query_total2 = mysqli_query($con,$sql_total2 ) or die(mysql_error());
while( $data2 = mysqli_fetch_array( $query_total2 ) )
{
$total2 = $data2['pesan2'];                 
} 

?>
{
 name: 'Saran / Masukkan',
 data: [<?php echo $total; ?>,<?php echo $total2;?>]
},
<?php 
?>
]
 });
  }); 
</script>
	

<!-- CALENDAR -->
<script>

	$(document).ready(function() {

		var zone = "05:30";  //Change this to your timezone

	$.ajax({
		url: 'process.php',
		type: 'POST', // Send post data
		data: 'type=fetch',
		async: false,
		success: function(s){
			json_events = s;
		}
	});


	var currentMousePos = {
		x: -1,
		y: -1
	};
		jQuery(document).on("mousemove", function (event) {
		currentMousePos.x = event.pageX;
		currentMousePos.y = event.pageY;
	});

		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
			events: JSON.parse(json_events),
			//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
			utc: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			droppable: true, 
			slotDuration: '00:30:00',
			eventReceive: function(event){
				var title = event.title;
				var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
				$.ajax({
					url: 'process.php',
					data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						event.id = response.eventid;
						$('#calendar').fullCalendar('updateEvent',event);
					},
					error: function(e){
						console.log(e.responseText);

					}
				});
				$('#calendar').fullCalendar('updateEvent',event);
				console.log(event);
			},
			eventDrop: function(event, delta, revertFunc) {
				var title = event.title;
				var start = event.start.format();
				var end = (event.end == null) ? start : event.end.format();
				$.ajax({
					url: 'process.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
			},
			eventClick: function(event, jsEvent, view) {
				console.log(event.id);
				  var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
				  if (title){
					  event.title = title;
					  console.log('type=changetitle&title='+title+'&eventid='+event.id);
					  $.ajax({
							url: 'process.php',
							data: 'type=changetitle&title='+title+'&eventid='+event.id,
							type: 'POST',
							dataType: 'json',
							success: function(response){	
								if(response.status == 'success')			    			
									$('#calendar').fullCalendar('updateEvent',event);
							},
							error: function(e){
								alert('Error processing your request: '+e.responseText);
							}
						});
				  }
			},
			eventResize: function(event, delta, revertFunc) {
				console.log(event);
				var title = event.title;
				var end = event.end.format();
				var start = event.start.format();
				$.ajax({
					url: 'process.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
			},
			eventDragStop: function (event, jsEvent, ui, view) {
				if (isElemOverDiv()) {
					var con = confirm('Are you sure to delete this event permanently?');
					if(con == true) {
						$.ajax({
							url: 'process.php',
							data: 'type=remove&eventid='+event.id,
							type: 'POST',
							dataType: 'json',
							success: function(response){
								console.log(response);
								if(response.status == 'success'){
									$('#calendar').fullCalendar('removeEvents');
									getFreshEvents();
								}
							},
							error: function(e){	
								alert('Error processing your request: '+e.responseText);
							}
						});
					}   
				}
			}
		});

	function getFreshEvents(){
		$.ajax({
			url: 'process.php',
			type: 'POST', // Send post data
			data: 'type=fetch',
			async: false,
			success: function(s){
				freshevents = s;
			}
		});
		$('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
	}


	function isElemOverDiv() {
		var trashEl = jQuery('#trash');

		var ofs = trashEl.offset();

		var x1 = ofs.left;
		var x2 = ofs.left + trashEl.outerWidth(true);
		var y1 = ofs.top;
		var y2 = ofs.top + trashEl.outerHeight(true);

		if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
			currentMousePos.y >= y1 && currentMousePos.y <= y2) {
			return true;
		}
		return false;
	}

	});

</script>
<style>

	#trash{
		width:32px;
		height:32px;
		float:left;
		padding-bottom: 15px;
		position: relative;
	}
		
	#wrap {
		width: 1100px;
		margin: 0 auto;
	}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		border: 1px solid #ccc;
		background: #eee;
		text-align: left;
	}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		float: right;
		width: 900px;
	}

</style>
<!-- END CALENDAR -->

</head>
<body>
	<div class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="http://www.velopsite.com" class="navbar-brand">SISTEM INFORMASI</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">				
				<ul class="nav navbar-nav navbar-right">
				<?php 
					$con = mysqli_connect('localhost','root','','bot_db');
					$badge = "SELECT COUNT(*) FROM bot where status='0'";
					$result22 = mysqli_query($con,$badge);
					$row2=mysqli_fetch_array($result22);
					$badge2 = "SELECt COUNT(*) FROM calendar WHERE datediff(startdate,now())=3";
					$hasil22 = mysqli_query($con,$badge2);
					$roww2=mysqli_fetch_array($hasil22);
					?>
					<li><a id="pesan_sedia" href="#" data-toggle="modal" data-target="#modaljadwal"><span class='glyphicon glyphicon-comment'></span>  Jadwal<span class="badge"> <?php echo   $roww2['COUNT(*)'];?></span></a></li>
					<li><a id="pesan_sedia" href="#" data-toggle="modal" data-target="#modalpesan"><span class='glyphicon glyphicon-comment'></span>  Pesan<span class="badge"><?php echo  $row2['COUNT(*)'];?></span></a></li>
					<li><a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">Hay , <?php echo $_SESSION['uname']  ?>&nbsp&nbsp<span class="glyphicon glyphicon-user"></span></a></li>
				</ul>
			</div>

		</div>
	</div>

	<!-- modal input -->
	<div id="modalpesan" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"> Notification</h4>
				</div><
				<div class="modal-body">
					<?php 
					$con = mysqli_connect('localhost','root','','bot_db');
					$sql2 = "SELECT COUNT(*) FROM bot where status='0'";
					$result2 = mysqli_query($con,$sql2);
					$row2=mysqli_fetch_array($result2);
					echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span>Terdapat  : <a href=index.php style='color:red'>".$row2['COUNT(*)']."</a> Issue yang belum terselesaikan</div>";
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>						
				</div>
				
			</div>
		</div>
	</div>

<div id="modaljadwal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"> Notification</h4>
				</div><
				<div class="modal-body">
					<?php 
					$con = mysqli_connect('localhost','root','','bot_db');
					$sql2 = "SELECT COUNT(*) From calendar WHERE datediff(startdate,now())=3";
					$result2 = mysqli_query($con,$sql2);
					$roww2=mysqli_fetch_array($result2);
					echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span>Terdapat  : <a href=penjadwalan.php style='color:red'>".$roww2['COUNT(*)']."</a> Jadwal perbaikan yang akan dikerjakan. </div>";
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>						
				</div>
				
			</div>
		</div>
	</div>



	<div class="col-md-2">
		<div class="row">
			<?php 
			$use=$_SESSION['uname'];
			$fo=mysql_query("select foto from admin where uname='$use'");
			while($f=mysql_fetch_array($fo)){
				?>				

				<div class="col-xs-6 col-md-12">
					<a class="thumbnail">
						<img class="img-responsive" src="foto/<?php echo $f['foto']; ?>"> <!--Menampilkan Foto-->
					</a>
				</div>
				<?php 	
			}
			?>		
		</div>

		<div class="row"></div>
		<ul class="nav nav-pills nav-stacked">
			<li><a href="halamanmuka.php"><span class="glyphicon glyphicon-home"></span>  Dashboard</a></li>
			<li><a href="dashboard.php"><span class="glyphicon glyphicon-user"></span>  Grafik</a></li>	
			<li><a href="index.php"><span class="glyphicon glyphicon-list"></span>  Saran / Masukan</a></li>
			<li><a href="barang.php"><span class="glyphicon glyphicon-inbox"></span>  Barang</a></li>
			<li><a href="ruangan.php"><span class="glyphicon glyphicon-calendar"></span>  Ruangan</a></li>
			<li><a href="penjadwalan.php"><span class="glyphicon glyphicon-th-list"></span>  Jadwal</a></li>
			<!--<li><a href="barang_ketinggalan.php"><span class="glyphicon glyphicon-th-list"></span>  Barang Ketinggalan</a></li>-->     												
			<li><a href="ganti_foto.php"><span class="glyphicon glyphicon-picture"></span>  Ganti Foto</a></li>
			<li><a href="ganti_pass.php"><span class="glyphicon glyphicon-lock"></span> Ganti Password</a></li>
			<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>  Logout</a></li>			
		</ul>
	</div>
	<div class="col-md-10">