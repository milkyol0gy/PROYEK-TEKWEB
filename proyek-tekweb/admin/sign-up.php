<?php

session_start();
include "admin.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="../sign-up/global-signup.css" />
  <link rel="stylesheet" href="../sign-up/sign-up.css" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;800&display=swap" />
</head>

<body>
  <div class="register">
    <form action="sign-up.php" method="post">
      <img class="register-child" alt="" src="/Proyek Tekweb/sign-up/rectangle-1@2x.png" />

      <img class="logo-bli-n-go-2-1" alt="" src="/Proyek Tekweb/sign-up/logo-bli-n-go-2-1@2x.png" />

      <div class="get-started">Get Started!</div>
      <div class="we-provide-many">We provide many special variations at low prices!</div>
      <input type="text" name="uname" id="uname" class="input-uname" placeholder="Username">
      <input type="text" name="email" id="email" class="input-address" placeholder="Email">
      <input type="text" name="notelp" id="notelp" class="input-telp" placeholder="Phone Number">
      <input type="password" name="pass" id="pass" class="input-pass" placeholder="Password">
      <button type="submit" name="regist" id="regist" class="btn-regist"><b>REGISTER NOW</b></button>
    </form>
  </div>
</body>

</html>



<?php
if (isset($_POST['regist'])) {
  $uname = $_POST['uname'];
  $alamat = $_POST['email'];
  $notelp = $_POST['notelp'];
  $pass = $_POST['pass'];
  $check = Admin::check_Admin($uname);
  if ($check == 0) {
    $checkUname = Admin::check_uname($uname);
    if ($checkUname == $uname) {
      echo '<script>alert("Username sudah digunakan !");</script>';
    } else {
      $newUser = Admin::create_Admin(['username' => $uname, 'email' => $alamat, 'notelp' => $notelp, 'password' => $pass]);
      echo '<script>alert("Akun sudah dibuat !");</script>';
      header("Location: sign-in.php");
    }
  } else {
    echo '<script>alert("Akun sudah ada !");</script>';
  }
}
?>