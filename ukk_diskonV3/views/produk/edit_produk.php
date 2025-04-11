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
$produkModel = new ProdukModel($conn);

// Ambil data produk berdasarkan ID
$id = $_GET['id'] ?? 0;
$produkDetail = $produkModel->getProdukById($id);

// Jika produk tidak ditemukan
if (!$produkDetail) {
    header("Location: ../produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Edit Produk</h3>
                    <form action="../../controllers/ProdukController.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produkDetail['id']); ?>">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($produkDetail['nama_produk']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" value="<?= $produkDetail['harga']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $produkDetail['stok']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diskon (%)</label>
                            <input type="number" name="diskon" class="form-control" min="0" max="100" value="<?= $produkDetail['diskon']; ?>" required>
                        </div>
                        <button type="submit" name="action" value="edit" class="btn btn-success btn-custom w-100">Simpan Perubahan</button>
                        <a href="../produk.php" class="btn btn-secondary btn-custom w-100 mt-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>