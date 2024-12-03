<?php
include("./database/config.php");

if (isset($_POST['searchBar'])) {
    try {
        $nama_barang = $_POST['searchBar'];
        $query = "SELECT * FROM barang WHERE nama_barang LIKE '{$nama_barang}%'";
       
        $results = mysqli_query($con, $query);

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $foto = isset($row['foto_barang']) ? base64_encode($row['foto_barang']) : '';
                $harga = isset($row['harga']) ? $row['harga'] : '';
                echo
                    "<div id='item-1' class='btn-products'>
                    <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-products'>
                    <p class='name-product'>" . $row['nama_barang'] . "</p>
                    <p class='price'>Rp. $harga</p>
                </div>";
            }
        } else {
            echo "<h3 style='margin-top:80px;'>No results found.</h3>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
