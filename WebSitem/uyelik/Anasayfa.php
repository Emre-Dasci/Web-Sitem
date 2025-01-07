<?php
    session_start();
    include("baglantipanel.php");

    if(isset($_POST["gönder"]))
    {
        $isim = $_POST["isim"];
        $telefon = $_POST["tel"];
        $email = $_POST["mail"];
        $konu = $_POST["konu"];
        $mesaj = $_POST["mesaj"];
        
        $ekle = "INSERT INTO iletisim (adsoyad, telefon, email, konu, mesaj) VALUES ('$isim','$telefon','$email','$konu','$mesaj')";
        $calistir =  mysqli_query($baglan,$ekle);
        
        if($calistir)
        {
            echo'<script>alert("Mesajınız İletilmiştir.");</script>' ;
        }
        
        else    
        {
            echo'<script>alert("Mesajınız İletilemedi.");</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="../css/Anasayfa.css">
    
</head>

<body>

<section id="menu">
    <div id="logo">Sayfa Adı</div>
    <nav>
        
        <a href="Anasayfa.php"><img class="ikon" src="../resimler/home-button.png" width="20px" height="20px">Anasayfa</a>
        <a href="giris.php"><img class="ikon" src="../resimler/login.png" width="20px" height="20px">Giriş</a>
        <a href="kayit.php"><img class="ikon" src="../resimler/signup.png" width="20px" height="20px">Kayıt Ol</a>
    
    </nav>

</section>

<section id="anasayfa">

    <div id="black"> 
        
    </div>

    <div id = "icerik">

        <h2>Başlık</h2>
        <hr width = 300px ,align =left>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eius consequuntur amet consequatur ut voluptatem corrupti quia a fugit reiciendis minima necessitatibus perspiciatis natus impedit consectetur, qui, assumenda earum, quo commodi?</p>
    
    </div>

</section>

<section id = "hakkimizda">

    <h3>Hakkımızda</h3>
    
    <div id="container">

        <div id="sol">
            <h5 id="h5sol">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti alias error suscipit, doloremque a aperiam similique!</h5>
        </div>

        <div id="sag">
            <span>L</span>
            <p id="psag">orem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis, quia dolore? Magnam error ipsam mollitia repudiandae optio possimus? Dolorem explicabo corporis laudantium sint. Maiores quasi fugiat omnis impedit ab iste.</p>
        </div>

        <img src="../resimler/guitar.jpg"class="img-fluid">

        <p id="pson">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corporis numquam magni fugiat. Modi tempora soluta, cupiditate ad nobis esse nesciunt quaerat labore reprehenderit dignissimos doloribus ipsa repellendus totam in laborum.</p>
    
    </div>

</section>

<section id="iletisim">

    <div class = "container"> 
        <h3 id = "h3iletisim">İletişim</h3>
        <form action="Anasayfa.php" method="POST">
            <div id = "iletisimopak">
                <div id = "formgroup">
                    <h4 id = "mesajbaslik">MESAJINIZ</h4>
                    <div id = "solform">
                        <input type="text" name="isim" placeholder = "Ad Soyad" required class = "form-control">
                        <input type="text" name ="tel" placeholder = "Telefon Numarası" required class = "form-control">
                    </div>
                    <div id = "sagform">
                        <input type="email" name="mail" placeholder = "E-mail Adresiniz" required class = "form-control">
                        <input type="text" name ="konu" placeholder = "Konu Başlığı" required class = "form-control">
                    </div>

                    <textarea name="mesaj" placeholder="Mesajınızı Girin" cols="30" rows="10" required class = "form-control"></textarea>
                    <input type="submit" name="gönder" value="Gönder">

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

            <div id="copyright">2022 | Tüm Hakları Saklıdır.</div>
            <div id="socialfooter">
                    <a href="www.linkedin.com/in/emredasci" target="_blank"><img class="social" src="../resimler/instagram.png" width="35px" height="35px"></a>
                    <a href="https://www.facebook.com/karbonat.recai.1/" target="_blank"><img class="social" src="../resimler/facebook.png" width="35px" height="35px"></a>
                    <a href="https://www.linkedin.com/in/emre-daşci-b82472259/" target="_blank"><img class="social" src="../resimler/linkedin.png" width="35px" height="35px"></a>
            
                </div>

        </footer>   

        <a href="#menu"><img id = "up" src="../resimler/arrow.png" width="50px" height="50px"></a>

    </div>    
    
</section>

</body>
</html>
