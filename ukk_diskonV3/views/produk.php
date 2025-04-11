<?php
session_start();
require_once '../config/database.php';
require_once '../models/ProdukModel.php';

// Inisialisasi koneksi database
$koneksi = new Koneksi();
$conn = $koneksi->getConnection();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil role dari session
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

// Ambil data produk
$produkModel = new ProdukModel($conn);
$produkList = $produkModel->getAllProduk();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../views/layout/navbar.php'; ?>  

    <div class="container mt-4">
        <h2>Daftar Produk</h2>

        <!-- Notifikasi Alert -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_GET['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tombol Tambah Produk (Hanya Admin) -->
        <?php if ($user_role === 'admin'): ?>
            <a href="produk/tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk</a>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Diskon (%)</th>
                    <th>Harga Setelah Diskon</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produkList)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada produk.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; // Inisialisasi nomor urut ?>
                    <?php foreach ($produkList as $produk): ?>
                        <?php $hargaSetelahDiskon = $produk['harga'] - ($produk['harga'] * $produk['diskon'] / 100); ?>
                        <tr>
                            <td><?= $no++; ?></td> <!-- Menampilkan nomor urut -->
                            <td><?= htmlspecialchars($produk['nama_produk']); ?></td>
                            <td>Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($produk['diskon']); ?>%</td>
                            <td>Rp<?= number_format($hargaSetelahDiskon, 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($produk['stok']); ?></td>
                            <td>
                                <?php if ($user_role === 'admin'): ?>
                                    <a href="../views/produk/edit_produk.php?id=<?= $produk['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="../controllers/ProdukController.php?action=hapus&id=<?= $produk['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?');">Hapus</a>
                                <?php elseif ($user_role === 'user'): ?>
                                    <?php if ($produk['stok'] > 0): ?>
                                        <a href="../views/produk/beli.php?id=<?= $produk['id']; ?>" class="btn btn-success btn-sm">Beli</a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Stok Habis</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>