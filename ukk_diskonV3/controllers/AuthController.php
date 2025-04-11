<?php
session_start();
require_once '../config/database.php';
require_once '../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel((new Koneksi())->getConnection());
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->getUserByEmail($_POST['email']);
            
            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION = [
                    'user_id' => $user['id'],
                    'role' => $user['role'],
                    'user_name' => $user['nama'],
                    'user_email' => $user['email']
                ];
                header("Location: ../views/dashboard.php");
            } else {
                $_SESSION['error'] = "Email atau password salah!";
                header("Location: ../views/login.php");
            }
            exit;
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            if ($this->userModel->tambahUser($_POST['nama'], $_POST['email'], $password, 'user')) {
                $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
                header("Location: ../views/login.php");
            } else {
                $_SESSION['error'] = "Registrasi gagal!";
                header("Location: ../views/register.php");
            }
            exit;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../views/login.php");
        exit;
    }
}

$auth = new AuthController();

if (isset($_GET['action'])) {
    match ($_GET['action']) {
        'login' => $auth->login(),
        'register' => $auth->register(),
        'logout' => $auth->logout()
    };
}
