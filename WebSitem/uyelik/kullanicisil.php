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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    
    // Kullanıcıyı veritabanından sil
    $stmt = $baglan->prepare("DELETE FROM kullanicilar WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo '<script>alert("Kullanıcı başarıyla silindi."); window.location.href = "kullanicilar.php";</script>';
    } else {
        echo '<script>alert("Kullanıcı silinemedi: ' . $baglan->error . '"); window.location.href = "kullanicilar.php";</script>';
    }

    $stmt->close();
}

$baglan->close();
?>
