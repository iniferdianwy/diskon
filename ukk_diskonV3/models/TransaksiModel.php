<?php
class TransaksiModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method untuk mengambil semua transaksi
    public function getAllTransaksi($user_id, $role) {
        if ($role === 'admin') {
            // Admin dapat melihat semua transaksi
            $query = "
                SELECT t.id, p.nama_produk, t.jumlah, t.diskon, t.total_harga_setelah_diskon, t.tanggal_transaksi 
                FROM transaksi t
                JOIN produk p ON t.produk_id = p.id
            ";
        } else {
            // User biasa hanya bisa melihat transaksinya sendiri
            $query = "
                SELECT t.id, p.nama_produk, t.jumlah, t.diskon, t.total_harga_setelah_diskon, t.tanggal_transaksi 
                FROM transaksi t
                JOIN produk p ON t.produk_id = p.id
                WHERE t.user_id = $user_id
            ";
        }
        
        $result = mysqli_query($this->conn, $query);
    
        // Cek apakah query berhasil
        if (!$result) {
            die('Query gagal: ' . mysqli_error($this->conn));
        }
    
        $transaksiList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $transaksiList[] = $row;
        }
    
        return $transaksiList;
    }
}    