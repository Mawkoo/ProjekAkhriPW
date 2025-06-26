 <?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include '../connection/db.php';

$id_artist = $_SESSION['id_user'];

$query = "SELECT * FROM products WHERE id_artist = '$id_artist'";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Saya</title>
    <link rel="stylesheet" href="../css/shop.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php if (isset($_GET['hapus'])): ?>
        <p style="color:green;">Produk berhasil dihapus!</p>
    <?php endif; ?>
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
        <div class="produk-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="produk-card">
                            <img src="../upload/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                            <div class="produk-info">
                                <a href="detailproduk.php?id=<?= $row['id_product'] ?>">
                                    <h3><?= htmlspecialchars($row['nama']) ?></h3>
                                    <p><?= htmlspecialchars($row['nama']) ?></p>
                                    <p>Harga: Rp<?= number_format($row['harga'], 0, ',', '.') ?>,-</p>
                                </a>
                                <hr>
                            </div> 
                        
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
            <p>Belum ada produk yang kamu tambahkan.</p>
        <?php endif; ?>
        </div>

        <a href="tambahproduk.php" class="btn-tambah">Tambah Produk</a>
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