<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";
if(isset($_POST['simpan']))
{
    if(empty($_POST['id']) ||
       empty($_POST['barang']) ||
       empty($_POST['harga']) ||
       empty($_POST['jumlah']))
    {
        echo "<script>alert('Semua data harus diisi!');history.back();</script>";
        exit;
    }
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
    $namaFile = $_FILES['gambar']['name'];
    $tmpFile  = $_FILES['gambar']['tmp_name'];
    $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];
if(!in_array($ekstensi,$allowed))
{
    echo "<script>alert('File harus JPG, JPEG atau PNG!');history.back();</script>";
    exit;
}
move_uploaded_file($tmpFile,"../uploads/".$namaFile);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Transaksi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#1e3a8a,#2563eb,#c0c0c0);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}
.card-form{
    width:100%;
    max-width:420px;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}
.card-header{
    background:linear-gradient(135deg,#1e3a8a,#2563eb,#c0c0c0);
    color:#fff;
    text-align:center;
    padding:18px;
}
.card-header h2{
    font-size:24px;
    margin:5px 0;
}
.card-header p{
    margin:0;
    font-size:14px;
}
.card-body{
    padding:20px;
}
.form-control{
    height:42px;
    border-radius:10px;
}
.btn-primary{
    width:100%;
    height:48px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#1e3a8a,#2563eb);
}
.btn-secondary{
    width:100%;
    height:48px;
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    font-style:normal;
    font-weight:600;
}
.preview{
    width:90px;
    height:90px;
    display:none;
    object-fit:cover;
    border-radius:10px;
    margin:auto;
}
.card-header i{
    font-size:35px;
}
.card-header h2{
    font-size:28px;
    margin-top:10px;
}
.card-header p{
    margin:0;
    font-size:15px;
}
</style>
</head>
<body>
<div class="card-form">
    <div class="card-header">
        <h1><i class="bi bi-plus-circle-fill"></i></h1>
        <h2>Tambah Data Transaksi</h2>
        <p>Input Produk Baru</p>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">ID Transaksi</label>
                <inputtype="number"name="id"class="form-control"required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text"name="barang"class="form-control"required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number"name="harga"class="form-control"required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number"name="jumlah"class="form-control"required>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Produk</label>
                <input type="file"name="gambar"class="form-control"accept="image/*"onchange="previewImage(event)"required>
            </div>
            <div class="text-center mb-4">
                <img id="preview"class="preview">
            </div>
            <div class="d-grid gap-2">
                <button type="submit"name="simpan"class="btn btn-primary">
                <i class="bi bi-save-fill"></i>Simpan Data
                </button>
                <a href="dashboard.php"class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
<script>
function previewImage(event)
{
    const image = document.getElementById('preview');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.style.display='block';
}
</script>
</body>
</html>