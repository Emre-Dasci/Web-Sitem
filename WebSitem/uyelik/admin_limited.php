<!DOCTYPE html> 
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin_limited.css">
</head>
<body>
<h1>Admin Paneli (Sınırlı Erişim)</h1>
<a href="goster.php?tablo=iletisim">Mesajlar</a>
<a href="#" onclick="return confirmLogout()">Çıkış Yap</a>

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
