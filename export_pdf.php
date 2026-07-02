<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("Location: login.php");
    exit;
}
require("../fpdf186/fpdf.php");
require_once "../config/database.php";
$db = new Database();
$koneksi = $db->connect();
$query = mysqli_query($koneksi," SELECT * FROM transaksi ORDER BY CASE WHEN id_transaksi='251011700395' THEN 0 ELSE 1 END,CAST(id_transaksi AS UNSIGNED) ASC");
$pdf = new FPDF("L","mm","A4");
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(0,10,"LAPORAN TRANSAKSI PENJUALAN",0,1,"C");
$pdf->SetFont("Arial","",11);
$pdf->Cell(0,7,"Universitas Pamulang",0,1,"C");
$pdf->Cell(0,7,"Sistem Informasi Penjualan",0,1,"C");
$pdf->Ln(5);
$pdf->SetFont("Arial","B",10);
$pdf->Cell(15,10,"No",1,0,"C");
$pdf->Cell(35,10,"ID",1,0,"C");
$pdf->Cell(70,10,"Nama Barang",1,0,"C");
$pdf->Cell(40,10,"Harga",1,0,"C");
$pdf->Cell(25,10,"Jumlah",1,0,"C");
$pdf->Cell(45,10,"Total",1,1,"C");
$pdf->SetFont("Arial","",10);
$no = 1;
while($row = mysqli_fetch_assoc($query))
{
    $pdf->Cell(15,10,$no++,1,0,"C");
    $pdf->Cell(35,10,$row['id_transaksi'],1,0);
    $pdf->Cell(70,10,$row['nama_barang'],1,0);
    $pdf->Cell(40,10,"Rp ".number_format($row['harga'],0,",","."),1,0);
    $pdf->Cell(25,10,$row['jumlah'],1,0,"C");
    $pdf->Cell(45,10,"Rp ".number_format($row['total'],0,",","."),1,1);
}
$pdf->Output("I","Laporan_Transaksi.pdf");
?>