<?php
include("baglanti.php");

if (isset($_POST["giris"])) {
    header("location:giris.php");
    exit();
}

if (isset($_POST["kayit"])) {
    if (empty($_POST["kadi"])) {
        echo '<script>alert("Kullanıcı Adı Boş Geçilemez.");</script>';
    } elseif (empty($_POST["email"])) {
        echo '<script>alert("E-Mail Adresi Boş Geçilemez.");</script>';
    } elseif (empty($_POST["parola"])) {
        echo '<script>alert("Parola Boş Geçilemez.");</script>';
    } else {
        $isim = mysqli_real_escape_string($baglan, $_POST["kadi"]);
        $email = mysqli_real_escape_string($baglan, $_POST["email"]);
        $sifre = password_hash($_POST["parola"], PASSWORD_DEFAULT);

        $uyelik_bitis_tarihi = date('Y-m-d', strtotime('+1 year'));

        $ekle = "INSERT INTO kullanicilar (kullanici_adi, email, parola, uyelik_bitis_tarihi) VALUES ('$isim','$email','$sifre', '$uyelik_bitis_tarihi')";
        $calistir = mysqli_query($baglan, $ekle);

        if ($calistir) {
            echo '<script>
                alert("Kayıt Başarıyla Yapılmıştır.");
                window.location.href = "giris.php";
            </script>';
        } else {
            echo '<script>
                alert("Kayıt Yapılamadı.");
            </script>';
        }
        mysqli_close($baglan);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt</title>
    <link rel="stylesheet" href="../css/kayit.css">
</head>
<body>
    <form action="kayit.php" method="POST">
        <h2>Kayıt Ol</h2>
        <input type="text" name="kadi" placeholder="Kullanıcı Adı"> 
        <input type="email" name="email" placeholder="E-Mail">
        <input type="password" name="parola" placeholder="Şifre">
        <input type="submit" name="kayit" value="Kayıt Ol">
        <input type="submit" name="giris" value="Hesabım Var">
    </form>
</body>
</html>
