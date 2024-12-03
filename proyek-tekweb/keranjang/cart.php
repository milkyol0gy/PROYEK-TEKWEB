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

class Cart
{
    private $conn;
    private $userId;

    public function __construct($connection, $userId)
    {
        $this->conn = $connection;
        $this->userId = $userId;
    }

    public function displayCart()
    {
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
                            echo "<div class='item'> <!--item-->
                                    <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-box-item'>
                                    <input type='hidden' value='" . $row['id'] . "' name='productId'>
                                    <div class='desc'> <!--deskripsi item -->
                                        <h4 class='name-product'>" . $row['nama_barang'] . "</h4>
                                        <p class='price'>Rp. " . $row['harga'] . "</p>
                                        <div class='quantity'>
                                            <button class='btnQtyMinus' type='button' onclick='decrement(" . $row['id'] . ")'>
                                                <i class='fa-solid fa-minus'></i>
                                            </button>
                                            <input type='text' class='qtyInput' value='" . $res['qty'] . "' id='qtyInput-" . $row['id'] . "'>
                                            <button class='btnQtyPlus' type='button' onclick='increment(" . $row['id'] . ")'>
                                                <i class='fa-solid fa-plus'></i>
                                            </button>
                                        </div>
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
                            <div class='col-md-8 nama-barang'> " . $row['nama_barang'] . " (x" . $res['qty'] . ") </div>
                            <div class='col-md-4'>Rp. " . $total . "</div>
                            ";
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function displayTotalPrice()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM keranjang WHERE id_user=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                $total = 0;
                foreach ($result as $res) {
                    $stmt = $this->conn->prepare("SELECT * FROM barang WHERE id=:id");
                    $stmt->bindParam(':id', $res['id_barang']);
                    $stmt->execute();
                    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($item) {
                        foreach ($item as $row) {
                            $total += $row['harga'] * $res['qty'];
                        }
                    }

                    
                }
                echo "
                <div class='col-md-8 total-harga'>Total Harga</div>
                <div class='col-md-4 total-uang'>Rp. " . $total . "</div>
                ";
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
}

$conn = initializeConn();

if ($conn) {
    $cart = new Cart($conn, $userId);

    if (isset($_GET['function']) && $_GET['function'] == 'item') {
        $cart->displayCart();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'price') {
        $cart->displayItemPrice();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'total') {
        $cart->displayTotalPrice();
    } else {
        echo "Invalid function parameter.";
    }


    echo "<script>console.log('$userId')</script>";

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
