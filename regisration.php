<?php
    include '../connection/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MICE - Artist Registration Page</title>
    <link rel="stylesheet" type="text/css" href="../css/artist_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Daftar Sekarang</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Username <span>*</span></p>
                        <input type="text" name="nama" placeholder="masukkan nama anda" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Email <span>*</span></p>
                        <input type="email" name="email" placeholder="masukkan email anda" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Password <span>*</span></p>
                        <input type="password" name="pass" placeholder="masukkan password anda" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Konfirmasi Password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="konfirmasi password anda" required class="box">
                    </div>
                </div>
                <p class="link">sudah punya akun? <a href="login.php">Login sekarang</a></p>
                <input type="submit" name="submit" value="Daftar" class="btn">
            </div>
        </form>
    </div>
</body>
</html>