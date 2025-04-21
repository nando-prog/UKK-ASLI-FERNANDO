<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $kategori_id = $_POST['kategori_id'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_barang = trim($_POST['nama_barang']);
        $kategori_id = $_POST['kategori_id'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $tanggal_masuk = $_POST['tanggal_masuk'];

        if (empty($nama_barang) || empty($kategori_id) || empty($stok) || empty($harga) || empty($tanggal_masuk)) {
            echo "<script>alert('Semua field wajib diisi!'); window.location.href='tambah_barang.php';</script>";
            exit;
        }

        if (!is_numeric($stok) || $stok < 0) {
            echo "<script>alert('MASUKIN ANGKA YANG BENER LAH!!!'); window.location.href='tambah_barang.php';</script>";
            exit;
        }

        if (!is_numeric($harga) || $harga < 0) {
            echo "<script>alert('HARGA NYA KERENDAHAN, RUPIAH TURUN HARGA?!'); window.location.href='tambah_barang.php';</script>";
            exit;
        }
        $query = "INSERT INTO barang (nama_barang, kategori_id, stok, harga, tanggal_masuk)
              VALUES ('$nama_barang', '$kategori_id', '$stok', '$harga', '$tanggal_masuk')";

        if (mysqli_query($conn, $query)) {
            header("Location: barang.php?pesan=sukses");
            exit;
        } else {
            echo "Gagal: " . mysqli_error($conn);
        }
    }

    $query = "INSERT INTO barang (nama_barang, kategori_id, stok, harga, tanggal_masuk)
          VALUES ('$nama_barang', '$kategori_id', '$stok', '$harga', '$tanggal_masuk')";
    if (mysqli_query($conn, $query)) {
        header("Location: barang.php?pesan=sukses");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}


$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">
    <div class="max-w-xl mx-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-lg">
        <h1 class="text-2xl mb-4 font-bold text-lime-500">Tambah Barang</h1>
        <form method="POST">
            <label class="block mb-2">Nama Barang</label>
            <input type="text" name="nama_barang" required class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <label class="block mb-2">Kategori</label>
            <select name="kategori_id" required class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">
                <option value="">-- Pilih Kategori --</option>
                <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nama_kategori'] ?></option>
                <?php } ?>
            </select>

            <label class="block mb-2">Stok</label>  
            <input type="number" name="stok" required min="0" class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <label class="block mb-2">Harga</label>
            <input type="number" name="harga" required min="0" class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <label class="block mb-2">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" required class="w-full p-2 rounded bg-gray-700 border border-gray-600 mb-4">

            <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">Simpan</button>
            <a href="barang.php" class="ml-2 text-sm text-lime-400 hover:underline">← Kembali</a>
        </form>
    </div>
</body>
</html>