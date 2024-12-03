<?php
include 'admin.php';

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />


  <link rel="stylesheet" href="../sign-in/global-signin.css" />
  <link rel="stylesheet" href="../sign-in/sign-in.css" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" />
</head>

<body>
  <div class="sign-in">
    <form action="sign-in.php" method="post">
      <img class="sign-in-child" alt="" src="/PROYEK TEKWEB/sign-in/rectangle-1@2x.png" />
      <img class="logo-bli-n-go-2-1" alt="" src="/PROYEK TEKWEB/sign-in/logo-bli-n-go-2-1@2x.png" />
      <div class="lets-login-to">Let's Login to your Account First!</div>
      <input type="text" name="uname" id="uname" class="sign-in-item" placeholder="Username">
      <input type="password" name="pass" id="pass" class="rectangle-div" placeholder="Password">
      <button type="submit" name="signin" id="signin" class="sign-in-inner"><b>LOGIN</b></button>
      <div class="dont-have-an">Dont have an account?</div>
      <a href="sign-up.php" class="register-here"><b>Register here</b></a>
    </form>
  </div>
</body>

</html>

<?php
if (isset($_POST['signin'])) {
  $uname = $_POST['uname'];
  $pass = $_POST['pass'];

  $check = Admin::check_Admin($uname);
  if ($check > 0) {
    $_SESSION['uname'] = $uname;
    $_SESSION['pass'] = $pass;
    header("Location: ./admin-homepage.php");
  } else {
    echo '<script>window.alert("Tidak ada akun yang terdaftar !")</script>';
  }
};
?>