<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
}

include '../connection/db.php';

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id'];
$query = "SELECT * FROM products WHERE id_product = '$id_produk'";
$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) === 0 ) {
    echo "Produk tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/detailproduk.css">
</head>
<body>
    <div class="navbar" id="navbar">
        <div class="logo">MICE</div>
        <ul class="navlist">
            <li><a href="#">About</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Message</a></li>
            <li><a href="#">Pesanan</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><?php if (isset($_SESSION['username'])): ?>
                <a href="logout.php" class="logout-btn"
                    onclick="return confirm('Yakin mau Log Out?')">
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="body-produk">
        <h2>My Product</h2>
        <div class="produk-detail">
            <img src="../upload/<?=htmlspecialchars($data['foto']) ?>" alt="<?= htmlspecialchars($data['nama']) ?>">
            <div class="produk-info">
                <h2><?=htmlspecialchars($data['nama']) ?></h2>
                <p><strong><?= htmlspecialchars($data['kategori']) ?></strong></p><br>
                <p>Harga: Rp<?= number_format($data['harga'], 0, ',','.') ?></p><br>
                <p><strong>Deskripsi:</strong><br>
                <?= nl2br(htmlspecialchars($data['deskripsi'])) ?>
                </p> <br>
                <p><strong>Pre-Order dalam:</strong><br>
                <?=htmlspecialchars($data['estimasi'])?>
                </p>
            </div>           
        </div>
        <div class="btn-grp">
            <a href="editproduk.php?id=<?= $data['id_product'] ?>">Edit Produk</a>
            <a href="pesanan.php?id=<?= $data['id_product'] ?>">Lihat Pesanan</a>
            <a href="hapusproduk.php?id=<?= $data['id_product'] ?>" onclick="return confirm('Yakin mau hapus produk ini?')">Hapus</a>
        </div>
    </div>

    <script>
        let lastScrollTop = 0;
        const navbar = document.getElementById("navbar");

        window.addEventListener("scroll", function () {
            let scrollTop = window.scrollY || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                navbar.classList.add("hide-navbar");
            }
            else {
                navbar.classList.remove("hide-navbar");
            }

            lastScrollTop = scrollTop;
        });
    </script>
</body>
</html>