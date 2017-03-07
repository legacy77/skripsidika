<?php
date_default_timezone_set("Asia/Jakarta");
require_once 'token.php';

// masukkan bot token di sini
define('BOT_TOKEN', $token);

// versi official telegram bot
 define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

// versi 3rd party, biar bisa tanpa https / tanpa SSL.
//define('API_URL', 'https://api.pwrtelegram.xyz/bot'.BOT_TOKEN.'/');
define('myVERSI', '0.1');
define('lastUPDATE', '10 September 2016');

// ambil databasenya
require_once 'database.php';

// aktifkan ini jika ingin menampilkan debugging poll
$debug = true;

function exec_curl_request($handle)
{
    $response = curl_exec($handle);

    if ($response === false) {
        $errno = curl_errno($handle);
        $error = curl_error($handle);
        error_log("Curl returned error $errno: $error\n");
        curl_close($handle);

        return false;
    }

    $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
    curl_close($handle);

    if ($http_code >= 500) {
        // do not wat to DDOS server if something goes wrong
    sleep(10);

        return false;
    } elseif ($http_code != 200) {
        $response = json_decode($response, true);
        error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
        if ($http_code == 401) {
            throw new Exception('Invalid access token provided');
        }

        return false;
    } else {
        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successfull: {$response['description']}\n");
        }
        $response = $response['result'];
    }

    return $response;
}

function apiRequest($method, $parameters = null)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");

        return false;
    }

    if (!$parameters) {
        $parameters = [];
    } elseif (!is_array($parameters)) {
        error_log("Parameters must be an array\n");

        return false;
    }

    foreach ($parameters as $key => &$val) {
        // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
        $val = json_encode($val);
    }
    }
    $url = API_URL.$method.'?'.http_build_query($parameters);

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

    return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");

        return false;
    }

    if (!$parameters) {
        $parameters = [];
    } elseif (!is_array($parameters)) {
        error_log("Parameters must be an array\n");

        return false;
    }

    $parameters['method'] = $method;

    $handle = curl_init(API_URL);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
    curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    return exec_curl_request($handle);
}

function sendApiAction($idchat, $action = 'typing')
{
    $method = 'sendChatAction';
    $data = [
        'chat_id' => $idchat,
        'action'  => $action,
    ];
    $result = apiRequest($method, $data);
}
function sendApiKeyboard($idchat, $text, $keyboard = [], $inline = false)
{
    $method = 'sendMessage';
    $replyMarkup = [
        'keyboard'        => $keyboard,
        'resize_keyboard' => true,
    ];
    $data = [
        'chat_id'    => $idchat,
        'text'       => $text,
        'parse_mode' => 'Markdown',
		'one_time_keyboard' => true,
		
    ];
    $inline
    ? $data['reply_markup'] = json_encode(['inline_keyboard' => $keyboard])
    : $data['reply_markup'] = json_encode($replyMarkup);
    $result = apiRequest($method, $data);
}
function editMessageText($idchat, $message_id, $text, $keyboard = [], $inline = false)
{
    $method = 'editMessageText';
    $replyMarkup = [
        'keyboard'        => $keyboard,
        'resize_keyboard' => true,
    ];
    $data = [
        'chat_id'    => $idchat,
        'message_id' => $idpesan,
        'text'       => $text,
        'parse_mode' => 'Markdown',
    ];
    $inline
    ? $data['reply_markup'] = json_encode(['inline_keyboard' => $keyboard])
    : $data['reply_markup'] = json_encode($replyMarkup);
    $result = apiRequest($method, $data);
}
function sendApiHideKeyboard($idchat, $text)
{
    $method = 'sendMessage';
    $data = [
        'chat_id'       => $idchat,
        'text'          => $text,
        'parse_mode'    => 'Markdown',
        'reply_markup'  => json_encode(['hide_keyboard' => true]),
    ];
    $result = apiRequest($method, $data);
}
function sendApiSticker($chatid, $sticker, $msg_reply_id = false)
{
    $method = 'sendSticker';
    $data = [
        'chat_id'  => $idchat,
        'sticker'  => $sticker,
    ];
    if ($msg_reply_id) {
        $data['reply_to_message_id'] = $msg_reply_id;
    }
    $result = apiRequest($method, $data);
}

