<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/ProdukModel.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Inisialisasi koneksi database
$koneksi = new Koneksi();
$conn = $koneksi->getConnection();

// Cek apakah ada produk yang dipilih
if (!isset($_GET['id'])) {
    header("Location: ../produk.php");
    exit;
}

$id_produk = $_GET['id'];

// Ambil data produk
$produkModel = new ProdukModel($conn);
$produk = $produkModel->getProdukById($id_produk);

if (!$produk) {
    header("Location: ../views/produk.php");
    exit;
}

// Proses pembelian saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah_beli = (int) $_POST['jumlah'];
    
    // Pastikan stok mencukupi
    if ($jumlah_beli > $produk['stok']) {
        header("Location: beli.php?id=$id_produk&status=error&message=Stok tidak mencukupi!");
        exit;
    }

    // Hitung harga setelah diskon
    $diskon = $produk['diskon'];
    $harga_setelah_diskon = $produk['harga'] - ($produk['harga'] * ($diskon / 100));
    $total_harga = $jumlah_beli * $harga_setelah_diskon;
    $tanggal_transaksi = date('Y-m-d H:i:s');

    // Simpan transaksi
    $query = "INSERT INTO transaksi (user_id, produk_id, jumlah, total_harga, diskon, total_harga_setelah_diskon, tanggal_transaksi) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $harga_total = $produk['harga'];
    $jumlah_beli; // Simpan dalam variabel
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiddds", $user_id, $id_produk, $jumlah_beli, $harga_total, $diskon, $total_harga, $tanggal_transaksi);
    if ($stmt->execute()) {
        // Kurangi stok produk
        $produkModel->kurangiStok($id_produk, $jumlah_beli);

        // Redirect dengan notifikasi sukses
        header("Location: ../produk.php?status=success&message=Pembelian berhasil!");
    } else {
        header("Location: beli.php?id=$id_produk&status=error&message=Terjadi kesalahan!");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
                    <h3 class="text-center mb-4">Beli Produk</h3>

                    <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
                        <div class="alert alert-<?= $_GET['status'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="beli.php?id=<?= $id_produk; ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk:</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($produk['nama_produk']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga:</label>
                            <input type="text" class="form-control" value="Rp<?= number_format($produk['harga'], 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diskon:</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($produk['diskon']); ?>%" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah:</label>
                            <input type="number" class="form-control" name="jumlah" min="1" max="<?= $produk['stok']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-custom w-100">Beli</button>
                        <a href="../produk.php" class="btn btn-secondary btn-custom w-100 mt-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>