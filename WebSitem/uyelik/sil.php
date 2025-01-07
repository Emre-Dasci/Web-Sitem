<?php
session_start();
include("baglantipanel.php");

if (!isset($_SESSION["user"]) || $_SESSION["authority"] > 2) {
    echo '
    <script>
        alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
        window.location.href = "Anasayfa.php";
    </script>';
    exit();
}

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    echo '
    <script>
        alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
        window.location.href = "admin.php";
    </script>';
    exit();
}

$id = intval($_GET["id"]);
$sil = "DELETE FROM iletisim WHERE id=$id";

if (mysqli_query($baglan, $sil)) {
    echo '<script>
            alert("Silme İşlemi Başarılı.");
            window.location.href = "mesaj.php";
          </script>';
} else {
    echo '<script>
            alert("Silme İşlemi Başarısız.");
            window.location.href = "mesaj.php";
          </script>';
}

mysqli_close($baglan);
?>

