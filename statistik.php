<?php
require_once "../config/database.php";
class Statistik {
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function totalTransaksi()
    {
        $q = mysqli_query(
            $this->conn,
            "SELECT COUNT(*) total
             FROM transaksi"
        );
        $data = mysqli_fetch_assoc($q);

        return $data['total'];
    }
    public function totalPendapatan()
    {
        $q = mysqli_query(
            $this->conn,
            "SELECT SUM(total) total
             FROM transaksi"
        );
        $data = mysqli_fetch_assoc($q);
        return $data['total'];
    }
    public function totalBarangTerjual()
    {
        $q = mysqli_query(
            $this->conn,
            "SELECT SUM(jumlah) total
             FROM transaksi"
        );
        $data = mysqli_fetch_assoc($q);
        return $data['total'];
    }
    public function produkTerlaris()
    {
        $q = mysqli_query(
            $this->conn,
            "SELECT nama_barang
             FROM transaksi
             ORDER BY jumlah DESC
             LIMIT 1"
        );
        $data = mysqli_fetch_assoc($q);
        return $data['nama_barang'] ?? '-';
    }
}
?>