<?php    
    session_start();
    if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
}
    include '../connection/db.php';

    $search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';


    $query_search = "SELECT products.*, user.username FROM products
                        JOIN user ON products.id_artist = user.id_user
                        WHERE products.nama LIKE '%$search%' OR products.kategori LIKE '%$search%'
                        OR user.username LIKE '%$search%' ORDER BY products.id_product DESC";
    $result = mysqli_query($link, $query_search);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Produk</title>
    <link rel="stylesheet" href="../css/search.css">
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
    <div class="container">
        <div class="search-box">
            <form action="search.php" id="search" method="get">
                <input type="text" name="search" placeholder="search..." class="input">
                <input type="submit" name="submit" value="search" class="submit">
            </form>
        </div>
        <div class="hasil"> 
            <?php if (mysqli_num_rows($result) > 0): ?>
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
            <?php else: ?>
                <p>Tidak ada produk yang ditemukan.</p>
            <?php endif; ?>
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