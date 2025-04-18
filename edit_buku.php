<?php
require_once 'crud_buku.php';

$buku = new crud_buku();
$kategoriList = $buku->getKategori();
$data = $buku->getById($_GET['id'])->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buku->handleRequest();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Edit Buku</h2>
            <form method="post">
                <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($data['penulis']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" value="<?= htmlspecialchars($data['tahun_terbit']) ?>" min="1000" max="9999" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($data['stok']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <?php while ($kat = $kategoriList->fetch_assoc()): ?>
                            <option value="<?= $kat['id_kategori'] ?>" <?= $kat['id_kategori'] == $data['kategori_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['nama_kategori']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-primary w-50">Update</button>
                    <a href="index.php" class="btn btn-secondary w-50">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
