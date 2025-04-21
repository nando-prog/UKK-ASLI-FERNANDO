<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
    if (mysqli_query($conn, $sql)) {
        header("Location:kategori.php");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">
    <div class="max-w-xl mx-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-lg">
        <h1 class="text-2xl mb-4 font-bold text-lime-500">Tambah Kategori</h1>
        <form method="POST">
            <label class="block mb-2">Nama Kategori</label>
            <input type="text" name="nama_kategori" required class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <button type="submit" class="bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded text-white">Simpan</button>
            <a href="barang.php" class="ml-2 text-sm text-lime-400 hover:underline">← Kembali</a>
        </form>
    </div>
</body>

</html>