<?php
session_start();
require_once '../config/database.php';
require_once '../models/ProdukModel.php';

class TransaksiController {
    private $produkModel;
    private $conn;

    public function __construct() {
        $this->conn = (new Koneksi())->getConnection();
        $this->produkModel = new ProdukModel($this->conn);
    }

    public function prosesBeli($produk_id, $diskon_persen = 0) {
        if (empty($_SESSION['user_id'])) {
            header("Location: ../views/login.php");
            exit;
        }

        $produk = $this->produkModel->getProdukById($produk_id) ?? die("Error: Produk tidak ditemukan!");
        $harga_akhir = $produk['harga'] * (1 - min($diskon_persen, 100) / 100);

        $query = $this->conn->prepare("INSERT INTO transaksi (user_id, produk_id, harga_awal, diskon, harga_akhir) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("iidid", $_SESSION['user_id'], $produk_id, $produk['harga'], $diskon_persen, $harga_akhir);

        header("Location: ../views/produk.php?" . ($query->execute() ? "success=1" : "error=1"));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['produk_id'])) {
    (new TransaksiController())->prosesBeli($_POST['produk_id'], $_POST['diskon'] ?? 0);
}
