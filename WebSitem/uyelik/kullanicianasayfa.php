<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_adi"]) || $_SESSION["kullanici_adi"] == "") {
    echo '<script>
        alert("Bu Sayfaya Erişmeye Yetkiniz Yoktur.");
        window.location.href = "giris.php";
    </script>';
    exit;
} else {
    $kullanici_adi = $_SESSION["kullanici_adi"];
    
    // Kullanıcının yetki ve üyelik bilgilerini al
    $stmt = $baglan->prepare("SELECT yetki, uyelik_bitis_tarihi FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->bind_param("s", $kullanici_adi);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $yetki = $row['yetki'];
        $uyelik_bitis_tarihi = $row['uyelik_bitis_tarihi'];

        // Yetki isteklerini kontrol et
        $stmt_istek = $baglan->prepare("SELECT durum FROM yetki_istekleri WHERE kullanici_adi = ?");
        $stmt_istek->bind_param("s", $kullanici_adi);
        $stmt_istek->execute();
        $istek_result = $stmt_istek->get_result();
        
        if ($istek_result->num_rows > 0) {
            $istek_row = $istek_result->fetch_assoc();
            $yetki_durumu = $istek_row['durum'];
            
            if ($yetki_durumu === 'beklemede') {
                $yetki = -1; // Yetki beklemede
            } elseif ($yetki_durumu === 'onaylandi') {
                $yetki = 2; // Yetki onaylandı
            }
        }
    } else {
        echo '<script>
            alert("Kullanıcı bulunamadı.");
            window.location.href = "giris.php";
        </script>';
        exit;
    }
    
    // Yetki al işlemi
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["yetki_al"]) && $yetki == 0) {
        $stmt = $baglan->prepare("INSERT INTO yetki_istekleri (kullanici_adi, durum) VALUES (?, 'beklemede')");
        $stmt->bind_param("s", $kullanici_adi);
        
        if ($stmt->execute() === TRUE) {
            echo '<script>alert("Yetki isteğiniz alınmıştır. Onay bekleniyor.");</script>';
            $yetki = -1; // Geçici olarak yetkiyi "beklemede" olarak ayarla
        } else {
            echo '<script>alert("Yetki isteği gönderilemedi: ' . $baglan->error . '");</script>';
        }
    }
}

if (isset($_POST["gönder"])) {
    $isim = $_POST["isim"];
    $telefon = $_POST["tel"];
    $email = $_POST["mail"];
    $konu = $_POST["konu"];
    $mesaj = $_POST["mesaj"];
    
    $ekle = "INSERT INTO iletisim (adsoyad, telefon, email, konu, mesaj) VALUES ('$isim','$telefon','$email','$konu','$mesaj')";
    $calistir =  mysqli_query($baglan, $ekle);
    
    if ($calistir) {
        echo '<script>alert("Mesajınız İletilmiştir.");</script>';
    } else {
        echo '<script>alert("Mesajınız İletilemedi.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Ana Sayfanız</title>
    <link rel='stylesheet' href='../css/Anasayfa.css'>
    
    <script>
        function startCountdown(endDate) {
            let countdownElement = document.getElementById("countdown");
            let end = new Date(endDate).getTime();
            
            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = end - now;
                
                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                countdownElement.innerHTML = "Kalan yetki süreniz: " + days + "g " + hours + "s " + minutes + "d " + seconds + "sn ";
                
                if (distance < 0) {
                    clearInterval(x);
                    countdownElement.innerHTML = "Yetki süresi doldu";
                }
            }, 1000);
        }

        function confirmLogout() {
            if (confirm("Çıkış yapmak istediğinize emin misiniz?")) {
                window.location.href = 'kullanicicikis.php';
            }
        }
    </script>
</head>
<body>
<section id='menu'>
    <div id='logo'>Sayfa Adı</div>
    <nav id='hg'>
        Hoş Geldiniz <?php echo htmlspecialchars($_SESSION["kullanici_adi"]); ?>
        <?php if ($yetki == 1): ?>
            <span id="yetki">Sınırsız yetkiye sahipsiniz</span>
        <?php elseif ($yetki == 0): ?>
            <span id="yetki">Henüz Bir Yetkiye Sahip Değilsiniz</span>
        <?php elseif ($yetki == -1): ?>
            <span id="yetki">Yetkiniz alınmıştır, onay aşamasında.</span>
        <?php elseif ($yetki == 2): ?>
            <span id="countdown"></span>
        <?php endif; ?>
        <a href='kullanicianasayfa.php'><img class='ikon' src='../resimler/home-button.png' width='20px' height='20px'>Anasayfa</a>
        <a id='cik' href="#" onclick="confirmLogout()">Çıkış Yap</a>
    </nav>
