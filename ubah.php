<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

// Proses menyimpan perubahan
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    if ($file_gambar['error'] == 0) {
        $filename = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/gambar/' . $filename;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = 'gambar/' . $filename;
        }
    }

    $sql = "UPDATE data_barang SET
            nama = '$nama',
            kategori = '$kategori',
            harga_jual = '$harga_jual',
            harga_beli = '$harga_beli',
            stok = '$stok'";

    if (!empty($gambar)) {
        $sql .= ", gambar = '$gambar'";
    }

    $sql .= " WHERE id_barang = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: index.php');
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($conn);
    }
}

// Mengambil data barang berdasarkan ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID barang tidak ditemukan.");
}

$sql = "SELECT * FROM data_barang WHERE id_barang = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Data tidak tersedia.");
}

$data = mysqli_fetch_array($result);

function is_select($var, $val) {
    if ($var == $val) {
        return 'selected="selected"';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Barang</title>
</head>
<body>

    <h1>Ubah Barang</h1>

    <form method="post" action="ubah.php"
          enctype="multipart/form-data">

        <input type="hidden" name="id"
               value="<?= $data['id_barang']; ?>">

        <p>
            <label>Nama Barang</label><br>
            <input type="text" name="nama"
                   value="<?= $data['nama']; ?>" required>
        </p>

        <p>
            <label>Kategori</label><br>
            <select name="kategori">
                <option value="Komputer"
                    <?= is_select($data['kategori'], 'Komputer'); ?>>
                    Komputer
                </option>

                <option value="Elektronik"
                    <?= is_select($data['kategori'], 'Elektronik'); ?>>
                    Elektronik
                </option>

                <option value="Hand Phone"
                    <?= is_select($data['kategori'], 'Hand Phone'); ?>>
                    Hand Phone
                </option>
            </select>
        </p>

        <p>
            <label>Harga Jual</label><br>
            <input type="number" name="harga_jual"
                   value="<?= $data['harga_jual']; ?>" required>
        </p>

        <p>
            <label>Harga Beli</label><br>
            <input type="number" name="harga_beli"
                   value="<?= $data['harga_beli']; ?>" required>
        </p>

        <p>
            <label>Stok</label><br>
            <input type="number" name="stok"
                   value="<?= $data['stok']; ?>" required>
        </p>

        <p>
            <label>Ganti Gambar (opsional)</label><br>
            <input type="file" name="file_gambar"
                   accept="image/*">
        </p>

        <button type="submit" name="submit">Simpan Perubahan</button>

    </form>

    <br>
    <a href="index.php">Kembali</a>

</body>
</html>
