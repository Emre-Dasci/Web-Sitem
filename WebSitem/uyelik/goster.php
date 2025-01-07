<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablo Gösterimi</title>
    <link rel="stylesheet" href="../css/mesaj.css">
</head>
<body>

<h1>Tablo Gösterimi</h1>

<table id="customers">
  <tr>
    <?php
    session_start();
    include("baglantipanel.php");

    if (!isset($_SESSION["kullanici_adi"]) || ($_SESSION["yetki"] != 1 && $_SESSION["yetki"] != 2)) {
        echo '
        <script> 
            alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
            window.location.href="Anasayfa.php";
        </script>';
        exit();
    }

    $tablo = $_GET['tablo'];

    if ($_SESSION["yetki"] == 1) {
        $sec = "SELECT * FROM $tablo";
    } else if ($_SESSION["yetki"] == 2) {
        if ($tablo == "iletisim") {
            $sec = "SELECT konu, mesaj FROM iletisim";
        } else {
            echo '
            <script> 
                alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
                window.location.href="Anasayfa.php";
            </script>';
            exit();
        }
    } else if ($_SESSION["yetki"] == 0) {
        echo '
        <script> 
            alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
            window.location.href="admin.php";
        </script>';
        exit();
    }

    $sonuc = mysqli_query($baglan, $sec);
    $sayi = mysqli_num_rows($sonuc);

    if ($_SESSION["yetki"] == 1) {
        echo "
        <th>ID</th>
        <th>Ad Soyad</th>
        <th>Telefon</th>
        <th>E-Mail</th>
        <th>Konu</th>
        <th>Mesaj</th>
        <th>İşlem</th>";
    } else if ($_SESSION["yetki"] == 2) {
        echo "
        <th>Konu</th>
        <th>Mesaj</th>";
    }

    if ($sayi > 0) {
        while ($cek = $sonuc->fetch_assoc()) {
            echo "<tr>";
            if ($_SESSION["yetki"] == 1) {
                $id = $cek["id"];
                echo "
                <td>" . $cek['id'] . "</td>
                <td>" . $cek['adsoyad'] . "</td>
                <td>" . $cek['telefon'] . "</td>
                <td>" . $cek['email'] . "</td>
                <td>" . $cek['konu'] . "</td>
                <td>" . $cek['mesaj'] . "</td>
                <td>
                    <div>
                        <a href='sil.php?id=$id'>Sil</a>
                    </div>
                </td>";
            } else if ($_SESSION["yetki"] == 2) {
                echo "
                <td>" . $cek['konu'] . "</td>
                <td>" . $cek['mesaj'] . "</td>";
            }
            echo "</tr>";
        }
    } else {
        echo '<tr><td colspan="6">Mesaj bulunamadı.</td></tr>';
    }

    mysqli_close($baglan);
  ?>  
</table>

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
