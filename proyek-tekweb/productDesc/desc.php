<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']['id'];
} else {
    header("Location: ../sign-in.php");
}

include("../database/connect.php");

class Desc
{
    private $conn;
    private $userId;

    public function __construct($connection, $userId)
    {
        $this->conn = $connection;
        $this->userId = $userId;
    }

    
    public function display()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            try {
                // Prepare and execute the SQL query
                $stmt = $this->conn->prepare("SELECT * FROM barang WHERE id=:id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                // Fetch all rows as an associative array
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row):
                        $foto = base64_encode($row['foto_barang']);
                        echo
                            "<h4 id='name-product-1' class='name-product' style='margin-top: 100px;'>" . $row['nama_barang'] . "</h4>
                        <div id='product-desc-content'>
                            <div class='img-price'>
                              <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-price-inner'>
                              <p class='price'>Rp. " . $row['harga'] . "</p>
                            </div>
                            <p class='desc'>" . $row['deskripsi'] . "</p>
                  
                            <div class='box-desc'>
                              <div class='box-desc-1'>
                                <img src='data:image/jpeg;base64,$foto' alt='" . $row['nama_barang'] . "' class='img-box-desc'>
                                <h4 id='name-product-1' class='name-product'>" . $row['nama_barang'] . "</h4>
                              </div>
                              
                              <div class='product-info'>
                                <div class='quantity'>
                                    <button class='btnQty minus' type='button' onclick='decrement(); updateQty()'>
                                    <i class='fa-solid fa-minus'></i>
                                    </button>
                                    <input type='text' value='1' id='qtyInput'>
                                    <button class='btnQty plus' type='button' onclick='increment(); updateQty()'>
                                    <i class='fa-solid fa-plus'></i>
                                    </button>
                                </div>
                                <div id='product-info-1'>
                                  <span id='stock'>Stock: " . $row['qty'] . "</span>
                                  <form action='../productDesc/productDesc.php?id=" . $row['id'] . "method='GET'>
                                      <button type='submit' id='wishlist-btn' name='wishlist'>
                                          <i class='fa-regular fa-heart' id='wishlist'></i>
                                      </button>
                                  </form>
                                  <form action='../productDesc/productDesc.php?id=" . $row['id'] . "method='GET'>
                                      <button type='submit' id='wishlist-btn-off' name='wishlist'>
                                          <i class='fa-solid fa-heart' id='wishlist'></i>
                                      </button>
                                  </form>
                                  
                                </div>
                              </div>
                              <form action='../productDesc/desc.php?id=" . $row['id'] . "' method='POST' name='cart'>
                                  <input type='hidden' name='id_barang' value='" . $row['id'] . "'>
                                  <input type='hidden' name='qty_keranjang' value='1'>
                                  <button type='submit' class='btn-popular' name='action' value='addKeranjang' id='keranjang'>+Keranjang</button>
                              </form>
                              <form action='' method='POST'>
                                <button type='submit' class='btn-popular' name='action' value='beli' id='beli'>Beli</button>
                              </form>
                  
                            </div>
                          </div>";
                    endforeach;
                }
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
            }
        }
    }

    public function addToWishlist(){
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $uname = $_GET['uname'];
          try {
            // Prepare and execute the SQL query
            $stmt = $this->conn->prepare("INSERT INTO wishlist (username, id_barang) VALUES (?,?)");
            $stmt->bindParam(1, $uname);
            $stmt->bindParam(2, $id);

            // Execute the query
            echo "<script>window.alert(Username: $uname, ID Barang: $id)</script>";
            $stmt->execute();

            // Check if the query was successful
            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                echo "Data inserted into wishlist successfully.";
            } else {
                echo "No rows were inserted into wishlist.";
            }
          } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
          }
        }
    }
      
    public function deleteToWishlist(){
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $uname = $_GET['uname'];

          try {
            $stmt = $this->conn->prepare("DELETE FROM wishlist WHERE id_barang='$id'");
            $stmt->execute();

            $affectedRows = $stmt->rowCount();

            if ($affectedRows = 0) {
                echo "Data deleted into wishlist successfully.";
            } else {
                echo "Failed.";
            }
          } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
          }
        }
    }

    function addKeranjang()
    {
        if (isset($_POST['action']) && $_POST['action'] === 'addKeranjang') {            
            $id = $_POST['id_barang'];
            $qty = $_POST['qty_keranjang'];
        
            // check if barang sudah ada di tabel
            $result = $this->conn->prepare("SELECT * FROM keranjang WHERE id_barang = :id AND id_user = :userId");
            $result->bindParam(':id', $id);
            $result->bindParam(':userId', $this->userId);
            $result->execute();
            $exist = $result->fetch();
        
            if (empty($exist)) {
                $query = "INSERT INTO keranjang (id_user, id_barang, qty) VALUES (:userId, :id, :qty)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':userId', $this->userId);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':qty', $qty);
                $success = $stmt->execute();
            } else {
                $stmt = $this->conn->prepare("UPDATE keranjang SET qty = qty + :qty WHERE id_barang = :id");
                $stmt->bindParam(':qty', $qty);
                $stmt->bindParam(':id', $id);
                $success = $stmt->execute();
            }       
            
            if ($success && $stmt->rowCount() > 0) {
                echo '<script>alert("Item added to cart successfully.");</script>';
                echo '<script>window.location.href="../productDesc/productDesc.php?id=' . $id . '";</script>';
                exit(); // Ensure that the script stops execution after the redirect
            } else {
                echo '<script>alert("Failed to add item to cart.");</script>';
            }

        }
    }
}
// echo '<script>alert("Item added to cart successfully.");</script>';

$conn = initializeConn();

if ($conn) {
    $desc = new Desc($conn, $userId);

    echo "<script>console.log('Before addKeranjang');</script>";

    if (isset($_POST['action'])) {
        $desc->addKeranjang();
    } 
    
    if (isset($_GET['function']) && $_GET['function'] == 'display') {
        $desc->display();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'wishlist') {
        $desc->addToWishlist();
    } elseif (isset($_GET['function']) && $_GET['function'] == 'delete') {
        $desc->deleteToWishlist();
    }
} else {
    echo "Failed to initialize database connection.";
}
?>

<script>
    function updateQty() {
        var qtyInput = document.getElementById('qtyInput').value;
        document.querySelector('input[name="qty_keranjang"]').value = qtyInput;
    }

    let qty = document.querySelector("#qtyInput");

    function decrement() {
        if (qty.value <= 1) {
            qty.value = 1;
        } else {
            qty.value = parseInt(qty.value) - 1;
        }
    }

    function increment() {
        qty.value = parseInt(qty.value) + 1;
    }
</script>