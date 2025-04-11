<?php
require_once '../config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        global $conn; // Ambil koneksi dari database.php
        $this->conn = $conn;
    }

    public function getUserByEmail($email) {
        $query = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function tambahUser($nama, $email, $password, $role) {
        $query = $this->conn->prepare("INSERT INTO user (nama, email, password, role) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $nama, $email, $password, $role);
        return $query->execute();
    }
}
?>