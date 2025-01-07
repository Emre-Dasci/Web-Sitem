<?php
include("baglanti.php");

$bugun = date('Y-m-d');

$uyari_tarihi = date('Y-m-d', strtotime('+1 week'));

$sql = "SELECT * FROM kullanicilar WHERE uyelik_bitis_tarihi = '$uyari_tarihi'";
$result = mysqli_query($baglan, $sql);

while ($user = mysqli_fetch_assoc($result)) {
    $to = $user['email'];
    $subject = "Üyelik Bitiş Uyarısı";
    $message = "Sayın " . $user['kullanici_adi'] . ", üyeliğinizin bitmesine 1 hafta kaldı. Üyeliğinizi yenilemeyi unutmayın!";
    $headers = "From: admin@example.com";

    mail($to, $subject, $message, $headers);
}

$sql = "UPDATE kullanicilar SET yetki = 0 WHERE uyelik_bitis_tarihi < '$bugun'";
mysqli_query($baglan, $sql);

mysqli_close($baglan);
?>

