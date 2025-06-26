<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
}

include '../connection/db.php';

if (!isset($_GET['id'])) {
    // cek kalo id produk tidak dikirim
    echo "Produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id'];

//ambil data produk dari db
$query = "SELECT * FROM products WHERE id_product = '$id_produk'";
$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Produk tidak ditemukan.";
    exit;
}
$data = mysqli_fetch_assoc($result);
$estimasi_angka = preg_replace('/[^0-9]/', '', $data['estimasi']);


$arr_cat_crop = array("Headshot / Icon",
                      "Bust Up / Chest Up",
                      "Half Body",
                      "Thigh Up / Knee Up",
                      "Full Body"
);

$arr_cat_jml = array("Single Character",
                     "Couple / Duo",
                     "Group / Party (3 orang keatas)"
);

$arr_cat_theme = array("Chibi",
                       "Realistic / Semi-Realistic",
                       "Anime Style",
                       "Cartoon Style",
                       "Sketch / Lineart Only",
                       "Flat Color",
                       "Fully Rendered / Painted"
);

$arr_cat_ops = array("-None-",
                     "Background",
                     "Props",
                     "Outfit Design / Custom Costume",
                     "NSFW / SFW",
                     "Emote / VTuber Asset / PNGtuber",
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $estimasi = $_POST['estimasi'] . 'hari';

    //ambil kategori dari form select
    $crop = $_POST['crop'];
    $jml = $_POST['jml'];
    $theme = $_POST['theme'];
    $ops = $_POST['ops'];
    
    //gabung kategori
    $kategori = "$crop | $jml | $theme";
    if ($ops !== "-None-") {
        $kategori .= " | $ops";
    }

    if ($_FILES['foto']['name'] != '') {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $folder = "../upload/" . $foto;

        if (move_uploaded_file($tmp, $folder)) {
            $query = "UPDATE products SET
                      nama = '$nama',
                      deskripsi = '$deskripsi',
                      harga = '$harga',
                      estimasi = '$estimasi',
                      kategori = '$kategori',
                      foto = '$foto'
                      WHERE id_product = '$id_produk'";
        }
        else {
            echo "Upload gambar gagal.";
        }
    }
    else {
        // tanpa upload gambar
        $query = "UPDATE products SET
                  nama = '$nama',
                  deskripsi = '$deskripsi',
                  harga = '$harga',
                  estimasi = '$estimasi',
                  kategori = '$kategori'
                  WHERE id_product = '$id_produk'";
    }

    if (mysqli_query($link, $query)) {
        header("Location: detailproduk.php?id=$id_produk&update=1");
    }
    else {
        echo "Gagal Update: " .mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../css/editproduk.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="navbar" id="navbar">
        <div class="logo">MICE</div>
        <ul class="navlist">
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
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
    <h2>Edit Produk</h2>
        <div class="form-container">
            <?php 
            if (isset($_GET['success'])):
            ?>
                <p style="color:green;">Produk Berhasil diedit!</p>
            <?php endif; ?>

            <form action="editproduk.php?id=<?= $id_produk?>" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <strong>Foto Produk</strong><br>
                    <input type="file" name="foto">
                    <img src="../upload/<?= htmlspecialchars($data['foto']) ?>" alt="">  
                </div>
                
                <div class="input-field">
                    <strong>Nama Produk</strong><br>
                    <input type="text" name="nama" maxlength="255" required value="<?= htmlspecialchars($data['nama']) ?>">
                    <span>0/255</span>
                </div>

                <div class="input-field">
                    <strong>Kategori:</strong><br> 
                    <div class="categ">
                        <label for="">Kategori Berdasarkan Crop (Bagian Tubuh): <br></label>
                        <select name="crop" id="crop">
                            <?php
                            foreach ($arr_cat_crop as $crop) {
                                echo "<option value=\"$crop\" " . (strpos($data['kategori'], $crop) !== false ? 'selected' : '') . ">$crop</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="categ">
                        <label for="">Kategori Berdasarkan Jumlah Karakter: <br></label>
                        <select name="jml" id="jml">
                            <?php
                            foreach ($arr_cat_jml as $jml) {
                                echo "<option value=\"$jml\" " . (strpos($data['kategori'], $jml) !== false ? 'selected' : '') . ">$jml</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="categ">
                        <label for="">Kategori Berdasarkan Tema / Gaya: <br></label>
                        <select name="theme" id="theme">
                            <?php
                            foreach ($arr_cat_theme as $theme) {
                                echo "<option value=\"$theme\" " . (strpos($data['kategori'], $theme) !== false ? 'selected' : '') . ">$theme</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="categ">
                        <label for="">Kategori Tambahan (opsional): <br></label>
                        <select name="ops" id="ops">
                            <?php
                            foreach ($arr_cat_ops as $ops) {
                                echo "<option value=\"$ops\" " . (strpos($data['kategori'], $ops) !== false ? 'selected' : '') . ">$ops</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-text">
                    <strong>Deskripsi: <br></strong>
                    <textarea name="deskripsi" id="deskripsi" maxlength="3000" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                    <span class="count">0/3000</span>
                </div>
                <div class="input-field">
                    <strong>Harga (contoh: 10000): <br></label>
                    <input type="number" name="harga" required value="<?= htmlspecialchars($data['harga']) ?>">
                </div>
                <div class="input-field">
                    <strong>Estimasi Selesai (dalam hari):</strong><br>
                    <input type="number" name="estimasi" min="1" required value="<?= htmlspecialchars($estimasi_angka) ?>"><br><br>
                </div>
                <input type="submit" name="submit" value="Simpan Perubahan" class="btn">
            </form>
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