<?php
session_start();
require_once "../config/database.php";
require_once "../model/User.php";

if(isset($_POST['login']))
{
    $user = new User();
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if($user->login($username, $password))
    {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    }
    else
    {
        echo "<script>alert('Username atau Password Salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
        body{ 
            min-height:100vh; display:flex; justify-content:center; align-items:center; 
            background:linear-gradient(135deg, #0f172a, #1e3a8a, #94a3b8); padding: 20px;
        }
        .login-container{ 
            width:950px; max-width:100%; min-height:550px; background:white; 
            border-radius:30px; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,.25); display:flex; 
        }
        .left-side{ 
            width:50%; background:linear-gradient(180deg, #1e3a8a, #2563eb); 
            color:white; display:flex; flex-direction:column; justify-content:center; 
            align-items:center; padding:50px; text-align: center;
        }
        .left-side h1{ font-size:70px; margin-bottom: 20px; }
        .left-side h2{ font-weight:700; margin-bottom: 10px; }
        .left-side p{ opacity:.9; margin-bottom: 5px; }
        
        .right-side{ width:50%; padding:60px; display:flex; align-items:center; }
        .form-login{ width:100%; }
        .form-login h3{ font-weight:700; color:#1e3a8a; margin-bottom:5px; }
        .form-login p{ color:#777; margin-bottom:30px; }
        
        .input-group-custom{ margin-bottom:20px; }
        .input-group-custom label{ display:block; margin-bottom:6px; font-weight:600; }
        .input-custom{ 
            width:100%; padding:13px 15px; border:1px solid #d1d5db; 
            border-radius:12px; transition:.3s; background-color: #f9fafb;
        }
        .input-custom:focus{ outline:none; border-color:#2563eb; box-shadow:0 0 10px rgba(37,99,235,.2); }
        
        .btn-login{ 
            width:100%; border:none; padding:14px; border-radius:12px; 
            background:#2563eb; color:white; font-weight:600; transition:.3s; 
        }
        .btn-login:hover{ background:#1e3a8a; transform:translateY(-2px); }
        
        .register-link{ text-align:center; margin-top:20px; }
        .register-link a{ text-decoration:none; color:#2563eb; font-weight:600; }
        .footer-login{ text-align:center; margin-top:25px; color:#999; font-size:13px; }

        @media (max-width: 768px) {
            .login-container{ flex-direction:column; }
            .left-side, .right-side{ width:100%; }
            .left-side{ min-height:250px; }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="left-side">
        <h1><i class="bi bi-bag-check-fill"></i></h1>
        <h2>Manajemen Penjualan</h2>
        <p>Sistem Informasi Transaksi Penjualan</p>
        <p>UAS Pemrograman Web 2</p>
    </div>
    <div class="right-side">
        <form method="POST" class="form-login">
            <h3>Selamat Datang 👋</h3>
            <p>Silakan login untuk masuk ke dashboard.</p>
            <div class="input-group-custom">
                <label>Username</label>
                <input type="text" name="username" class="input-custom" required>
            </div>  
            <div class="input-group-custom">
                <label>Password</label>
                <input type="password" name="password" class="input-custom" required>
            </div>
            <button type="submit" name="login" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
            <div class="register-link">Belum punya akun? <a href="register.php">Register</a></div>
            <div class="footer-login">© 2026 Sistem Penjualan</div>
        </form>
    </div>
</div>
</body>
</html>