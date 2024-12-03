<?php
include "admin.php";
$admin = new Admin();

$msg = '';
$insert_data = false; // Initialize the variable

if (isset($_POST['add'])) {
    $username = trim($_POST['username']);
    $pass = trim($_POST['pass']);
    $email = trim($_POST['email']);
    $notelp = trim($_POST['notelp']);


    $existingUserCount = $admin->check_admin($username);

    if ($existingUserCount == 0 && !empty($username)) {
        $id_user = isset($_POST['id_user']) ? trim($_POST['id_user']) : null;

        $insert_data = $admin->create_Admin([
            'username' => $username,  // Make sure the 'username' key is set to a non-null value
            'password' => $pass,
            'email' => $email,
            'notelp' => $notelp
        ]);

        // Check if the admin was added successfully
        if ($insert_data) {
            $msg = 'Admin added successfully';
            header("Location: ../admin/table-admin.php");
            exit();
        } else {
            $msg = 'Error adding admin';
        }
    } else {
        $msg = 'Username already exists';
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../admin/sign-in.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
            align-items: center
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
            max-width: 40%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: rgb(255, 255, 94);
            transition: 0.3s;
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

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
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
            <label>ADD ADMIN</label>
        </div>

        <div class="container">

            <form action="#" method="post">

                <!-- message notif -->
                <?php
                if (!empty($msg)) {
                    echo '<div class="alert alert-' . ($insert_data ? 'success' : 'danger') . ' col-span-4">' . $msg . '</div>';
                }
                ?>


                <label for="name">Username:</label>
                <input type="text" name="username" required>

                <label for="name">Password:</label>
                <input type="password" name="pass" id="pass" class="input-pass" style="font-size: 14px; text-align: center;" placeholder="Password" required>

                <label for="name">Email:</label>
                <input type="text" id="name" name="email" required>

                <label for="notelphone">No Telephone:</label>
                <input type="text" name="notelp" required>



                <div class="d-grid gap-2">
                    <a href="table-admin.php" class="btn btn-danger">&laquo; Cancel</a>
                    <button class="btn btn-dark btn-lg" name="add">ADD</button>
                </div>
            </form>
        </div>

        <footer id="footer">
            <h6 id="footer-text">Copyright © 2023</h6>
        </footer>
    </div>
</body>

</html>