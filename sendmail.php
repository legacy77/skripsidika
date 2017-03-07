<?php include'header.php';

$email = $_POST['email'];
if(isset($_GET['pesan'])){
	$pesan=mysql_real_escape_string($_GET['pesan']);
	if($pesan=="gagal"){
		echo "<div class='alert alert-danger'>Gagal mengirim email.</div>";
	}else if($pesan=="oke"){
		echo "<div class='alert alert-success'>Email berhasil terkirim ke alamat.</div>";
	}
}
?>

<div class="mail">
	
	<h1>Kirim Email</h1>
	<form action="send_mail.php" method="post">
		
		<div>
			<label for="name">Nama</label>
			<input type="text" name="name">
		</div>

		<div>
			<label for="email">Email</label>
			<input type="text" name="email">
		</div>

		<div>
			<label for="subject">Subject</label>
			<input type="text" name="subject">
		</div>

		<div>
			<label for="message">Pesan</label>
			<textarea name="message" id="" cols="30" rows="10"></textarea>
		</div>

		<div><input type="submit" value="kirim email"></div>

	</form>
	
</div>

<?php include'footer.php';?>