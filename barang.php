<?php
include 'koneksi.php';

// Ambil semua kategori
$kategoriQuery = "SELECT * FROM kategori";
$kategoriResult = mysqli_query($conn, $kategoriQuery);

// Ambil filter kategori dari URL (GET)
$filter = isset($_GET['nama_kategori']) ? strtolower($_GET['nama_kategori']) : '';

// Query data barang + filter jika ada
$query = "SELECT barang.*, kategori.nama_kategori 
          FROM barang 
          JOIN kategori ON barang.kategori_id = kategori.id";

if ($filter !== '') {
    $query .= " WHERE LOWER(kategori.nama_kategori) = '$filter'";
}

$result = mysqli_query($conn, $query);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventori Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 font-serif">

    <div class="max-w-6xl mx-auto px-4 py-10">
        <!-- Header dan Tombol Tambah -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-3xl font-bold text-lime-600">Inventori Barang</h1>
            <div class="flex gap-2 justify-center me-8 mt-1">
                <a href="tambah_barang.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm shadow-md">
                    + Tambah Barang
                </a>
                <a href="tambah_kategori.php" class="bg-pink-500 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm shadow-md">
                    + Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Filter dan Search -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div class="flex items-center gap-2">
                <form method="GET" action="barang.php" class="flex items-center gap-2">
                    <label for="filterKategori" class="text-sm text-lime-600">Filter Kategori:</label>
                    <select name="nama_kategori" id="filterKategori" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                        <option value="">Semuanyah</option>
                        <?php while ($k = mysqli_fetch_assoc($kategoriResult)) : ?>
                            <option value="<?= strtolower($k['nama_kategori']) ?>" <?= (strtolower($k['nama_kategori']) == $filter) ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </form>

            </div>

            <div class="flex items-center gap-2">
                <input type="text" id="searchInput" placeholder="Cari barang..." class="border border-gray-300 rounded-md px-3 py-1 text-sm w-60">
                <a href="export_pdf.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">Export PDF</a>
                <div class='mt-6'>
                </div>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto shadow-xl rounded-2xl bg-white p-6">
            <table class="min-w-full text-sm text-left" id="tabelBarang">
                <thead>
                    <tr class="text-gray-600 uppercase text-xs border-b border-gray-200">
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Nama Barang</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Stok</th>
                        <th class="py-3 px-4">Harga</th>
                        <th class="py-3 px-4">Tanggal Masuk</th>
                        <th class="py-3 px-4">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($data = mysqli_fetch_assoc($result)) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-3"><?= $no++ ?></td> <!-- Nomor urut -->
                                <td class="px-4 py-3"><?= $data['nama_barang'] ?></td>
                                <td class="px-4 py-3"><?= $data['nama_kategori'] ?></td>
                                <td class="px-4 py-3"><?= $data['stok'] ?></td>
                                <td class="py-3 px-4">Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                                <td class="px-4 py-3"><?= $data['tanggal_masuk'] ?></td>
                                <td class="px-4 py-3">
                                    <a href="edit_barang.php?id=<?= $data['id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                                    <a href="hapus_barang.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs ml-2">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                </tbody>
                <tr>
                    <td colspan="7" class="text-center py-4">Data tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>
    <!-- Script Filter & Search -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterKategori = document.getElementById('filterKategori');
        const table = document.getElementById('tabelBarang');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const kategori = filterKategori.value.toLowerCase();

            for (let row of rows) {
                const namaBarang = row.cells[1].textContent.toLowerCase(); // nama barang
                const kategoriBarang = row.cells[2].textContent.toLowerCase(); // kategori

                const matchKeyword = namaBarang.includes(keyword);
                const matchKategori = kategori === "" || kategoriBarang === kategori;

                row.style.display = matchKeyword && matchKategori ? "" : "none";
            }
        }

        searchInput.addEventListener('input', filterTable);
        filterKategori.addEventListener('change', filterTable);
    </script>
    <div class='mt-2 justify-center flex'>
        <a href='kategori.php' class='px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700'>Tengok Kategori</a>
    </div>

</body>

</html>