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
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE nama_barang LIKE '%$cari%' ORDER BY CASE WHEN id_transaksi='251011700395' THEN 0 ELSE 1 END,CAST(id_transaksi AS UNSIGNED) ASC");
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
        <title>Data Transaksi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#eef3f9;
}
.wrapper{
    display:flex;
    min-height:100vh;
}
.sidebar{
    width:280px;
    background:linear-gradient(180deg, #0f172a, #1e3a8a, #c0c0c0);
    color:white;
    padding:25px;
}
.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    margin-bottom:8px;
}
.sidebar a:hover .sidebar .active{
    background:rgba(255,255,255,.15);
}
.main-content{
    flex:1;
    padding:30px;
}
.header-box{
    background:white;
    border-radius:20px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:25px;
}
.table-card{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}
.btn-custom{
    background:linear-gradient(135deg, #1e3a8a, #2563eb);
    color:white;
    border:none;
}
.btn-custom:hover{
    color:white;
}
.table img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:12px;
}
</style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="text-center mb-4">
                <h2><i class="bi bi-bag-check-fill"></i></h2>
                <h4>Manajemen Penjualan</h4>
            </div>
            <a href="dashboard.php">
                <i class="bi bi-grid-fill"></i>Dashboard
            </a>
            <a href="transaksi.php" class="active">
                <i class="bi bi-cart-fill"></i>Data Transaksi
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
            <div class="header-box">
                <h3 class="fw-bold">
                    <i class="bi bi-cart-fill"></i>Data Transaksi
                </h3>
                <small class="text-muted">Kelola seluruh transaksi penjualan</small>
            </div>
            <div class="table-card">
                <div class="d-flex justify-content-between mb-3">
                    <form method="GET" class="d-flex gap-2">
                        <input type="text"name="cari"class="form-control"placeholder="Cari Barang"value="<?= isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                        <button type="submit" class="btn btn-secondary">Cari</button>
                        <a href="dashboard.php" class="btn btn-outline-primary">Reset</a>
                    </form>
                    <a href="tambah.php"class="btn btn-custom">
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