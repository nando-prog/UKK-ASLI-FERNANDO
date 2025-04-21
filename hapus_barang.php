<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data barang
    $query = "DELETE FROM barang WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Data barang berhasil dihapus'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan'); window.location.href='index.php';</script>";
}
