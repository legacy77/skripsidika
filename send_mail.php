<?php

$name=$_POST['name'];
$email=$_POST['email'];
$subject=$_POST['subject'];
$message=$_POST['message'];

 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); date_default_timezone_set('Etc/UTC'); /*autoload phpmailer*/
  require '../assets/phpmailer/PHPMailerAutoload.php'; $mail = new PHPMailer; $mail->isSMTP();
 
/*dipakai debugging,
 * 0 = off (for production use)
 * 1 = client messages
 * 2 = client and server messages
 * */
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com'; 
/**jika kebetulan network SMTP di block lewat IPv6 maka gunakan kode ini
 * $mail->Host = gethostbyname('smtp.gmail.com');
 * */
$mail->Port = 587; //ini adalah port default mbah google
$mail->SMTPSecure = 'tls'; //security pakai ssl atau tls, tapi ssl telah deprecated
$mail->SMTPAuth = true; //menandakan butuh authentifikasi
$mail->Username = "andhikatrickster@gmail.com";//email anda
$mail->Password = "Andhikas1991"; //password anda, silakan diganti
$mail->setFrom('andhikatrickster@gmail.com', 'Andhika');
$mail->addReplyTo('andhikatrickster@gmail.com', 'Andhika');
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->msgHTML($message);
//$mail->AltBody = 'Ini Pesan yang Plain Text Beb';
//$mail->addAttachment('keluarga.xlsx');
if (!$mail->send()) {
    echo "Ada Yang Error Gan: " . $mail->ErrorInfo;

} else {
    header("location:sendmail.php?pesan=oke");
}
?>