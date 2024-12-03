<?php
session_start();
$userId = $_SESSION['user_id']['id'];
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']['id'];
}
 else {
    header("Location: ../sign-in.php");
}

include("../database/connect.php");

class Payment
{
    private $conn;
    private $userId;

    // biaya admin = 1000
    private $tagihan = 1000;
    //  untuk handle doubling of tagihan every page reload
    private $count = 0;

    public function __construct($connection, $userId)
    {
        $this->conn = $connection;
        $this->userId = $userId;

        if(isset($_GET['function']) && $_GET['function'] == 'item') {
            $_SESSION['count'] = 1;
            $_SESSION['tagihan'] = 1000;
            echo"<script>console.log('oke');</script>";
        }

        if (isset($_SESSION['tagihan'])) {
            $this->tagihan = $_SESSION['tagihan'];
        } 

        if (isset($_SESSION['count'])){
            $this->count = $_SESSION['count'];
        }


    }

    public function userAddress()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE id=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo '<div class="row" style="margin:8px;">
                    <div class="col-md-8">
                      <h6 class="opsi-judul">Alamat Pengiriman</h6>
                      <span class="opsi-nama">'. $row['username'] .'</span> <span>|</span> <span class="opsi-notelp">' . $row['notelp'] . '</span>
                      <p class="opsi-alamat">'. $row['alamat'] .'</p>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                      <button type="button" id="btn-pengiriman" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#deliveryModal">
                        Pilih Pengiriman
                      </button>
                    </div>
                  </div>';
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function displayCart()
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM keranjang WHERE id_user=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $res) {
                    $stmt = $this->conn->prepare("SELECT * FROM barang WHERE id=:id");
                    $stmt->bindParam(':id', $res['id_barang']);
                    $stmt->execute();
                    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($item) {
                        foreach ($item as $row) {
                            $foto = base64_encode($row['foto_barang']);
                            echo "
                            <div class='item'> <!--item-->
                                <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-box-item'>
                                <div class='desc'> <!--deskripsi item -->
                                    <h4 class='name-product'>" . $row['nama_barang'] . "</h4>
                                    <p class='price'>Rp. " . $row['harga'] . "</p>
                                    <p>Quantity: " . $res['qty'] . "</[p]>
                                </div>
                            </div>";
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function displayItemPrice()
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM keranjang WHERE id_user=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $res) {
                    $stmt = $this->conn->prepare("SELECT * FROM barang WHERE id=:id");
                    $stmt->bindParam(':id', $res['id_barang']);
                    $stmt->execute();
                    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($item) {
                        foreach ($item as $row) {
                            $total = $row['harga'] * $res['qty'];
                            echo "
                            <div class='col-md-8'>
                                <p>" . $row['nama_barang'] . " (x" . $res['qty'] . ") </p>
                            </div>
                            <div class='col-md-4'>
                                <p>Rp. " . $total . "</p>
                            </div>
                            ";
                            $this->tagihan += $total;
                        }
                    }
                }
                if($this->count < 6){
                    $_SESSION['tagihan'] = $this->tagihan;
                }

                echo"<script>console.log('harga all item');</script>";
                echo"<script>console.log('" . $this->count . "');</script>";
                echo"<script>console.log('" . $this->tagihan . "');</script>";
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function adminFees($id)
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;
        
        try {

            $stmt = $this->conn->prepare("SELECT * FROM pengiriman WHERE id=:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "
                    <div class='col-md-8'>
                        <p>Biaya Pengiriman</p>
                    </div>
                    <div class='col-md-4'>
                        <p>Rp. " . $row['harga'] . "</p>
                    </div>
                    ";
                } 
            }

            $this->tagihan += $row['harga'];
            if($this->count < 6){
                $_SESSION['tagihan'] = $this->tagihan;
            }
            // echo"<script>console.log('additional fees');</script>";
            echo"<script>console.log('fees: " . $this->count . "');</script>";
            // echo"<script>console.log('" . $this->tagihan . "');</script>";

            
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function displayTotalPrice()
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;

        $this->tagihan = $_SESSION['tagihan'];
        
        echo "
        <div class='col-md-8'>
            <p class='total-tagihan'>Total Tagihan</p>
        </div>
        <div class='col-md-4'>
            <p class='total-tagihan'>Rp. " . $this->tagihan . "</p>
        </div>
        ";

        echo"<script>console.log('total: " . $this->tagihan . "');</script>";

    }

    public function vouchers()
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;

        try {
            $stmt = $this->conn->prepare("SELECT * FROM promo WHERE CURRENT_TIMESTAMP BETWEEN valid_from AND valid_until");
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "
                    <button type='button' class='vouchers' id='voucher15' onclick='applyVoucher(\"" . $row['nama'] . "\")'>" . $row['nama'] . "</button>
                    ";
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }



    public function applied()
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM promo");
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    $potongan = $this->tagihan*$row['potongan']/100;
                    echo "
                    <div class='col-md-8'>
                        <p class='total-tagihan'>Vouchers</p>
                    </div>
                    <div class='col-md-8'>
                        <p>" . $row['nama'] . "</p>
                    </div>
                    <div class='col-md-4'>
                        <p>Rp. " . $potongan . "</p>
                    </div>
                    ";
                }
            }
            
            echo"<script>console.log('voucher: " . $this->count . "');</script>";
            
            if($this->count < 8){
                $_SESSION['tagihan'] = $this->tagihan - ($this->tagihan*$row['potongan']/100);
            }

            echo"<script>console.log('" . $_SESSION['tagihan'] . "');</script>";
            echo"<script>console.log('after');</script>";
            
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function deliveries()
    {
        // $this->count = $_SESSION['count'];
        $this->count++;
        // $_SESSION['count'] = $this->count;

        try {
            $stmt = $this->conn->prepare("SELECT * FROM pengiriman");
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "
                    <form action='../pembayaran/pembayaran.php' method='GET'>
                    <input type='hidden' name='deliveryId' id='" . $row['id'] . "' value='" . $row['id'] . "'>
                        <button type='button; btn close' data-bs-dismiss='modal' class='vouchers delivery-choice' id='delivery-choice-" . $row['id'] . "'>
                            <div>
                                <h5>" . $row['jenis_pengiriman'] . "</h5>
                                <p>" . $row['deskripsi'] . "</p>
                                <p>Rp. " . $row['harga'] . "</p>
                            </div>
                        </button>
                    </form>

                    ";
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
}

$conn = initializeConn();

if ($conn) {
    $payment = new Payment($conn, $userId);

    if (isset($_GET['function']) && $_GET['function'] == 'address') {
        $payment->userAddress();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'item') {
        $payment->displayCart();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'price') {
        $payment->displayItemPrice();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'adminFees') {
        $deliveryId = $_GET['id'];
        $payment->adminFees($deliveryId);        
    } elseif (isset($_GET['function']) && $_GET['function'] == 'total') {
        $payment->displayTotalPrice();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'voucher') {
        $payment->vouchers();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'terapkan') {
        $payment->applied();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'deliveries') {
        $payment->deliveries();
    } else {
        echo "Invalid function parameter.";
    }


    

} else {
    echo "Failed to initialize the database connection.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Handle AJAX request for quantity update
    try {
        if ($_POST['action'] == 'updateQuantity' && isset($_POST['newQty']) && isset($_POST['productId'])) {
            $newQty = $_POST['newQty'];
            $productId = $_POST['productId'];

            // Example: Update the 'quantity' field in the 'keranjang' table
            $stmt = $conn->prepare("UPDATE keranjang SET qty = :newQty WHERE id_barang = :id AND id_user = :userId");
            $stmt->bindParam(':newQty', $newQty, PDO::PARAM_INT);
            $stmt->bindParam(':id', $productId);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            // Check the number of affected rows
            $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed']);
            }
            exit; // Terminate the script after handling the AJAX request
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>

<script>
    function decrement(productId) {
        let qtyInput = document.getElementById('qtyInput-' + productId);
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            updateDatabase(productId, qtyInput.value);
        }
    }

    function increment(productId) {
        let qtyInput = document.getElementById('qtyInput-' + productId);
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateDatabase(productId, qtyInput.value);
    }

    function updateDatabase(productId, newQty) {
    
        $.ajax({
            url: '<?php echo $_SERVER['PHP_SELF']; ?>',
            type: 'POST',
            data: {
                action: 'updateQuantity',
                productId: productId,
                newQty: newQty
            },
            success: function (response) {
                console.log('Function responded');
                if (response.success) {
                    console.log('Update successful');
                    window.location.reload();
                } else {
                    console.log('Update failed. Reason:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error updating quantity:', error);
            }
        });
    }
</script>
