<?php
session_start();
include "admin.php";

$admin = new Admin();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .p-s {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-10 m-auto">
            <p class="h1 text-center p-s">TABLE Barang</p>
            <table class="table table-bordered table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama_Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Check if $admin is not null before using it
                    // if ($admin) {
                    //     foreach ($admin->tampil_barang()->fetchAll(PDO::FETCH_ASSOC) as $data):
                    //         $foto = base64_encode($data['foto_barang']);

                    //         echo
                    //         "<tr>
                    //         <td>
                    //             " . $data['id'] . "
                    //         </td>
                    //         <td>
                    //         <img src='data:image/jpeg;base64,$foto' alt=' " . $data['nama_barang'] . "' class='img-popular'>
                            
                    //         </td>
                    //         <td>
                    //              " . $data['nama_barang'] . "
                    //         </td>
                    //         <td>
                    //              " . $data['harga'] . "
                    //         </td>
                    //         <td>
                    //              " . $data['qty'] . "
                    //         </td>
                    //         <td>
                    //              " . $data['deskripsi'] . "
                    //         </td>
                    //         <td>
                    //             <a href='edit-admin.php?id= " . $data['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                    //         </td>
                    //     </tr>";
                                                    
                    //     endforeach;
                    // } else {
                    //     echo '<tr><td colspan="6">No records found</td></tr>';
                    // }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Define the updateUserStatus function
    function updateUserStatus(userId, status) {
        $.ajax({
            url: 'update-user.php',
            type: 'POST',
            data: { id: userId, status: status },
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
        // Assuming you have buttons with class 'btn-update-status'
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