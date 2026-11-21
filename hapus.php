<?php
include_once 'koneksi.php';

// Mengambil ID barang dari URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID barang tidak ditemukan.");
}

// Query untuk menghapus data
$sql = "DELETE FROM data_barang WHERE id_barang = '$id'";

$result = mysqli_query($conn, $sql);

if ($result) {
    header('location: index.php');
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
