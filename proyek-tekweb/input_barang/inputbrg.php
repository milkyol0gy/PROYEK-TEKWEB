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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
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

        #footer {
            background-color: #1D3A61;
        }

        #footer-text {
            color: #FFF;
            padding: 5px;
            margin: 0;
        }
        .background{
            background-color: #fff;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-sm fixed-top background" id="navbar">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="../homepage/asset-homepage/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
              <a class="nav-link" href="../allProduct/allproduct.php" id="allproduct">All Product</a>
              </li>
            </ul>
            <form class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
                <button class="btn btn-warning">Log Out</button>
                <button class="btn"><img src="../homepage/asset-homepage/cart-shopping.svg" alt="keranjang"></button>
                <button class="btn"><img src="../homepage/asset-homepage/wishlist.svg" alt="wishlist"></button>
            </form>
          </div>
        </div>
    </nav>
    <div class="luar ">
        <!-- <div class="judul">INPUT BARANG</div> -->
        <form method="post" enctype="multipart/form-data" class="grid container-md">
            <?= isset($_GET['msg']) ? '<div class="alert alert-success col-span-2">Barang berhasil diinput!</div>' : '' ?>
            <div class="input-group mb-3 kiri">
                <button class="foto-btn" id="imgBtn">
                    <p><i class="bi bi-plus"></i>Tambahkan foto</p>
                    <input type="file" class="form-control xx" id="inputGroupFile02" name="foto"
                        onchange="displaySelectedImage(this)">
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
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                        name="deskripsi" style="height: 100px"></textarea>
                    <label for="floatingTextarea2"></label>
                </div>

                <select class="form-select" aria-label="Default select example" name="kategori"
                    onchange="validateSelect()">
                    <option disabled selected>Kategori (wajib)</option>
                    <?php
                    $kategori = Admin::getCategory();

                    for ($i = 0; $i < count($kategori) - 1; $i++) {
                        echo "<option value=\"" . $i + 1 . "\">" . $kategori[$i] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sub col-span-2 self-center" name="input">Submit</button>
        </form>
    </div>
    <div id="footer">
        <h6 id="footer-text">Copyright © 2023</h6>
    </div>
</body>
<script>
    function displaySelectedImage(input) {
        const selectedImageLabel = document.getElementById('inputGroupFile02');
        const selectedImage = document.getElementById('selectedImage');
        const imgBtn = document.getElementById('imgBtn');
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
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