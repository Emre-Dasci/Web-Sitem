<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_adi"]) || $_SESSION["yetki"] != 1) {
    echo '<script>
        alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
        window.location.href = "giris.php";
    </script>';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $result = $baglan->query("SELECT * FROM kullanicilar WHERE id = $id");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo '<script>
            alert("Kullanıcı bulunamadı.");
            window.location.href = "kullanicilar.php";
        </script>';
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["yetki"])) {
    $id = intval($_POST["id"]);
    $yetki = intval($_POST["yetki"]);

    $stmt = $baglan->prepare("UPDATE kullanicilar SET yetki = ? WHERE id = ?");
    $stmt->bind_param("ii", $yetki, $id);

    if ($stmt->execute()) {
        echo '<script>alert("Yetki başarıyla güncellendi."); window.location.href = "kullanicilar.php";</script>';
    } else {
        echo '<script>alert("Yetki güncellenemedi: ' . $baglan->error . '"); window.location.href = "kullanicilar.php";</script>';
    }

    $stmt->close();
    $baglan->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Yetki Düzenle</title>
    <link rel='stylesheet' href='../css/yetki_duzenle.css'>
</head>
<body>
<h1>Yetki Düzenle</h1>

<form method="POST" action="yetki_duzenle.php">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
    <label for="yetki">Yetki:</label>
    <select name="yetki" id="yetki">
        <option value="0" <?php if ($user['yetki'] == 0) echo 'selected'; ?>>Yetki Yok</option>
        <option value="2" <?php if ($user['yetki'] == 2) echo 'selected'; ?>>Sınırlı Yetki</option>
        <option value="1" <?php if ($user['yetki'] == 1) echo 'selected'; ?>>Tam Yetki</option>
    </select>
    <input type="submit" value="Güncelle">
</form>

<a href="kullanicilar.php">Geri Dön</a>

</body>
</html>
