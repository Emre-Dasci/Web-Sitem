<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin_full.css">
</head>
<body>
    <div class="container">
        <h1>Admin Paneli</h1>
        <nav class="navigation">
            <a href="goster.php?tablo=iletisim">Mesajlar</a>
            <a href="yetki_istekleri.php">Yetki İstekleri</a>
            <a href="kullanicilar.php">Kullanıcılar</a>
            <a href="#" onclick="return confirmLogout()">Çıkış Yap</a>
        </nav>
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
