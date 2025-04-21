<?php
include 'koneksi.php';

$keyword = isset($_GET['search']) ? $_GET['search'] : '';

// Ambil data kategori dengan pencarian
$sql = "SELECT * FROM kategori";
if (!empty($keyword)) {
    $sql .= " WHERE nama_kategori LIKE '%$keyword%'";
}
$sql .= " ORDER BY id ASC";
$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 text-white font-serif">

    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-lime-500 mb-6">Data Kategori</h1>

        <!-- Notifikasi -->
        <?php if (isset($_GET['pesan'])): ?>
            <div class="mb-4 p-4 rounded text-sm font-medium 
            <?php
            if ($_GET['pesan'] == 'sukses') echo 'bg-green-600 text-white';
            elseif ($_GET['pesan'] == 'edit') echo 'bg-blue-600 text-white';
            elseif ($_GET['pesan'] == 'hapus') echo 'bg-red-600 text-white';
            ?>">
                <?php
                if ($_GET['pesan'] == 'sukses') echo 'Kategori berhasil ditambahkan.';
                elseif ($_GET['pesan'] == 'edit') echo 'Kategori berhasil diubah.';
                elseif ($_GET['pesan'] == 'hapus') echo 'Kategori berhasil dihapus.';
                ?>
            </div>
        <?php endif; ?>

        <!-- Form Pencarian -->
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" placeholder="Cari kategori..." value="<?= htmlspecialchars($keyword) ?>"
                class="px-3 py-2 rounded text-sm w-full text-black border border-gray-300">
            <button type="submit" class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded text-sm">Cari</button>
            <a href="kategori.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">Reset</a>
        </form>

        <a href="tambah_kategori.php" class="bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded text-white text-sm mb-4 inline-block">
            + Tambah Kategori
        </a>

        <div class="bg-white text-gray-800 shadow-xl rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-200 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Nama Kategori</th>
                        <th class="px-4 py-3 text-left">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1;
                        ?>
                        <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-3"><?= $no++ ?></td>
                                <td class="px-4 py-3"><?= $data['nama_kategori'] ?></td>
                                <td class="px-4 py-3">
                                    <a href="edit_kategori.php?id=<?= $data['id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                                    <a href="hapus_kategori.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs ml-2">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-4">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class='mt-6 justify-center flex'>
        <a href='barang.php' class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">Balek ke Data Barang</a>
    </div>
</body>

</html>