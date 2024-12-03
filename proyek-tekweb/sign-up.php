<?php
  include "database/user.php";
  if (isset($_POST['regist'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $uname = isset($_POST['uname']) ? $_POST['uname'] : null;
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
    $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : null;
    $pass = isset($_POST['pass']) ? $_POST['pass'] : null;
    if ($email === null) {
      echo "<script>window.alert('Email tidak boleh kosong !')</script>";
      exit();
    }
    $check = User::check_User($uname);
    if ($check == 0) {
      $checkUname = User::check_uname($uname);
      if ($checkUname == $uname) {
        echo "<script>window.alert('Username sudah digunakan !');</script>";
      } else {
        header("Location:/proyek-tekweb/sign-in.php");
        $newUser = User::create_User(['email' => $email, 'username' => $uname, 'alamat' => $alamat, 'notelp' => $notelp, 'password' => $pass]);
        exit();
      }
    } else {
      echo "<script>window.alert('Akun sudah ada !');</script>";
    }

  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <title>BLI n GO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="/Proyek Tekweb/sign-up/global-signup.css" />
    <link rel="stylesheet" href="/Proyek Tekweb/sign-up/sign-up.css" />
    <script>
      function concatAlamat(){
        var namajln = $('#namajln').val();
        var provinsi = $('#provinsi').val();
        var kota = $('#kota').val();
        var kecamatan = $('#kecamatan').val();
        var kodepos = $('#kodepos').val();
        var fullAddress = namajln + ', ' + kecamatan + ', ' + kota + ', ' + provinsi + ', ' + kodepos;
        $('#address-btn').html(fullAddress);
        $('#input-alamat').val(fullAddress);
      }
    </script>
  </head>
  <body>
    <div class="register">
      <form action="sign-up.php" method="post">
        <img class="register-child" alt="" src="/Proyek Tekweb/sign-up/rectangle-1@2x.png" />

        <img class="logo-bli-n-go-2-1" alt="" src="/Proyek Tekweb/sign-up/logo-bli-n-go-2-1@2x.png"/>

        <div class="get-started">Get Started!</div>
        <div class="we-provide-many">We provide many special variations at low prices!</div>
        <input type="email" name="email" id="email" class="input-name" placeholder="Email">
        <input type="text" name="uname" id="uname" class="input-uname" placeholder="Username">
        <button id="address-btn" type="button" data-bs-toggle="modal" data-bs-target="#address" 
        class="input-address" style=" text-align: left;color: #1b385f;">Address</button>

          <div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: 800;">Address</h5>
                <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <label for="provinsi">Provinsi</label>
                <input type="text" class="form-control" id="provinsi">
                <label for="kota">Kota</label>
                <input type="text" class="form-control" id="kota">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan">
                <label for="kodepos">Kode Pos</label>
                <input type="text" class="form-control" id="kodepos">
                <label for="namajln">Nama Jalan, Gedung, No. Rumah</label>
                <input type="text" class="form-control" id="namajln">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="concatAlamat()">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
            </div>
          </div>
          <input type="hidden" name="alamat" id="input-alamat" value="Rungkut"> 
        <input type="text" name="notelp" id="notelp" class="input-telp" placeholder="Phone Number">
        <input type="password" name="pass" id="pass" class="input-pass" placeholder="Password">
        <button type="submit" name="regist" id="regist" class="btn-regist"><b>REGISTER NOW</b></button>
      </form>
    </div>
  </body>
</html>