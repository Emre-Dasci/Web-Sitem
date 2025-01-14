<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    
<div class="page">
  <div class="container">
    <div class="left">
      <div class="login">Admin Girişi</div>
    </div>
    <div class="right">
      <svg viewBox="0 0 320 300">
        <defs>
          <linearGradient
              inkscape:collect="always"
              id="linearGradient"
              x1="13"
              y1="193.49992"
              x2="307"
              y2="193.49992"
              gradientUnits="userSpaceOnUse">
            <stop
                  style="stop-color:#ff00ff;"
                  offset="0"
                  id="stop876" />
            <stop
                  style="stop-color:#ff0000;"
                  offset="1"
                  id="stop878" />
          </linearGradient>
        </defs>
        <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
      </svg>
      <form action="admin.php" method="post">
        <div class="form">
          <label>Kullanıcı Adı</label>
          <input type="text" name="adminkadi" required>
          <label>Parola</label>
          <input type="password" id="password" name="adminparola" required>
          <input type="submit" id="submit" value="Giriş Yap" name="gönder">
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>

<?php
session_start();
include("baglanti.php");

if (isset($_POST["gönder"])) {
    if (!empty($_POST["adminkadi"]) && !empty($_POST["adminparola"])) {
        $adminkadi = mysqli_real_escape_string($baglan, $_POST["adminkadi"]);
        $adminparola = $_POST["adminparola"];

        $sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = '$adminkadi'";
        $result = mysqli_query($baglan, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($adminparola, $user["parola"])) {
                $_SESSION["kullanici_adi"] = $user["kullanici_adi"];
                $_SESSION["yetki"] = $user["yetki"];

                if ($user["yetki"] == 1) {
                    header("location:admin_full.php");
                } else if ($user["yetki"] == 2) {
                    header("location:admin_limited.php");
                } else {
                    echo "<script>alert('Bu sayfayı görüntüleme yetkiniz yoktur.')</script>";
                }
            } else {
                echo "<script>alert('Kullanıcı Adı veya Şifre Hatalı')</script>";
            }
        } else {
            echo "<script>alert('Kullanıcı Adı veya Şifre Hatalı')</script>";
        }
    } else {
        echo "<script>alert('İlgili Yerleri Doldurunuz.')</script>";
    }
}
?>
