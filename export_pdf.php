<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include 'koneksi.php';

$html = '
<style>
    body { font-family: sans-serif; }
    h2 { text-align: center; }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<h2>Laporan Data Barang</h2>
<table>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Tanggal Masuk</th>
    </tr>
';

$query = "SELECT barang.*, kategori.nama_kategori 
          FROM barang 
          JOIN kategori ON barang.kategori_id = kategori.id";
$result = mysqli_query($conn, $query);
$no = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($row['nama_barang']) . '</td>
        <td>' . htmlspecialchars($row['nama_kategori']) . '</td>
        <td>' . $row['stok'] . '</td>
        <td>Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>
        <td>' . date('d-m-Y', strtotime($row['tanggal_masuk'])) . '</td>
    </tr>';
}

$html .= '</table>';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Data_Barang.pdf", array("Attachment" => false));
