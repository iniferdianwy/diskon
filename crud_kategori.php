<?php
include_once 'koneksi.php';

class crud_kategori {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
    }

    // ===== Model Function =====
    public function getAll() {
        return $this->conn->query("SELECT * FROM kategori");
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function tambah($nama, $deskripsi) {
        $stmt = $this->conn->prepare("INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama, $deskripsi);
        return $stmt->execute();
    }

    public function update($id, $nama, $deskripsi) {
        $stmt = $this->conn->prepare("UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id_kategori = ?");
        $stmt->bind_param("ssi", $nama, $deskripsi, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ===== Controller Function =====
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['tambah'])) {
                $this->tambah($_POST['nama_kategori'], $_POST['deskripsi']);
                header("Location: kategori.php");
            }

            if (isset($_POST['update'])) {
                $this->update($_POST['id_kategori'], $_POST['nama_kategori'], $_POST['deskripsi']);
                header("Location: kategori.php");
            }
        }

        if (isset($_GET['delete'])) {
            $this->delete($_GET['delete']);
            header("Location: kategori.php");
        }
    }
}
?>
