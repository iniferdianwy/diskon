<?php
session_start();
require_once '../config/database.php';
require_once '../models/TransaksiModel.php';

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
$user_id = $_SESSION['user_id']; // Ambil user_id dari session

// Ambil data transaksi berdasarkan user_id dan role
$transaksiModel = new TransaksiModel($conn);
$transaksiList = $transaksiModel->getAllTransaksi($user_id, $user_role);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Transaksi</title>
</head>
<body>

    <?php include '../views/layout/navbar.php'; ?> 
    <div class="container mt-4">
      <h2>Daftar Transaksi</h2>
      
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Diskon (%)</th>
            <th>Harga</th>
            <th>Tanggal Transaksi</th>
          </tr>
        </thead>
        <tbody>
            <?php if (empty($transaksiList)): ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada transaksi.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; // Inisialisasi nomor urut ?>
                <?php foreach ($transaksiList as $transaksi): ?>
                    <tr>
                        <td><?= $no++; ?></td> <!-- Menampilkan nomor urut -->
                        <td><?= htmlspecialchars($transaksi['nama_produk']); ?></td>
                        <td><?= htmlspecialchars($transaksi['jumlah']); ?></td>
                        <td><?= htmlspecialchars($transaksi['diskon']); ?>%</td>
                        <td>Rp<?= number_format($transaksi['total_harga_setelah_diskon'], 0, ',', '.'); ?></td>
                        <td><?= htmlspecialchars($transaksi['tanggal_transaksi']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
      </table>
    </div>
  
</body>
</html>