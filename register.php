<?php
require_once "../config/database.php";
if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);
    if(empty($username) || empty($password) || empty($confirm))
    {
        echo "<script>alert('Semua data harus diisi!');</script>";
    }
    elseif($password != $confirm)
    {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
    }
    else
    {
        $user = new User();
        if($user->register($username,$password))
        {
            echo "<script>alert('Registrasi berhasil!');window.location='login.php';</script>";
        }
        else
        {
            echo "<script>alert('Registrasi gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Sistem Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg, #0f172a, #1e3a8a, #c0c0c0);
}
.register-container{
    width:1000px;
    max-width:95%;
    background:white;
    border-radius:30px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
    display:flex;
}
.left-side{
    width:50%;
    background:linear-gradient(180deg, #1e3a8a, #2563eb, #c0c0c0);
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    padding:50px;
}
.left-side h1{
    font-size:70px;
}
.left-side h2{
    margin-top:15px;
    font-weight:bold;
}
.left-side p{
    text-align:center;
    opacity:.9;
}
.right-side{
    width:50%;
    padding:50px;
}
.form-register h3{
    color:#1e3a8a;
    font-weight:700;
    margin-bottom:5px;
}
.form-register p{
    color:#777;
    margin-bottom:25px;
}
.input-group-custom{
    margin-bottom:18px;
}
.input-group-custom label{
    display:block;
    margin-bottom:5px;
    font-weight:600;
}
.input-custom{
    width:100%;
    padding:13px;
    border:1px solid #d1d5db;
    border-radius:12px;
    transition:.3s;
}
.input-custom:focus{
    outline:none;
    border-color:#2563eb;
    box-shadow:0 0 10px rgba(37,99,235,.2);
}
.btn-register{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    color:white;
    font-weight:600;
    background:linear-gradient(135deg, #1e3a8a, #2563eb);
    transition:.3s;
}
.btn-register:hover{
    transform:translateY(-2px);
}
.login-link{
    text-align:center;
    margin-top:20px;
}
.login-link a{
    text-decoration:none;
    color:#2563eb;
    font-weight:600;
}
.footer-register{
    text-align:center;
    margin-top:20px;
    color:#999;
    font-size:13px;
}
@media(max-width:768px){
.register-container{
    flex-direction:column;
}
.left-side.right-side{
    width:100%;
}
.left-side{
    min-height:250px;
}
}
</style>
</head>
<body>
<div class="register-container">
    <div class="left-side">
        <h1><i class="bi bi-person-plus-fill"></i></h1>
        <h2>Registrasi Akun</h2>
        <p>Buat akun baru untuk mengakses</p>
        <br>Sistem Manajemen Penjualan</br>
    </div>
    <div class="right-side">
        <form method="POST" class="form-register">
            <h3>Buat Akun Baru</h3>
            <p>Lengkapi data berikut untuk registrasi.</p>
            <div class="input-group-custom">
                <label>Username</label>
                <input type="text"name="username"class="input-custom"required>
            </div>
            <div class="input-group-custom">
                <label>Password</label>
                <input type="password"name="password"class="input-custom"required>
            </div>
            <div class="input-group-custom">
                <label>Konfirmasi Password</label>
                <input type="password"name="confirm_password"class="input-custom"required>
            </div>
            <button type="submit"name="register"class="btn-register">
            <i class="bi bi-person-check-fill"></i>Register
            </button>
            <div class="login-link">Sudah punya akun?
                <a href="login.php">Login</a>
            </div>
            <div class="footer-register">© 2026 Sistem Penjualan</div>
        </form>
    </div>
</div>
</body>
</html>