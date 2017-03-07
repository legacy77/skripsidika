<?php
include 'config.php';
require('./../assets/pdf/fpdf.php');

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$pdf->SetX(4);            
$pdf->MultiCell(19.5,0.5,'INVENTORY BARANG',0,'L');
$pdf->SetX(4);   
$pdf->SetFont('Arial','B',10);
$pdf->SetX(4);
$pdf->SetX(4);
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(25.5,0.7,"PRESIDENT UNIVERSITY",0,20,'C');
$pdf->ln(1);
$pdf->Cell(25.5,0.7,"Laporan Data Barang",0,10,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Di cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Suplier', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Jenis Barang', 1, 0, 'C');
$pdf->cell(3,0.8,'Ruangan',1,0,'C');
$pdf->Cell(2, 0.8, 'jumlah', 1, 1, 'C');	
$pdf->SetFont('Arial','',10);
$no=1;
$query=mysql_query("select * from barang join jenis_barang on barang.id_jenis = jenis_barang.id join ruangan on barang.id_ruangan = ruangan.id");
while($lihat=mysql_fetch_array($query)){
	$pdf->Cell(1, 0.8, $no , 1, 0, 'C');
	$pdf->Cell(7, 0.8, $lihat['nama_barang'],1, 0, 'C');
	$pdf->Cell(4, 0.8, $lihat['supplier'],1, 0, 'C');
	$pdf->Cell(4,0.8, $lihat['nama_jenis'],1,0,'C');
	$pdf->cell(3,0.8,$lihat['nama_ruangan'],1,0,'C');
	$pdf->Cell(2, 0.8, $lihat['jumlah'], 1, 1,'C');

	$no++;
}
$pdf->ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(23,0.7,"GENERAL AFFAIR",0,10,'C');
$pdf->Output("laporan_buku.pdf","I");

?>

