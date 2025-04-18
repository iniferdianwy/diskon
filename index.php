<?php
include_once 'crud_buku.php';

// Tangani pencarian
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Buat objek buku dan ambil data dengan pencarian
$buku = new crud_buku();
$dataBuku = $buku->getAll($searchTerm);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📚 Daftar Buku</h2>
        <div>
            <a href="tambah_buku.php" class="btn btn-primary me-2">Tambah Buku</a>
            <a href="kategori.php" class="btn btn-secondary">Kelola Kategori</a>
        </div>
    </div>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari buku..." value="<?= htmlspecialchars($searchTerm) ?>">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($dataBuku as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($no++) ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['penulis']) ?></td>
                    <td class="text-center"><?= $row['tahun_terbit'] ?></td>
                    <td class="text-center"><?= $row['stok'] ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                    <td class="text-center">
                        <a href="edit_buku.php?id=<?= $row['id_buku'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="crud_buku.php?delete=<?= $row['id_buku'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($dataBuku)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada buku yang ditemukan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