</section>

<section id='anasayfa'>
    <div id='black'></div>
    <div id='icerik'>
        <h2>Başlık</h2>
        <?php if ($yetki == 0): ?>
            <form method="POST" action="">
                <input type="submit" name="yetki_al" value="Yetki İste">
            </form>
        <?php elseif ($yetki == 2): ?>
            <p>Yetkiniz sınırlı erişime sahiptir.</p>
        <?php elseif ($yetki == -1): ?>
            <p>Yetki isteğiniz alınmıştır. Onay bekleniyor.</p>
        <?php endif; ?>
        <hr width='300px' align='left'>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eius consequuntur amet consequatur ut voluptatem corrupti quia a fugit reiciendis minima necessitatibus perspiciatis natus impedit consectetur, qui, assumenda earum, quo commodi?</p>
    </div>
</section>

<section id='hakkimizda'>
    <h3>Hakkımızda</h3>
    <div id='container'>
        <div id='sol'>
            <h5 id='h5sol'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti alias error suscipit, doloremque a aperiam similique!</h5>
        </div>
        <div id='sag'>
            <span>L</span>
            <p id='psag'>orem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis, quia dolore? Magnam error ipsam mollitia repudiandae optio possimus? Dolorem explicabo corporis laudantium sint. Maiores quasi fugiat omnis impedit ab iste.</p>
        </div>
        <img src='../resimler/guitar.jpg' width='1250' height='450'>
        <p id='pson'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corporis numquam magni fugiat. Modi tempora soluta, cupiditate ad nobis esse nesciunt quaerat labore reprehenderit dignissimos doloribus ipsa repellendus totam in laborum.</p>
    </div>
</section>

<section id="iletisim">

    <div class = "container"> 
        <h3 id = "h3iletisim"> İletişim </h3>
        
        <form action = "" method = "POST">
            
            <div id = "iletisimopak">
                
                <div id = "formgroup">
                    <div id = "solform">
                        <input type="text" name = "isim" placeholder = "Ad Soyad" required class = "formcontrol">
                        <input type="text" name = "tel" placeholder = "Telefon Numarası" required class = "formcontrol">
                    </div>
                    
                    <div id = "sagform">
                        <input type="email" name = "mail" placeholder = "E-mail Adresiniz" required class = "formcontrol">
                        <input type="text" name = "konu" placeholder = "Konu Başlığı" required class = "formcontrol">
                    </div>
                    
                    <textarea name="mesaj" id="" cols="30" placeholder = "Mesajınızı Giriniz" rows="10" required class = "formcontrol"></textarea>
                    <input type="submit" value="Gönder" name = "gönder">
                
                </div>
                
                <div id = "adres">

                    <h4 id = "adresbaslik">ADRES</h4>
                    <iframe src="https://www.google.com/maps/d/embed?mid=13p9KAQkoCaKK-sGzkmL0T-DfYJMT3DY&ehbc=2E312F" width="430" height="300"></iframe>
                    <p>Telefon Numarası : 05013722425</p>
                    <p>E-mail : edasci02@gmail.com</p>

                </div>
            </div>
        </form>
        
        <footer>
            <div id = "copyright"> 2024 Tüm Hakları Saklıdır </div>
            <div id = "socialfooter">
                <a href="#"><img src="../resimler/facebook.png" width="25" height="25"></a>
                <a href="#"><img src="../resimler/instagram.png" width="25" height="25"></a>
                <a href="#"><img src="../resimler/twitter.png" width="25" height="25"></a>
            </div>
            
            <a href="#menu"><img src="../resimler/up-arrow.png" width="25" id = "up" height="25"></a>
        </footer>
        
    </div>  
</section>

<?php if ($yetki == 2 && isset($uyelik_bitis_tarihi)): ?>
    <script>
        startCountdown("<?php echo $uyelik_bitis_tarihi; ?>");
    </script>
<?php endif; ?>
</body>
</html>
