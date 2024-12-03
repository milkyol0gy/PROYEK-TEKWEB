<?php
    include("../database/connect.php");

    class Wish {
        private $conn;

        public function __construct($connection)
        {
            $this->conn = $connection;
        }
        
        public function display() {
            if(isset($_GET["uname"])){
                $uname = $_GET["uname"];
                try {
                    $stmt = $this->conn->prepare("SELECT wishlist.id_barang, barang.* FROM wishlist JOIN barang ON wishlist.id_barang = barang.id WHERE wishlist.username=:uname");
                    $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
                    $stmt->execute();

                    // Fetch all rows as an associative array
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (isset($result)) {
                        foreach ($result as $row) {
                            $foto = base64_encode($row['foto_barang']);
                            echo
                            "<form action ='../productDesc/productDesc.php?id=".$row['id']."' method='POST'>
                                <button type='submit' id='item-1' class='btn-products'>
                                    <img src='data:image/jpeg;base64,$foto' alt='".$row['nama_barang']."'class='img-products'>
                                    <p class='name-product'>".$row['nama_barang']."</p>
                                    <p class='price'>Rp." . $row['harga'] . "</p>
                                </button>
                            </form>";
                        };
                    }
                } catch (PDOException $e) {
                    echo "Query failed: " . $e->getMessage();
                }
            }
        }
    }

    $conn = initializeConn();

    if ($conn) {
        $wish = new Wish($conn);
        if (isset($_GET['function']) && $_GET['function'] == 'display') {
            $wish->display();
        } else {
            echo "Invalid function parameter.";
        }
    } else {
        echo "Failed to initialize database connection.";
    }
?>