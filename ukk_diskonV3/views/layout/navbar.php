<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "Aplikasi Diskon"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(to right, #007bff, #6610f2);
            padding: 15px 20px;
            transition: all 0.3s ease-in-out;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
        }

        .nav-link {
            color: white !important;
            margin: 0 10px;
            transition: transform 0.2s;
        }

        .nav-link:hover {
            transform: translateY(-3px);
            text-shadow: 0px 3px 10px rgba(255, 255, 255, 0.5);
        }

        /* Animasi hover tombol */
        .btn-logout {
            background: #dc3545;
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-logout:hover {
            background: #c82333;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">DiskonApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produk.php"><i class="fas fa-shopping-cart"></i> Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transaksi.php"><i class="fas fa-dollar"></i>Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white btn-logout" href="../controllers/AuthController.php?action=logout" onclick="return confirm('Yakin ingin logout?');"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>