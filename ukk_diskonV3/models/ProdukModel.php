<?php
class ProdukModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllProduk() {
        $query = "SELECT * FROM produk";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProdukById($id) {
        $id = (int) $id;
        $query = "SELECT * FROM produk WHERE id = $id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    public function tambahProduk($nama, $harga, $stok, $diskon) {
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $harga = (int) $harga;
        $stok = (int) $stok;
        $diskon = (int) $diskon;

        $query = "INSERT INTO produk (nama_produk, harga, stok, diskon) 
                  VALUES ('$nama', $harga, $stok, $diskon)";
        return $this->conn->query($query);
    }

    public function editProduk($id, $nama, $harga, $stok, $diskon) {
        $id = (int) $id;
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $harga = (int) $harga;
        $stok = (int) $stok;
        $diskon = (int) $diskon;

        $query = "UPDATE produk SET nama_produk='$nama', harga=$harga, stok=$stok, diskon=$diskon 
                  WHERE id=$id";
        return $this->conn->query($query);
    }

    public function hapusProduk($id) {
    $id = (int) $id; // Pastikan ID aman
    $query = "DELETE FROM produk WHERE id=$id";
    return $this->conn->query($query);
}

    public function kurangiStok($id, $jumlah) {
        $id = (int) $id;
        $jumlah = (int) $jumlah;
        $query = "UPDATE produk SET stok = stok - $jumlah WHERE id=$id";
        return $this->conn->query($query);
    }
}