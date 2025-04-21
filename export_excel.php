<?php
include 'koneksi.php';  // Pastikan koneksi ke database sudah benar

// Set header untuk men-download file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_barang.xls");

// Menulis header kolom di file Excel
echo "ID\tNama Barang\tKategori\tStok\tHarga\tTanggal Masuk\n";

// Query untuk mengambil data barang dan kategori
$query = "SELECT barang.id, barang.nama_barang, kategori.nama_kategori, barang.stok, barang.harga, barang.tanggal_masuk 
          FROM barang 
          JOIN kategori ON barang.kategori = kategori.id";
$result = mysqli_query($conn, $query);

// Loop untuk menulis data barang ke dalam file Excel
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['id']}\t{$row['nama_barang']}\t{$row['nama_kategori']}\t{$row['stok']}\t{$row['harga']}\t{$row['tanggal_masuk']}\n";
}
