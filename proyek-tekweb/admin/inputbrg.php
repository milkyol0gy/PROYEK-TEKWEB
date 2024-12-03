<?php
include '../database/admin.php';

if (isset($_POST['input'])) {
    $foto = $_FILES['foto']['name'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($file_tmp, 'file/' . $foto);

    $nama_barang = trim($_POST['nama_barang']);
    $harga = trim($_POST['harga']);
    $quantity = trim($_POST['quantity']);
    $deskripsi = trim($_POST['deskripsi']);
    $kategori = trim($_POST['kategori']);

    $admin = new Admin();
    $insert_data = $admin->insert_barang([
        'nama_barang' => $nama_barang,
        'deskripsi' => $deskripsi,
        'foto_barang' => $foto,
        'harga' => $harga,
        'qty' => $quantity,
        'kategori' => $kategori
    ]);
    if ($insert_data)
        header('location: inputbrg.php?msg=sukses');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
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
            align-items: center;
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

        .login-form {
            max-width: 500px;
            border: 1px solid #ddd;
            border-radius: 8px;
            /* opacity: 0; */
            position: absolute;
            top: 50%;
            left: 50%;
            background-color: #fff;
            width: 100%;
            transform: translate(-50%, -50%);
            padding: 12px;
        }

        .login-form .judul {
            padding: 15px 10px;
            text-align: center;
            font-size: 25px;
        }

        .luar {
            min-height: 100vh;
            padding: 10vh 1rem 0 1rem;
            background-color: #F3F3F3;
        }

        .btn-sub {
            margin-top: 10px;
        }

        .form-select {
            margin-top: 15px;
        }

        .flex {
            display: flex;
        }

        /* .kiri {
            width: min-content; 
        } */

        .kanan {
            flex-grow: 1;
        }

        .grid {
            display: grid;
            grid-template-columns: 30% 1fr;
            padding: 50px 0 20px;
            column-gap: 10px;
            row-gap: 20px;
            align-items: center;
            justify-content: center;
        }

        .col-span-2 {
            grid-column: span 2 / span 2;
        }

        .self-center {
            justify-self: center;
            width: 50%;
            background-color: #41AB26;
        }

        .xx {
            opacity: 0;
            position: absolute;
            top: 18;
            left: 0;
            transform: scale(10);
        }

        .foto-btn {
            width: 80%;
            aspect-ratio: 1/1;
            margin: auto;
            position: relative;
            overflow: hidden;
            background-color: #D9D9D9;
        }

        .gambar {
            width: 100%;
            height: 60%;
            object-fit: contain;
        }

        .hide {
            visibility: hidden;
            position: absolute;
        }

        .content-bttn {
            margin: 110px 10px;
        }

        form {
            display: flex;
            flex-direction: column;
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

        .container {
            max-width: 50%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        #footer {
            background-color: #1d3a61;
            margin-top: auto;
            width: 100%;
        }

        #footer-text {
            color: #fff;
            padding: 18px;
            text-align: left;
        }

        .background {
            background-color: #fff;
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
            <label>ADD PRODUCT</label>
        </div>

        <div class="luar ">
            <!-- <div class="judul">INPUT BARANG</div> -->
            <form method="post" enctype="multipart/form-data" class="grid container-md">
                <?= isset($_GET['msg']) ? '<div class="alert alert-success col-span-2">Barang berhasil diinput!</div>' : '' ?>
                <div class="input-group mb-3 kiri">
                    <button class="foto-btn" id="imgBtn">
                        <p><i class="bi bi-plus"></i>Tambahkan foto</p>
                        <input type="file" class="form-control xx" id="inputGroupFile02" name="foto" onchange="displaySelectedImage(this)">
                    </button>
                    <img id="selectedImage" class="gambar" />
                </div>
                <div class="kanan">
                    <div class="mb-3">
                        <label for="inputNamaBarang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" aria-describedby="emailHelp" required>
                    </div>

                    <div class="mb-3">
                        <label for="inputNamaBarang" class="form-label">Harga</label>
                        <input type="text" class="form-control" name="harga" aria-describedby="emailHelp">
                    </div>

                    <div class="mb-3">
                        <label for="inputNamaBarang" class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity" aria-describedby="emailHelp" required>
                    </div>

                    <label for="inputNamaBarang" class="form-label">Deskripsi</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="deskripsi" style="height: 100px"></textarea>
                        <label for="floatingTextarea2"></label>
                    </div>

                    <select class="form-select" aria-label="Default select example" name="kategori" onchange="validateSelect()">
                        <option disabled selected>Kategori (wajib)</option>
                        <?php
                        $kategoriList = Admin::getCategory();

                        foreach ($kategoriList as $kategori) {
                            echo "<option value=\"" . $kategori['id'] . "\">" . $kategori['nama_kategori'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" style="border: none;" class="btn btn-primary btn-sub col-span-2 self-center" name="input">Submit</button>
            </form>
        </div>
        <div id="footer">
            <h6 id="footer-text">Copyright © 2023</h6>
        </div>
    </div>
</body>
<script>
    function displaySelectedImage(input) {
        const selectedImageLabel = document.getElementById('inputGroupFile02');
        const selectedImage = document.getElementById('selectedImage');
        const imgBtn = document.getElementById('imgBtn');
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                selectedImage.src = e.target.result;
                selectedImageLabel.textContent = ''; // Clear the label text
            };

            reader.readAsDataURL(input.files[0]);
            imgBtn.classList.add('hide');
        } else {
            selectedImage.src = '';
            selectedImageLabel.textContent = 'No image chosen';
        }
    }

    function validateSelect() {
        var select = document.getElementById('mySelect');

        // Check if the selected option is not the placeholder option
        if (select.value !== "") {
            // Remove the 'placeholder-option' class
            select.options[0].classList.remove('placeholder-option');
        }
    }
</script>

</html>