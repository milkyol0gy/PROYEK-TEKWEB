<?php
session_start();
include "admin.php";

$admin = new Admin();

$msg = '';

// Handle search query
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$adminData = $admin->search_admin($searchTerm)->fetchAll(PDO::FETCH_ASSOC);

// Check for success message in session
$successMsg = isset($_SESSION['success_msg']) ? $_SESSION['success_msg'] : '';
unset($_SESSION['success_msg']); // Clear the session variable

if (isset($_GET['id']) && count($_GET)) {
    $delete_data = $admin->delete_admin($_GET['id']);

    if ($delete_data) {
        $_SESSION['success_msg'] = 'Admin deleted successfully';
        header('location: table-admin.php');
    } else {
        $msg = 'Error deleting admin';
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
    <title>Admin Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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

        .container {
            align-items: center;
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

        .p-s {
            margin-top: 20px;
        }

        .search-form {
            float: right;
            margin-bottom: 20px;
        }

        .table-title {
            text-align: left;
            margin-bottom: 20px;
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
    </style>

</head>

<body>
    <div class="main">
        <nav class="navbar-bg">
            <div class="navbar">
                <ul class="navbar-list">
                    <a class="navbar-brand" href="admin-homepage.php"><img src="asset-admin/logo bli n go 2 1.png" alt="logo" style="height: 1cm; "></a>
                    <li><a href="../admin/table-barang.php" id="allproduct">All Product</a></li>
                    <li><a href="../admin/inputbrg.php" id="inputbrg">Add Product</a></li>
                    <li><a href="../admin/table-customer.php" id="custtable">Customer Table</a></li>
                    <li><a href="#" id="admintable">Admin Table</a></li>
                    <li><a href="../admin/table-promo.php" id="promotable">Promo Table</a></li>
                    <li><a href="../admin/table-pengiriman.php" id="shippingtable">Shipping Table</a></li>
                </ul>
                <form action=" " method="post">
                    <button type="submit" class="btn btn-warning" name="logout">Log Out</button>
                </form>
            </div>
        </nav>


        <div class="header">
            <label>ADMIN TABLE</label>
        </div>

        <div class="container">
            <div class="table-title">
                <a href="../admin/addadmin.php" class="btn btn-primary btn-sm" style="margin-top: 5px;">Add Admin</a>
                <form class="search-form" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" style="text-align: center;" placeholder="Search by admin name" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <table class="table table-bordered table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">No. Telp</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (!empty($adminData)) {
                        foreach ($adminData as $data) :
                    ?>
                            <tr>
                                <td><?= $data['id'] ?></td>
                                <td><?= $data['username'] ?></td>
                                <td><?= $data['email'] ?></td>
                                <td><?= $data['notelp'] ?></td>
                                <td>
                                    <a href="edit-admin.php?id=<?= $data['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="table-admin.php?id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $data['id'] ?>)"> delete</a>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    } else {
                        echo '<tr><td colspan="6">No records found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <footer id="footer">
            <h6 id="footer-text">Copyright © 2023</h6>
        </footer>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this admin?")) {} else {
                event.preventDefault();
            }
        }

        // Define the updateUserStatus function
        function updateUserStatus(userId, status) {
            $.ajax({
                url: 'update-user.php',
                type: 'POST',
                data: {
                    id: userId,
                    status: status
                },
                success: function(response) {
                    // Handle the response from update-user.php
                    console.log(response);
                    window.location.reload();
                },
                error: function(error) {
                    console.error('AJAX request failed:', error);
                }
            });
        }

        // Attach click event to buttons when the document is ready
        $(document).ready(function() {
            $('.btn-update-status').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                var status = $(this).data('status');
                updateUserStatus(userId, status);
            });
        });
    </script>
</body>

</html>