<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require_once "../model/transaksi.php";
$transaksi = new Transaksi(); 
$id = $_GET['id'];
$data = $transaksi->edit($id);
if(isset($_POST['update']))
{
    if($_POST['harga'] <= 0)
    {
        echo "<script>alert('Harga harus lebih dari 0!');history.back();</script>";
        exit;
    }
    if($_POST['jumlah'] <= 0)
    {
        echo "<script>alert('Jumlah harus lebih dari 0!');history.back();</script>";
        exit;
    }
    $total_baru = $_POST['harga'] * $_POST['jumlah'];
    $gambar = $data['gambar'];
    if($_FILES['gambar']['name'] != "")
    {
        $gambar = $_FILES['gambar']['name'];
        $ekstensi = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];
        if(!in_array($ekstensi, $allowed))
        {
            echo "<script>alert('File harus JPG, JPEG atau PNG!');history.back();</script>";
            exit;
        }
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/".$gambar);
    }
    $transaksi->update(
        $_POST['id'],
        $_POST['barang'],
        $_POST['harga'],
        $_POST['jumlah'],
        $total_baru,
        $gambar
    );
    header("Location: transaksi.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Transaksi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    margin:0;
    padding:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#0f172a,#1e3a8a,#c0c0c0);
    min-height:100vh;
}
.container-box{
    max-width:700px;
    margin:40px auto;
}
.card-custom{
    background:white;
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.2);
}
.card-header{
    background:linear-gradient(135deg,#2563eb,#60a5fa,#c0c0c0);
    color:white;
    text-align:center;
    padding:30px;
}
.card-header h2{
    margin:0;
    font-weight:bold;
}
.card-body{
    padding:35px;
}
.form-label{
    font-weight:600;
    color:#334155;
}
.form-control{
    border-radius:12px;
    padding:12px;
}
.form-control:focus{
    box-shadow:0 0 10px rgba(37,99,235,.3);
    border-color:#2563eb;
}
.btn-update{
    background:linear-gradient(135deg,#2563eb,#60a5fa);
    border:none;
    color:white;
    padding:12px;
    border-radius:12px;
    font-weight:bold;
    width:100%;
}
.btn-update:hover{
    opacity:.9;
}
.preview{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:15px;
    border:3px solid #e2e8f0;
}
.btn-kembali{
    text-decoration:none;
    display:inline-block;
    margin-bottom:20px;
    color:white;
    font-weight:bold;
}
</style>
</head>
<body>
<div class="container-box">
    <a href="transaksi.php" class="btn-kembali">← Kembali</a>
    <div class="card-custom">
        <div class="card-header">
            <h2>Edit Transaksi</h2>
            <p class="mb-0">Ubah Data Barang</p>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">ID Transaksi</label>
                    <input type="number"name="id"class="form-control"value="<?= $data['id_transaksi']; ?>"readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text"name="barang"class="form-control"value="<?= $data['nama_barang']; ?>"required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number"name="harga"class="form-control"value="<?= $data['harga']; ?>"required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number"name="jumlah"class="form-control"value="<?= $data['jumlah']; ?>"required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" name="total" class="form-control" value="<?= $data['total']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Saat</label>
                    <br>
                    <img src="../uploads/<?= $data['gambar']; ?>"class="preview">
                </div>
                <div class="mb-4">
                    <label class="form-label">Ganti Foto Produk</label>
                    <input type="file"name="gambar"class="form-control">
                </div>
                <button type="submit"name="update"class="btn-update">Update Data</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>