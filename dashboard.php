<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";
include "../model/statistik.php";
$stat = new Statistik();
$total_transaksi     = $stat->totalTransaksi();
$total_pendapatan    = $stat->totalPendapatan();
$total_barang_terjual= $stat->totalBarangTerjual();
$produk_terlaris     = $stat->produkTerlaris();
$db = new Database();
$koneksi = $db->connect();
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE nama_barang LIKE '%$cari%' ORDER BY CASE WHEN id_transaksi='251011700395' THEN 0 ELSE 1 END, CAST(id_transaksi AS UNSIGNED) ASC
");
$data = [];
while($row = mysqli_fetch_assoc($query))
{
    $data[] = $row;
}
$halaman = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Segoe UI',sans-serif;
    background:#eef3f9;
}
.wrapper{
    display:flex;
    min-height:100vh;
}
.sidebar{
    width:280px;
    background:
    linear-gradient(180deg, #0f172a, #1e3a8a, #c0c0c0);
    color:white;
    padding:25px;
}
.sidebar-logo{
    text-align:center;
    margin-bottom:35px;
}
.sidebar-logo i{
    font-size:60px;
}
.sidebar-logo h4{
    margin-top:10px;
    font-weight:bold;
}
.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    margin-bottom:8px;
    transition:.3s;
}
.sidebar a:hover{
    background:rgba(255,255,255,.15);
}
.sidebar .active{
    background:rgba(255,255,255,.2);
}
.main-content{
    flex:1;
    padding:30px;
}
.header{
    background:white;
    padding:20px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:25px;
}
.header h3{
    margin:0;
    font-weight:bold;
}
.user-box{
    display:flex;
    align-items:center;
    gap:10px;
}
.user-box i{
    font-size:35px;
    color:#1e3a8a;
}
.stat-card{
    background:white;
    border-radius:20px;
    padding:25px;
    position:relative;
    overflow:hidden;
    box-shadow:
    0 5px 15px rgba(0,0,0,.08);
    transition:.3s;
}
.stat-card:hover{
    transform:translateY(-5px);
}
.stat-card h2{
    font-weight:bold;
}
.stat-card i{
    position:absolute;
    right:20px;
    bottom:15px;
    font-size:55px;
    opacity:.15;
}
.blue{
    border-left:6px solid #2563eb;
}
.silver{
    border-left:6px solid #9ca3af;
}
.green{
    border-left:6px solid #16a34a;
}
.orange{
    border-left:6px solid #ea580c;
}
.card-table{
    background:white;
    border-radius:20px;
    padding:25px;
    margin-top:25px;
    box-shadow:
    0 5px 15px rgba(0,0,0,.08);
}
.btn-primary-custom{
    background:
    linear-gradient( 135deg, #1e3a8a, #2563eb);
    border:none;
}
.table img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:10px;
}
</style>
</head>

<body>
<div class="wrapper">
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="bi bi-bag-check-fill"></i>
            <h4>Manajemen Penjualan</h4>
            <p>UAS PW2</p>
        </div>
        <a href="dashboard.php" class="active">
            <i class="bi bi-grid-fill"></i>Dashboard
        </a>
        <a href="tambah.php">
            <i class="bi bi-plus-circle-fill"></i>Tambah Data
        </a>
        <a href="laporan.php">
            <i class="bi bi-file-earmark-bar-graph-fill"></i>Laporan
        </a>
        <hr>
        <a href="../logout.php">
            <i class="bi bi-box-arrow-left"></i>Logout
        </a>
    </div>
    <div class="main-content">
        <div class="header">
            <div>
                <h3>Dashboard Penjualan</h3>
                <small class="text-muted">Selamat datang di sistem transaksi penjualan</small>
            </div>
            <div class="user-box">
                <i class="bi bi-person-circle"></i>
                <b><?= $_SESSION['username']; ?></b>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-card blue">
                    <h2><?= $total_transaksi; ?></h2>
                    <p>Total Transaksi</p>
                    <i class="bi bi-cart-fill"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card silver">
                    <h2><?= $produk_terlaris; ?></h2>
                    <p>Produk Terlaris</p>
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card green">
                    <h2>Rp <?= number_format($total_pendapatan,0,',','.'); ?></h2>
                    <p>Total Pendapatan</p>
                    <i class="bi bi-cash-stack"></i>
                </div>

            </div>
            <div class="col-md-3">
                <div class="stat-card orange">
                    <h2><?= $total_barang_terjual; ?></h2>
                    <p>Barang Terjual</p>
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
        </div>
        <div class="card-table">
            <div class="d-flex justify-content-between mb-3">
                <form method="GET" class="d-flex gap-2">
                    <input type="text"name="cari"class="form-control"placeholder="Cari Barang"value="<?= isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                    <button type="submit" class="btn btn-secondary">Cari</button>
                    <a href="dashboard.php" class="btn btn-outline-primary">Reset</a>
                </form>
                <a href="tambah.php"class="btn btn-primary-custom text-white">
                    <i class="bi bi-plus-lg"></i>Tambah Data
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
<tbody>
<?php if(count($data) > 0): ?>
    <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row['id_transaksi']; ?></td>
            <td><img src="../uploads/<?= $row['gambar']; ?>"></td>
            <td><?= $row['nama_barang']; ?></td>
            <td>Rp <?= number_format($row['harga'],0,',','.'); ?></td>
            <td><?= $row['jumlah']; ?></td>
            <td>Rp <?= number_format($row['total'],0,',','.'); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_transaksi']; ?>" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i>
                </a>
                <a href="hapus.php?id=<?= $row['id_transaksi']; ?>"onclick="return confirm('Yakin hapus data?')"class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7" class="text-center py-4 text-muted">
        <i class="bi bi-search fs-3 d-block mb-2"></i>
        <b>Data barang tidak ditemukan.</b>
    </td>
</tr>

<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</body>
</html>