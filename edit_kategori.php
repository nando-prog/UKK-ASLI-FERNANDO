<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM kategori WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kategori = $_POST['nama_kategori'];
    $sql = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: kategori.php?pesan=edit");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 text-white font-serif">
    <div class="max-w-lg mx-auto py-10 px-6">
        <h2 class="text-2xl font-bold mb-6 text-lime-500">Edit Kategori</h2>
        <form method="POST">
            <label class="block mb-2 text-sm">Nama Kategori:</label>
            <input type="text" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required class="w-full px-4 py-2 text-gray-800 rounded-md border border-gray-300 mb-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">Update</button>
            <a href="kategori.php" class="ml-2 text-sm text-gray-300 hover:underline">Kembali</a>
        </form>
    </div>
</body>

</html>