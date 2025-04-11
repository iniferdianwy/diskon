<?php
class Koneksi {
    private $host = "127.0.0.1";  // Sesuaikan dengan host database
    private $username = "root";   // Sesuaikan dengan username database
    private $password = "root";   // Sesuaikan dengan password database
    private $database = "diskon"; // Sesuaikan dengan nama database
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Koneksi database gagal: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Buat objek koneksi agar bisa digunakan di seluruh aplikasi
$database = new Koneksi();
$conn = $database->getConnection();
?>