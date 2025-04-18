<?php
include_once 'koneksi.php';

class crud_buku {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
    }

    // ===== Model Function =====
    public function getAll($searchTerm = '') {
        $searchTerm = '%' . $searchTerm . '%';  // Menambahkan wildcard untuk pencarian
    
        // Menambahkan kondisi pencarian untuk tahun terbit dan mengurutkan berdasarkan tahun terbit terbaru
        $sql = "SELECT b.*, k.nama_kategori FROM buku b 
                LEFT JOIN kategori k ON b.kategori_id = k.id_kategori
                WHERE b.judul LIKE ? OR b.penulis LIKE ? OR k.nama_kategori LIKE ? OR b.tahun_terbit LIKE ?
                ORDER BY b.tahun_terbit DESC, b.judul ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    }
    

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function tambah($judul, $penulis, $tahun, $stok, $kategori_id) {
        $stmt = $this->conn->prepare("INSERT INTO buku (judul, penulis, tahun_terbit, stok, kategori_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $judul, $penulis, $tahun, $stok, $kategori_id);
        return $stmt->execute();
    }

    public function update($id, $judul, $penulis, $tahun, $stok, $kategori_id) {
        $stmt = $this->conn->prepare("UPDATE buku SET judul = ?, penulis = ?, tahun_terbit = ?, stok = ?, kategori_id = ? WHERE id_buku = ?");
        $stmt->bind_param("ssiiii", $judul, $penulis, $tahun, $stok, $kategori_id, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM buku WHERE id_buku = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getKategori() {
        return $this->conn->query("SELECT * FROM kategori");
    }

    // ===== Controller Function =====
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['tambah'])) {
                $this->tambah($_POST['judul'], $_POST['penulis'], $_POST['tahun_terbit'], $_POST['stok'], $_POST['kategori_id']);
                header("Location: index.php");
            }

            if (isset($_POST['update'])) {
                $this->update($_POST['id_buku'], $_POST['judul'], $_POST['penulis'], $_POST['tahun_terbit'], $_POST['stok'], $_POST['kategori_id']);
                header("Location: index.php");
            }
        }

        if (isset($_GET['delete'])) {
            $this->delete($_GET['delete']);
            header("Location: index.php");
        }
    }
}
?>
