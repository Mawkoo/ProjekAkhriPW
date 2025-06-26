<?php

if (isset($_GET["pesan"])) {
    $pesan = $_GET["pesan"];
}

if (isset($_POST["submit"])) {
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    $pesan_error="";

    if (empty($username)) {
        $pesan_error.="Username belum diisi <br>";
    }

    include '../connection/db.php';
    $username = mysqli_real_escape_string($link, $username);
    $password = mysqli_real_escape_string($link, $password);

    $password_sha1 = sha1($password);

    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password_sha1'";
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result) == 0) {
        $pesan_error .= "username dan/atau password tidak sesuai";
    }

    else {
    $row = mysqli_fetch_assoc($result);

    session_start();
    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['username'] = $row['username'];
    
    mysqli_free_result($result);
    mysqli_close($link);

    header("Location: index.php");
    
    }
}
else {
    $pesan_error = "";
    $username = "";
    $password = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $pesan_error !== ""): ?>
    <script>
        alert(<?= json_encode ($pesan_error) ?>);
    </script>
    <?php endif; ?>
    <div class="container">
        <form action="login.php" method="post">
            <h3>Log in</h3>
            <div class="form-container">
                <div class="input-box">
                <div class="field-input">
                    <input type="text" name="username" placeholder="Masukkan Username">
                </div>
                <div class="field-input">
                    <input type="password" name="password" placeholder="Masukkan Password">
                </div>
            </div>
                <div class="klmt">
                    <P><a href="#">Lupa Password</a></P>
                    <p><a href="regisration.php">Belum punya akun?</a></p>
                </div>
                
                <input type="submit" name="submit" class="btn" value="LOG IN">
            </div>
        </form>
    </div>
</body>
</html>
