<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlar</title>
    <link rel="stylesheet" href="../css/mesaj.css">
</head>
<body>

<h1>MESAJLAR</h1>

<table id="customers">
  <tr>
    <th>Ad Soyad</th>
    <th>Telefon</th>
    <th>E-Mail</th>
    <th>Konu</th>
    <th>Mesaj</th>
    <th>İşlem</th>
  </tr>

  <?php
    session_start();
    include("baglantipanel.php");

    if (!isset($_SESSION["user"]) || $_SESSION["authority"] > 2) {
        echo '
        <script> 
            alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
            window.location.href="admin.php";
        </script>';
        exit();
    }

    $sec = "SELECT * FROM iletisim";
    $sonuc = mysqli_query($baglan, $sec);
    $sayi = mysqli_num_rows($sonuc);

    if ($sayi > 0) {
        while ($cek = $sonuc->fetch_assoc()) {
            $id = $cek["id"];
            echo "
                <tr>
                    <td>" . $cek['adsoyad'] . "</td>
                    <td>" . $cek['telefon'] . "</td>
                    <td>" . $cek['email'] . "</td>
                    <td>" . $cek['konu'] . "</td>
                    <td>" . $cek['mesaj'] . "</td>
                    <td>
                        <div>
                            <a href='#' onclick='confirmDelete($id)'>Sil</a>
                        </div>
                    </td>
                </tr>
                ";
        }
    } else {
        echo '
            <tr>
                <td colspan="6">Mesaj bulunamadı.</td>
            </tr>';
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

function confirmDelete(id) {
    if (confirm("Silmek istediğinize emin misiniz?")) {
        window.location.href = "sil.php?id=" + id;
    }
}
</script>

</body>
</html>