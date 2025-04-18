<?php
require_once 'crud_kategori.php';

$kategori = new crud_kategori();
$kategori->handleRequest();

$isEdit = isset($_GET['id']);
$data = ['id_kategori' => '', 'nama_kategori' => '', 'deskripsi' => ''];

if ($isEdit) {
    $result = $kategori->getById($_GET['id']);
    $data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Edit Kategori</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id_kategori" value="<?= $data['id_kategori'] ?>">

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required value="<?= htmlspecialchars($data['nama_kategori']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                        </div>

                        <button type="submit" name="update" class="btn btn-success">Update</button>
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
