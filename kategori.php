<?php
require_once 'crud_kategori.php';

$kategori = new crud_kategori();
$kategori->handleRequest();
$result = $kategori->getAll();
$dataKategori = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📁 Daftar Kategori</h2>
        <div>
            <a href="tambah_kategori.php" class="btn btn-primary">Tambah Kategori</a>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataKategori as $row): ?>
                <tr>
                    <td class="text-center"><?= $row['id_kategori'] ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td class="text-center">
                        <a href="edit_kategori.php?id=<?= $row['id_kategori'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="crud_kategori.php?delete=<?= $row['id_kategori'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($dataKategori)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data kategori.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

