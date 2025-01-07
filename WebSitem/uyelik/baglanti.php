<?php
    $vt_sunucu = "localhost";
    $vt_kullanici = "root";
    $vt_sifre = "";
    $vt_adi = "uyelik";

    $baglan = mysqli_connect($vt_sunucu, $vt_kullanici, $vt_sifre, $vt_adi);

    if(!$baglan) {
        die("Bağlantı başarısız: " . mysqli_connect_error());
    }
    
    $baglan->set_charset("utf8");

?>
