<?php
date_default_timezone_set("Asia/Jakarta");
/*
* Ebook II: Telegram Bot PHP dan Database SQL
* oleh bang Hasan ( @hasanudinhs )
*
* Fungsi Database untuk Diary Bot Telegram
*
*/


// masukkan database framework nya
require_once 'medoo.php';

// koneksikan ke database

/* ini contoh menggunakan SQLite
    $database = new medoo([
        'database_type' => 'sqlite',
        'database_file' => 'diary.db',
    ]);
*/
// uncomment ini jika menggunakan mySQL atau mariaDB
// sesuaikan nama database, host, user, dan passwordnya

    $database = new medoo([
        'database_type' => 'mysql',
        'database_name' => 'bot_db',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ]);

    
// fungsi untuk menambah diary
function issuetambah($iduser,$namamu, $pecah)
{
    global $database;
    $last_id = $database->insert('bot', [
        'id'    => $iduser,
		'nama' => $namamu,
        'waktu' => date('H:i:s'),
		'tanggal'=> date('y-m-d'),
        'pesan' => $pecah[1],
		'pesan2' => $pecah[2],
        'id_induk'=> $pecah[3],	
    ]);

    return $last_id;
}

function issuetambah2($iduser,$namamu,$pesan)
{
    global $database;
    $last_id = $database->insert('bot', [
        'id'    => $iduser,
		'nama' => $namamu,
        'waktu' => date('H:i:s'),
		'tanggal'=> date('y-m-d'),
        
		'pesan2' => $pesan,
    ]);

    return $last_id;
}


// fungsi menghapus diary
function diaryhapus($iduser, $idpesan)
{
    global $database;
    $database->delete('bot', [
        'AND' => [
            'id' => $iduser,
            'no' => $idpesan,
        ],
    ]);

    return '⛔️ telah dilaksanakan..';
}

// fungsi melihat daftar diary user
function diarylist($iduser, $page = 0)
{
    global $database;
    $hasil = '😢 Data Tidak Ada';
    $datas = $database->select('bot', [
        'no',
        'id',
        'waktu',
        'pesan',
    ], [
        'id' => $iduser,
    ]);
    $jml = count($datas);
    if ($jml > 0) {
        $hasil = "✍ Terdapat *$jml Masukan *\n";
        $n = 0;
        foreach ($datas as $data) {
            $n++;
            $hasil .= "\n$n. ".substr($data['pesan'], 0, 10)."...\n⌛️ `$data[waktu]`\n";
            $hasil .= "\n👀 /view\_$data[no]\n";
        }
    }

    return $hasil;
}

// fungsi melihat daftar jadwal perbaikan
function jadwallist($page = 0)
{
    global $database;
    $hasil = '😢 Data Tidak Ada';
    $datas = $database->select('calendar', [
        'id',
        'title',
        'startdate',
        'enddate',
    ]);
    $jml = count($datas);
    if ($jml > 0) {
        $hasil = "Terdapat *$jml Jadwal Perbaikan *\n";
        $n = 0;
        foreach ($datas as $data) {
            $n++;
            $hasil .= "\n$n. Perbaikan : `$data[title]`\n⌛️ Tanggal Perbaikan : `$data[startdate]`\n";
        }
    }
    return $hasil;
}

// fungsi melihat daftar barang yang ada
function baranglist($page = 0)
{
    global $database;
    $hasil = '😢 Data Tidak Ada';
    $datas = $database->select('barang', [
        'id',
        'nama_barang',
        'stock',
    ]);
    $jml = count($datas);
    if ($jml > 0) {
        $hasil = "Barang yang ada di database : *$jml  *\n";
        $n = 0;
        foreach ($datas as $data) {
            $n++;
            $hasil .= "\n$n. Nama Barang : `$data[nama_barang]`\n⌛️ jumlah : `$data[stock]`\n";
        }
    }
    return $hasil;
}

// fungsi melihat daftar barang temuan
function temuanlist($page = 0)
{
    global $database;
    $hasil = 'Barang Tidak Ditemukan';
    $datas = $database->select('tb_barang_temuan', [
        'id',
        'nama_barang',
        'ruangan',
        'tanggal',
        'waktu',
    ]);
    $jml = count($datas);
    if ($jml > 0) {
        $hasil = "Barang yang telah kami temukan sejumlah : *$jml  *\n";
        $n = 0;
        foreach ($datas as $data) {
            $n++;
            $hasil .= "\n$n. Nama Barang : *`$data[nama_barang]`*\n Ruangan : `$data[ruangan]`\n Tanggal : `$data[tanggal]`\n Jam : `$data[waktu]`\n";
        }
    }
    return $hasil;
}

// fungsi melihat isi pesan diary
function diaryview($iduser, $idpesan)
{
    global $database;
    $hasil = "😢 Tidak Data";
    $datas = $database->select('bot', [
        'no',
        'id',
        'waktu',
        'pesan',
    ], [
        'AND' => [
            'id' => $iduser,
            'no' => $idpesan,
        ],
    ]);
    $jml = count($datas);
    if ($jml > 0) {
        $data = $datas[0];
        $hasil = "✍🏽 Data nomor $data[no] yang tersimpan dalam database kami berisi:\n~~~~~~~~~~~~~~~~~~~~~~~\n";
        $hasil .= "\n$data[pesan]\n\n⌛️ `$data[waktu]`";
        $hasil .= "\n\n📛 Hapus? /hapus\_$data[no]";
    }

    return $hasil;
}

// fungsi mencari pesan di diary
function diarycari($iduser, $pesan)
{
    global $database;
    $hasil = 'Maaf data yang dicari tidak tersimpan dalam database kami.';
    $datas = $database->select('bot', [
        'no',
        'id',
        'waktu',
        'pesan',
    ], [
        'pesan[~]' => $pesan,
    ]);
    $jml = count($datas);
    if ($jml > 0) {
        $hasil = "✍🏽 *$jml bot selalu tersimpan dalam database kami\n";
        $n = 0;
        foreach ($datas as $data) {
            $n++;
            $hasil .= "\n$n. ".substr($data['pesan'], 0, 10)."...\n⌛️ `$data[waktu]`\n";
            $hasil .= "\n👀 /view\_$data[no]\n";
        }
    }

    return $hasil;
}
