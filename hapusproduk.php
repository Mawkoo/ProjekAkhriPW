<?php

session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
}

include '../connection/db.php';

if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan";
    exit;
}

$id_produk = $_GET['id'];

$query_check = "SELECT * FROM products WHERE id_product = '$id_produk'";
$result_check = mysqli_query($link, $query_check);

if (mysqli_num_rows($result_check) == 0) {
    echo "Produk tidak ditemukan atau sudah dihapus";
    exit;
}

$data = mysqli_fetch_assoc($result_check);
$foto_path = "../upload/" . $data['foto'];
if (file_exists($foto_path)) {
    unlink($foto_path);
}

$query = "DELETE FROM products WHERE id_product = '$id_produk'";
if (mysqli_query($link, $query)) {
    header("Location: shop.php?hapus=1");
    exit;
}
else {
    echo "Gagal menghapus produk: " . mysqli_error($link);
}
?>