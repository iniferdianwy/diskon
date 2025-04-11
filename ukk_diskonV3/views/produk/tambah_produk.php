<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/ProdukModel.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../produk.php");
    exit;
}

// Inisialisasi koneksi database
$koneksi = new Koneksi();
$conn = $koneksi->getConnection();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Tambah Produk</h2>
        <form action="../../controllers/ProdukController.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Diskon (%)</label>
                <div class="input-group">
                    <input type="number" name="diskon" id="diskon" class="form-control" min="0" max="100" required>
                    <button type="button" class="btn btn-primary" id="konfirmasiDiskon">Konfirmasi</button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Setelah Diskon</label>
                <input type="text" id="harga_setelah_diskon" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" required>
            </div>
            <button type="submit" name="action" value="tambah" class="btn btn-success w-100">Tambah Produk</button>
            <a href="../produk.php" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("konfirmasiDiskon").addEventListener("click", function() {
            let harga = parseFloat(document.getElementById("harga").value) || 0;
            let diskon = parseFloat(document.getElementById("diskon").value) || 0;
            let hargaSetelahDiskon = harga - (harga * (diskon / 100));
            document.getElementById("harga_setelah_diskon").value = hargaSetelahDiskon.toFixed(2);
        });
    </script>
</body>
</html>