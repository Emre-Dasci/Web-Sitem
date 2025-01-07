<?php
include("baglanti.php");

if (isset($_POST["kayit"])) {
    header("location:kayit.php");
    exit();
}

if (isset($_POST["giris"])) {
    if (empty($_POST["kadi"])) {
        echo '<script>alert("Kullanıcı Adı Boş Geçilemez.");</script>';
    } elseif (empty($_POST["parola"])) {
        echo '<script>alert("Parola Boş Geçilemez.");</script>';
    } else {
        $kadi = mysqli_real_escape_string($baglan, $_POST["kadi"]);
        $parola = $_POST["parola"];

        $secim = "SELECT * FROM kullanicilar WHERE kullanici_adi = '$kadi'";
        $calistir = mysqli_query($baglan, $secim);
        $kayitsayisi = mysqli_num_rows($calistir);

        if ($kayitsayisi > 0) {
            $ilgilikayit = mysqli_fetch_assoc($calistir);
            $hashliparola = $ilgilikayit["parola"];
            if (password_verify($parola, $hashliparola)) {
                session_start();
                $_SESSION["kullanici_adi"] = $ilgilikayit["kullanici_adi"];
                $_SESSION["email"] = $ilgilikayit["email"];
                $_SESSION["yetki"] = $ilgilikayit["yetki"];
                header("location:kullanicianasayfa.php");
                exit();
            } else {
                echo '<script>alert("Parola Yanlış.");</script>';
            }
        } else {
            echo '<script>alert("Bu kullanıcı bulunamadı.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş</title>
    <link rel="stylesheet" href="../css/giris.css">
</head>
<body>
    <form action="giris.php" method="POST">
        <h2>Giriş</h2>
        <input type="text" name="kadi" placeholder="Kullanıcı Adı">
        <input type="password" name="parola" placeholder="Şifre">
        <input type="submit" name="giris" value="Giriş Yap">
        <input type="submit" name="kayit" value="Hesabım Yok">
    </form>
</body>
</html>
