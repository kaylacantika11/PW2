<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $transaksi = new Transaksi();
    $transaksi->hapus($id);
}
header("Location: transaksi.php");
exit;
?>