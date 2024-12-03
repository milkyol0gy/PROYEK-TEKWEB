<?php
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
    <title>ADMIN</title>
    <script src="C:\Users\Valencia\OneDrive\Documents\Teknologi Web F (SMT 3)\JQuery\code.jquery.com_jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="admin-homepage.css">
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
            height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("asset-admin/main-background.jpg");
            background-size: cover;
            background-position: center;
            text-align: center;
        }

        #logout {
            justify-content: flex-end;
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
            margin-top: 50px;
        }

        .navbar ul li {
            list-style: none;
            display: inline-block;
            margin: 0 20px;
            position: relative;
        }

        .navbar ul li a {
            color: #3f3f3f;
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
            /* margin-top: 30px; */
            top: 60%;
            left: 50%;
            width: 75%;
            text-align: center;
            color: #3f3f3f;
            position: absolute;
            transform: translate(-50%, -50%);
        }

        .content-bttn {
            margin: 110px 10px;
        }

        button:hover {
            background: rgb(255, 255, 94);
            transition: 0.3s;
        }

        #footer {
            background-color: #1d3a61;
            margin-top: auto;
            width: 100%;
        }

        #footer-text {
            color: #fff;
            padding: 18px;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="navbar">
            <ul class="navbar-list">
                <a class="navbar-brand" href="#"><img src="asset-admin /logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
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

        <div>
            <label class="header">Hello, Admin</label>
        </div>

        <div class="content">
            <p style="font-size: 18px;">Welcome to the admin control center of Bli n Go! Here, you have full control over various aspects of managing the Bli n Go online store. From viewing, adding, and editing products, customers, admins, promotions, to shipping, we present a responsive and user-friendly dashboard that provides you with quick and intuitive access to crucial information. Admin, let's work together to create an extraordinary online shopping experience for our customers. Best of luck in managing your tasks!</p>
        </div>

    </div>

    <footer id="footer">
        <h6 id="footer-text">Copyright © 2023</h6>
    </footer>
</body>

</html>