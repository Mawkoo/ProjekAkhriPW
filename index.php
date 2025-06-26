<?php

session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
}
    include '../connection/db.php';

$query = "SELECT products.*, user.username
        FROM products
        JOIN user ON products.id_artist = user.id_user
        ORDER BY id_product DESC 
        LIMIT 3";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        <h2>Fresh Drops</h2>
        <div class="popular-produk">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="product-card">
                    <a href="detail.php?id=<?= $row['id_product'] ?>">
                        <img src="../upload/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                        <div class="produk-info">
                            <h4><?= htmlspecialchars($row['username']) ?></h4>
                            <p><?= htmlspecialchars($row['nama']) ?></p>
                            <p>Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
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