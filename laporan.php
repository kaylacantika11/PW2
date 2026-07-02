<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";
$db = new Database();
$koneksi = $db->connect();
$filter = "";
if(isset($_GET['cari']))
{
    $cari = $_GET['cari'];
    $filter = "WHERE nama_barang LIKE '%$cari%'";
}
$query = mysqli_query(
    $koneksi,"SELECT * FROM transaksi
    $filter ORDER BY CASE WHEN id_transaksi='251011700395' THEN 0 ELSE 1 END, CAST(id_transaksi AS UNSIGNED) ASC"
);
$data = [];
while($row = mysqli_fetch_assoc($query))
{
    $data[] = $row;
}
$total_transaksi = count($data);
$total_pendapatan = 0;
foreach($data as $d)
{
    $total_pendapatan += $d['total'];
}
if(isset($_GET['excel']))
{
    header("Content-Type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=laporan.xls");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Transaksi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background:#eef4ff;
    font-family:'Segoe UI';
}
.header{
    background:linear-gradient(135deg,#2563eb,#60a5fa,#c0c0c0);
    color:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
}
.card-stat{
    border:none;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}
.table{
    background:white;
}
.btn-biru{
    background:#2563eb;
    color:white;
}
.btn-biru:hover{
    background:#1d4ed8;
    color:white;
}
</style>
</head>
<body>
<div class="container mt-4">
    <div class="header">
        <h2>Laporan Transaksi Penjualan</h2>
        <p class="mb-0">Sistem Manajemen Penjualan</p>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-stat p-3">
                <h5>Total Transaksi</h5>
                <h2><?= $total_transaksi ?></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stat p-3">
                <h5>Total Pendapatan</h5>
                <h2>Rp <?= number_format($total_pendapatan,0,",",".") ?></h2>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <form method="GET" class="d-flex gap-2">
                    <input type="text"name="cari"class="form-control"placeholder="Cari Barang"value="<?= isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                    <button type="submit" class="btn btn-secondary">Cari</button>
                    <a href="laporan.php" class="btn btn-outline-primary">Reset</a>
                </form>
                <div>
                    <a href="export_excel.php" class="btn btn-success">Export Excel</a>
                    <a href="export_pdf.php" class="btn btn-danger">Export PDF</a>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
<?php if(count($data) > 0): ?>
<?php $no = 1; ?>
<?php foreach($data as $row): ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['id_transaksi']; ?></td>
    <td class="text-center">
        <img src="../uploads/<?= $row['gambar']; ?>"width="70"height="70"style="object-fit:cover;border-radius:10px;border:1px solid #ddd;">
    </td>
    <td><?= $row['nama_barang']; ?></td>
    <td>Rp <?= number_format($row['harga'],0,",","."); ?></td>
    <td><?= $row['jumlah']; ?></td>
    <td>Rp <?= number_format($row['total'],0,",","."); ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7" class="text-center py-4">
        <b>Data barang tidak ditemukan.</b>
    </td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
</body>
</html>