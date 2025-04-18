<?php
require_once 'crud_buku.php';

$buku = new crud_buku();
$kategoriList = $buku->getKategori();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buku->handleRequest();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Tambah Buku</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" min="1000" max="9999" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="" disabled>Pilih Kategori</option>
                        <?php while ($kat = $kategoriList->fetch_assoc()): ?>
                            <option value="<?= $kat['id_kategori'] ?>"><?= $kat['nama_kategori'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Flexbox container for the buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" name="tambah" class="btn btn-primary w-50">Simpan</button>
                    <a href="index.php" class="btn btn-secondary w-50">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