// jebakan token, klo ga diisi akan mati
if (strlen(BOT_TOKEN) < 20) {
    die(PHP_EOL."-> -> Token BOT API nya mohon diisi dengan benar!\n");
}

function getUpdates($last_id = null)
{
    $params = [];
    if (!empty($last_id)) {
        $params = ['offset' => $last_id + 1, 'limit' => 1];
    }
  //echo print_r($params, true);
  return apiRequest('getUpdates', $params);
}

// matikan ini jika ingin bot berjalan
//die('baca dengan teliti yak!');



// ----------- pantengin mulai ini
function sendMessage($idpesan, $idchat, $pesan)
{
    $data = [
    'chat_id'             => $idchat,
    'text'                => $pesan,
    'parse_mode'          => 'Markdown',
    'reply_to_message_id' => $idpesan,
  ];

    return apiRequest('sendMessage', $data);
}

function processMessage($message)
{
    global $database;
    if ($GLOBALS['debug']) {
        print_r($message);
    }
	if (isset($message['callback_query']['data'])){
		$message['message']=$message['callback_query']['message'];
		$message['message']['text']=$message['callback_query']['data'];
	}
    if (isset($message['message'])) {
        $sumber = $message['message'];
        $idpesan = $sumber['message_id'];
        $idchat = $sumber['chat']['id'];

        $namamu = $sumber['from']['first_name'];
        $iduser = $sumber['from']['id'];

        if (isset($sumber['text'])) {
            $pesan = $sumber['text'];

            if (preg_match("/^\/view_(\d+)$/i", $pesan, $cocok)) {
                $pesan = "/view $cocok[1]";
            }

            if (preg_match("/^\/hapus_(\d+)$/i", $pesan, $cocok)) {
                $pesan = "/hapus $cocok[1]";
            }

     // print_r($pesan);

		
	/* $perintah = ambilcommand($message['from']['id'], $katapertama);
	$perintah = isset($perintah) ? $perintah : $katapertama;
	switch ($perintah){
	case 'pertanyaan 1':
	
  }	*/
		
		

      $pecah = explode(',', $pesan);
		$pecah2 = explode (' ',$pesan,-1);
            $katapertama = strtolower($pecah[0]);
            switch ($katapertama) {
        case '/start':
          $text = "Selamat Datang `$namamu`, Ini adalah BOT Percobaannya Andhika untuk Skripsinya..\n\nUntuk bantuan ketik: /help";
          
		  break;

        case '/help':
          $text = '💁🏼 Ini adalah BOT Pecobaan yang dibuat dengan ver.`'.myVERSI."`\n";
          $text .= "🎓 Oleh Andhika Setiawan, 23 September 2016\n";
          $text .= "💌 Berikut menu yang baru tersedia \n";
		  $text .= "/help\n";
		  $text .= "!comment\n";
          break;
		  
		 case '!help':
		  $text = "Nama saya $namamu \n";
		  $text = "Id user saya $idchat \n";
          break; 

		 case '!hide':
		 sendApiAction;
		 sendApiHideKeyboard;
		 break;
		  
        case '/time':
          $text = "⌛�� Menunjukkan :\n";
          $text .= date('d-m-Y H:i:s');
          break;

        case '/tes':
          if (isset($pecah[1])) {
              $pesanproses = $pecah[1];		 
			  
			  $r = issuetambah($iduser,$namamu, $pesanproses,$pesan);
               $text = 'Terimakasih untuk masukkannya.';
          }  else if (isset($pecah[1])){
			  $pesanproses = $pecah2[2];
			    $r = issuetambah($iduser,$namamu, $pesanproses,$pesan);
			 
		  } 
		  
		  else {
              $text = '⛔️ *ERROR:* _Pesan yang ditambahkan tidak boleh kosong!_';
              $text .= "\n\nContoh: `/comment ruang kelas ini terlalu kotor`";
          }
          break;

		  
		  
		          case '/saran':
          if (isset($pecah[1])) {
              $pesanproses = $pecah[1];
              $r = issuetambah($iduser,$namamu, $pecah);
              $text = 'Terimakasih untuk saran dan masukannya. Kami akan proses secepatnya';
          } else {
              $text = '⛔️ *ERROR:* _Pesan yang ditambahkan tidak boleh kosong!_';
              $text .= "\n\nContoh: `/saran,RUANG KELAS,KOMENTAR,NIK`";
          }
          sendApiAction($idchat);
          break;
		  
		  
		  
		  
        case '/view':
          if (isset($pecah[1])) {
              $pesanproses = $pecah[1];
              $text = diaryview($iduser, $pesanproses);
          } else {
              $text = '⛔️ *ERROR:* `nomor pesan tidak boleh kosong.`';
          }
          break;

        case '/hapus':
          if (isset($pecah[1])) {
              $pesanproses = $pecah[1];
              $text = diaryhapus($iduser, $pesanproses);
          } else {
              $text = '⛔️ *ERROR:* `nomor pesan tidak boleh kosong.`';
          }
          break;

        case '/list':
          $text = diarylist($iduser);
          if ($GLOBALS['debug']) {
              print_r($text);
          }
          break;

        case '/jadwal':
        $text = jadwallist();
        if($GLOBALS['debug']){
          print_r($text);
        }
        break;

        case '/barang':
        $text = baranglist();
        if($GLOBALS['debug']){
          print_r($text);
        }
        break;
		  
      case '/temuan':
        $text = temuanlist();
        if($GLOBALS['debug']){
          print_r($text);
        }
        break;

		 case '!keyboard':
		 $keyboard = [
		 ['!help','Lokasi'],];
		 sendApiKeyboard($idchat,$keyboard);
		 break;
		 
		 
		 case '/cari':
          // saya gunakan pregmatch ini salah satunya untuk mencegah SQL injection
          // hanya huruf dan angka saja yang akan diproses
          if (preg_match("/^\/cari ((\w| )+)$/i", $pesan, $cocok)) {
              $pesanproses = $cocok[1];
              $text = diarycari($iduser, $pesanproses);
          } else {
              $text = '⛔️ *ERROR:* `kata kunci harus berupa kata (huruf dan angka) saja.`';
          }
          break;

        default:
          $text = '😥 Maaf dilarang spaming !!';
          break;
      }
        } else {
            $text = 'Maaf ada yang salah';
        }

        $hasil = sendMessage($idpesan, $idchat, $text);
        if ($GLOBALS['debug']) {
            // hanya nampak saat metode poll dan debug = true;
      echo 'Pesan yang dikirim: '.$text.PHP_EOL;
            print_r($hasil);
        }
    }
}

// pencetakan versi dan info waktu server, berfungsi jika test hook
echo 'Ver. '.myVERSI.' OK Start!'.PHP_EOL.date('Y-m-d H:i:s').PHP_EOL;

function printUpdates($result)
{
    foreach ($result as $obj) {
        // echo $obj['message']['text'].PHP_EOL;
    processMessage($obj);
        $last_id = $obj['update_id'];
    }

    return $last_id;
}


// AKTIFKAN INI jika menggunakan metode poll
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$last_id = null;
while (true) {
    $result = getUpdates($last_id);
    if (!empty($result)) {
        echo '+';
        $last_id = printUpdates($result);
    } else {
        echo '-';
    }

    sleep(1);
}


// AKTIFKAN INI jika menggunakan metode webhook
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/*$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
  // ini jebakan jika ada yang iseng mengirim sesuatu ke hook
  // dan tidak sesuai format JSON harus ditolak!
  exit;
} else {
  // sesuai format JSON, proses pesannya
  processMessage($update);
}*/

/*

Sekian.

*/;
