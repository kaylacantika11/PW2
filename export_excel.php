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
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Transaksi.xls");
$query = mysqli_query($koneksi," SELECT * FROM transaksi ORDER BY CASE WHEN id_transaksi='251011700395' THEN 0 ELSE 1 END,CAST(id_transaksi AS UNSIGNED) ASC");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Export Excel</title>
    </head>
    <body>
        <h2 align="center">LAPORAN TRANSAKSI PENJUALAN</h2>
        <table border="1" cellspacing="0" cellpadding="5">
            <tr style="background:#d9eaf7;font-weight:bold;">
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
<?php
$no = 1;
while($row = mysqli_fetch_assoc($query))
{
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['id_transaksi']; ?></td>
    <td><?= $row['nama_barang']; ?></td>
    <td><?= $row['harga']; ?></td>
    <td><?= $row['jumlah']; ?></td>
    <td><?= $row['total']; ?></td>
</tr>
<?php
}
?>
</table>
</body>
</html>