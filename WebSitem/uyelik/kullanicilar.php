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

// Tüm kullanıcı bilgilerini, şifreler dahil olmak üzere getiriyoruz
$result = $baglan->query("SELECT id, kullanici_adi, email, yetki, parola FROM kullanicilar WHERE id != 1");
?>

<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Kullanıcılar</title>
    <link rel='stylesheet' href='../css/kullanicilar.css'>
</head>
<body>
    <div class="container">
        <h1>Kullanıcılar</h1>
        <table id="customers">
            <tr>
                <th>ID</th>
                <th>Kullanıcı Adı</th>
                <th>E-Mail</th>
                <th>Yetki</th>
                <th>Şifre</th> <!-- Şifre sütunu eklendi -->
                <th>İşlemler</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['kullanici_adi']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['yetki']); ?></td>
                <td><?php echo htmlspecialchars($row['parola']); ?></td> <!-- Şifre sütunundaki veri -->
                <td>
                    <form method="POST" action="kullanicisil.php" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="submit" name="sil" value="Sil" class="btn btn-danger">
                    </form>
                    <form method="GET" action="yetki_duzenle.php">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="submit" name="duzenle" value="Yetki Düzenle" class="btn btn-edit">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="#" onclick="return confirmLogout()" class="btn btn-logout">Çıkış Yap</a>
    </div>

    <script>
    function confirmLogout() {
    if (confirm("Çıkış yapmak istediğinize emin misiniz?")) {
        window.location.href = "cikis.php";
    } else {
        return false;
    }
}
    </script>
</body>
</html>

<?php
$baglan->close();
?>
