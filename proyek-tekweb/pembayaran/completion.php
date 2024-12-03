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

class Complete
{
    private $conn;
    private $userId;

    public function __construct($connection, $userId)
    {
        $this->conn = $connection;
        $this->userId = $userId;
    }

    public function insertLog()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM keranjang WHERE id_user=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    $query = $this->conn->prepare("INSERT INTO log_penjualan (id_barang, qty, time) VALUES (:id, :qty, CURRENT_TIMESTAMP)");
                    
                    $query->bindParam(':id', $row['id_barang']);
                    $query->bindParam(':qty', $row['qty']);
                    
                    $query->execute();
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function updateStock()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM keranjang WHERE id_user=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();

            // Fetch all rows as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    $stmt = $this->conn->prepare("UPDATE barang SET qty=qty-:qty WHERE id=:id");
                    $stmt->bindParam(':qty', $row['qty']);
                    $stmt->bindParam(':id', $row['id_barang']);

                    $stmt->execute();
                    
                }
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function deleteKeranjang()
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM keranjang WHERE id_user=:userId");
            $stmt->bindParam(':userId', $this->userId);
            $stmt->execute();
            
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
}

$conn = initializeConn();

if ($conn) {
    $complete = new Complete($conn, $userId);

    $complete->insertLog();
    $complete->updateStock();
    $complete->deleteKeranjang();

    header("Location: ../rating/Rating.php");
} else {
    echo "Failed to initialize the database connection.";
}
