<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_adi"]) || $_SESSION["yetki"] != 1) {
    echo '<script>
        alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
        window.location.href = "admin.php";
    </script>';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["onayla"])) {
    $kullanici_adi = $_POST["kullanici_adi"];
    $uyelik_bitis_tarihi = date('Y-m-d', strtotime('+1 year')); 
    $stmt = $baglan->prepare("UPDATE kullanicilar SET yetki = 2, uyelik_bitis_tarihi = ? WHERE kullanici_adi = ?");
    $stmt->bind_param("ss", $uyelik_bitis_tarihi, $kullanici_adi);
    
    if ($stmt->execute() === TRUE) {
        $stmt = $baglan->prepare("UPDATE yetki_istekleri SET durum = 'onaylandi' WHERE kullanici_adi = ?");
        $stmt->bind_param("s", $kullanici_adi);
        $stmt->execute();
        echo '<script>alert("Yetki onaylandı.");</script>';
    } else {
        echo '<script>alert("Yetki onaylanamadı: ' . $baglan->error . '");</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reddet"])) {
    $kullanici_adi = $_POST["kullanici_adi"];
    $stmt = $baglan->prepare("UPDATE yetki_istekleri SET durum = 'reddedildi' WHERE kullanici_adi = ?");
    $stmt->bind_param("s", $kullanici_adi);
    $stmt->execute();
    echo '<script>alert("Yetki reddedildi.");</script>';
}

$result = $baglan->query("SELECT * FROM yetki_istekleri WHERE durum = 'beklemede'");
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Yetki İstekleri</title>
    <link rel='stylesheet' href='../css/yetki_istekleri.css'>
</head>
<body>
<section id='menu'>
    <div id='logo'>Admin Paneli</div>
    <nav id='hg'>
        <a id='cik' href="#" onclick="confirmLogout()">Çıkış Yap</a>
    </nav>
</section>

<section id='anasayfa'>
    <div id='black'></div>
    <div id='icerik'>
        <h2>Yetki İstekleri</h2>
        <table>
            <tr>
                <th>Kullanıcı Adı</th>
                <th>İstek Tarihi</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['kullanici_adi']); ?></td>
                <td><?php echo htmlspecialchars($row['istek_tarihi']); ?></td>
                <td><?php echo htmlspecialchars($row['durum']); ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="kullanici_adi" value="<?php echo htmlspecialchars($row['kullanici_adi']); ?>">
                        <input type="submit" name="onayla" value="Onayla">
                        <input type="submit" name="reddet" value="Reddet">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>

<script>
    function confirmLogout() {
        if (confirm("Çıkış yapmak istediğinize emin misiniz?")) {
            window.location.href = 'cikis.php';
        }
    }
</script>

</body>
</html>
