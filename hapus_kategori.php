<?php
include 'koneksi.php';

$id = $_GET['id'];
$sql = "DELETE FROM kategori WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: kategori.php?pesan=hapus");
    exit;
} else {
    echo "Gagal hapus: " . mysqli_error($conn);
}
