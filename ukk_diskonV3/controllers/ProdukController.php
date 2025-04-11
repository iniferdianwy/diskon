<?php
require_once '../config/database.php';
require_once '../models/ProdukModel.php';

class ProdukController {
    private $produkModel;

    public function __construct() {
        $this->produkModel = new ProdukModel((new Koneksi())->getConnection());
    }

    public function kelolaProduk($action, ...$params) {
    return match ($action) {
        'tambah' => $this->produkModel->tambahProduk(...$params),
        'edit' => $this->produkModel->editProduk(...$params),
        'hapus' => $this->produkModel->hapusProduk($params[0]), // Tidak perlu unpacking
        default => false
    };
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produkController = new ProdukController();
    $action = $_POST['action'] ?? null;

    if ($action === 'tambah') {
        $produkController->kelolaProduk($action, $_POST['nama_produk'], $_POST['harga'], $_POST['stok'], $_POST['diskon']);
    } elseif ($action === 'edit') {
        $produkController->kelolaProduk($action, $_POST['id'], $_POST['nama_produk'], $_POST['harga'], $_POST['stok'], $_POST['diskon']);
    }

    header("Location: ../views/produk.php?status=success&message=Produk berhasil " . $action);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $produkController = new ProdukController();
    $id = (int) $_GET['id']; // Pastikan ID valid
    $message = $produkController->kelolaProduk('hapus', $id) 
        ? "Produk berhasil dihapus" 
        : "Gagal menghapus produk";

    header("Location: ../views/produk.php?status=" . ($message === "Produk berhasil dihapus" ? "success" : "error") . "&message=$message");
    exit;
}