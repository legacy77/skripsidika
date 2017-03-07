<!DOCTYPE html>
<html>
<head>
	<title>SISTEM INFOMASI MANAJEMEN</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/js/jquery-ui/jquery-ui.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
	<?php include 'admin/config.php'; ?>
	<style type="text/css">
	.kotak{	
		margin-top: 150px;
	}

	.kotak .input-group{
		margin-bottom: 20px;
	}
	</style>
</head>
<body>	
	<div class="container">
		<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan'] == "gagal"){
				echo "<div style='margin-bottom:-55px' class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign'></span>  Login Gagal !! Username dan Password Salah !!</div>";
			}

		}
		?>
		<div class="panel panel-default">
			<form action="login_act.php" method="post">
				<div class="col-md-4 col-md-offset-4 kotak">
					<h3>Silahkan Login ..</h3>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" placeholder="Username" name="uname" required="false">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" class="form-control" placeholder="Password" name="pass" required="false">
					</div>
					<div class="input-group">			
						<input type="submit" class="btn btn-primary" value="Login">	
					</div>
					<a style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-3">Sign Up</a>
				</div>
			</form>

		</div>
	</div>
</body>
</html>


<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Daftar Baru</h4>
			</div>
			<div class="modal-body">
				<form action="baru_act.php" method="post">
					<div class="form-group">
						<label>User Name</label>
						<input name="uname" type="text" class="form-control" placeholder="username" required="true">
					</div>

					<div class="form-group">
						<label>NIM / NIK</label>
						<input name="nomor_induk" type="text" class="form-control" placeholder="NIM/NIK" required="true">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input name="pass"  class="form-control" placeholder="password" required="true" type="password" required="true">
					</div>
					
					<div class="form-group">
						<label>Ulangi Password</label>
						<input name="ulang"  class="form-control" placeholder="password" required="true" type="password" required="true">
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