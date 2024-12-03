<?php
include "admin.php";
$admin = new Admin();

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (isset($_POST['edit'])) {
    $barang = trim($_POST['barang']);
    $harga = trim($_POST['harga']);
    $qty = trim($_POST['qty']);
    $deskripsi = trim($_POST['deskripsi']);
    $img_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp, 'file/' . $img_name);

    if ($admin->get_id_barang($id)) {
        $update_data = $admin->update_barang([
            'id' => $id,
            'nama_barang' => $barang,
            'deskripsi' => $deskripsi,
            'image' => $img_name,
            'harga' => $harga,
            'qty' => $qty
        ]);

        if ($update_data) {
            $msg = 'Berhasil mengedit data barang.';
            header("Location: ../admin/table-barang.php");
            exit();
        } else {
            $msg = 'Gagal mengedit data barang.';
        }
    } else {
        $msg = 'Gagal mengedit data barang. ID tidak ditemukan.';
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../sign-in.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" />
    <style>
        body {
            font-family: Poppins;
            color: #3f3f3f;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        .main {
            width: 100%;
            background-color: lightgray;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        #logout {
            justify-content: flex-end;
        }

        .navbar-bg {
            background-color: #1d3a61;
        }

        .navbar {
            width: 95%;
            margin: auto;
            display: flex;
        }

        .navbar-list {
            display: flex;
            justify-content: flex-start;
            list-style: none;
            margin-top: 20px;
            align-items: center;
        }

        .navbar-list li {
            margin-right: 600px;
        }

        .header {
            font-size: 50px;
            color: #3f3f3f;
            font-weight: bold;
            text-align: center;
        }

        .navbar-brand {
            background-color: white;
            border: 5px solid white;
        }

        .navbar ul li {
            list-style: none;
            display: inline-block;
            margin: 0 20px;
            position: relative;
        }

        .navbar ul li a {
            color: whitesmoke;
            text-transform: uppercase;
            text-decoration: none;
        }

        .navbar ul li::after {
            content: "";
            height: 3px;
            width: 0;
            background: yellow;
            position: absolute;
            left: 0;
            bottom: -10px;
            transition: 0.5s;
        }

        .navbar ul li:hover::after {
            width: 100%;
        }

        .content {
            top: 45%;
            left: 50%;
            width: 100%;
            text-align: center;
            color: #3f3f3f;
            position: absolute;
            transform: translate(-50%, -50%);
        }

        .content-bttn {
            margin: 110px 10px;
        }

        .form-control {
            padding: 0px;
        }

        button:hover {
            background: rgb(255, 255, 94);
            transition: 0.3s;
        }

        .container {
            max-width: 40%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        form {
            display: flex;
            flex-direction: column;
            text-align: left;
            margin-top: 10px;
        }

        label {
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #footer {
            background-color: #1d3a61;
        }

        #footer-text {
            color: #fff;
            padding: 18px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="main">
        <nav class="navbar-bg">
            <div class="navbar">
                <ul class="navbar-list">
                    <a class="navbar-brand" href="admin-homepage.php"><img src="asset-admin/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
                    <li><a href="../admin/table-barang.php" id="allproduct">All Product</a></li>
                    <li><a href="../admin/inputbrg.php" id="inputbrg">Add Product</a></li>
                    <li><a href="../admin/table-customer.php" id="custtable">Customer Table</a></li>
                    <li><a href="../admin/table-admin.php" id="admintable">Admin Table</a></li>
                    <li><a href="../admin/table-promo.php" id="promotable">Promo Table</a></li>
                    <li><a href="../admin/table-pengiriman.php" id="shippingtable">Shipping Table</a></li>
                </ul>
                <form action=" " method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
            </div>
        </nav>

        <div class="header">
            <label>EDIT BARANG</label>
        </div>

        <div class="container">
            <div class="col-12 m-auto form-container">
                <form action="" method="post" enctype="multipart/form-data">

                    <label for="image">Foto:</label>
                    <input type="file" name="image">

                    <label for="username">Nama barang:</label>
                    <input type="text" name="barang">

                    <label for="email">Harga:</label>
                    <input type="text" id="email" name="harga">

                    <label for="notelp">QTY:</label>
                    <input type="text" name="qty">

                    <label for="deskripsi">Deskripsi:</label>
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="deskripsi" style="height: 100px"></textarea>
                    <label for="floatingTextarea2"></label>

                    <div class="d-grid gap-2">
                        <a href="table-barang.php" class="btn btn-danger">&laquo; Cancel</a>
                        <button class="btn btn-dark btn-lg" name="edit">Edit</button>
                    </div>

                </form>
            </div>


        </div>
        <footer id="footer">
            <h6 id="footer-text">Copyright © 2023</h6>
        </footer>
    </div>
</body>

</html>