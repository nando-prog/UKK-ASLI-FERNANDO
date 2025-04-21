<?php
include 'koneksi.php';

$id = $_GET['id'];
$barang = mysqli_query($conn, "SELECT * FROM barang WHERE id = $id");
$data = mysqli_fetch_assoc($barang);

// Ambil data kategori untuk dropdown
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_barang'];
    $kategori_id = $_POST['kategori_id'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $sql = "UPDATE barang SET nama_barang='$nama', kategori_id='$kategori_id', stok='$stok', harga='$harga' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: barang.php?pesan=update");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">
    <div class="max-w-xl mx-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-lg">
        <h1 class="text-2xl mb-4 font-bold text-yellow-400">Edit Barang</h1>
        <form method="POST">
            <label class="block mb-2">Nama Barang</label>
            <input type="text" name="nama_barang" value="<?= $data['nama_barang'] ?>" required class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <label class="block mb-2">Kategori</label>
            <select name="kategori_id" required class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">
                <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
                    <option value="<?= $row['id'] ?>" <?= $row['id'] == $data['kategori_id'] ? 'selected' : '' ?>>
                        <?= $row['nama_kategori'] ?>
                    </option>
                <?php } ?>
            </select>

            <label class="block mb-2">Stok</label>
            <input type="number" name="stok" value="<?= $data['stok'] ?>" required min="0" class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <label class="block mb-2">Harga</label>
            <input type="number" name="harga" value="<?= $data['harga'] ?>" required min="0" class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded text-white">Update</button>
            <a href="barang.php" class="ml-2 text-sm text-lime-400 hover:underline">← Kembali</a>
        </form>
    </div>
</body>

</html>