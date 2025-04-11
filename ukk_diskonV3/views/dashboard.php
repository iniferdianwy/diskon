<?php
session_start();
require_once '../config/database.php';

// Inisialisasi koneksi database
$koneksi = new Koneksi();
$conn = $koneksi->getConnection();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM user WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Ambil role dari session
$user_role = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../views/layout/navbar.php'; ?>  

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h3 class="card-title">Dashboard</h3>
                    <p class="card-text">Selamat datang, <strong><?= htmlspecialchars($user['nama']); ?></strong>!</p>
                    <p class="card-text">Anda login sebagai <strong class="badge bg-primary"><?= htmlspecialchars($user_role); ?></strong>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>