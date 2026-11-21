
<?php
include("koneksi.php");

// Query untuk mengambil semua data barang
$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
</head>
<body>

    <h1>Data Barang</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php if ($result): ?>
            <?php while ($row = mysqli_fetch_array($result)): ?>
                <tr>
                    <td><?= $row['id_barang']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><?= $row['harga_beli']; ?></td>
                    <td><?= $row['harga_jual']; ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td>
    <a href="hapus.php?id=<?= $row['id_barang']; ?>"
       onclick="return confirm('Yakin ingin menghapus data ini?')">
       Hapus
    </a>
</td>
                    <td>
    <a href="ubah.php?id=<?= $row['id_barang']; ?>">Edit</a>
</td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Belum ada data</td>
            </tr>
        <?php endif; ?>

    </table>

</body>
</html>
