<?php
session_start();
include "admin.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $status = $_POST['status'];

    $conn = Admin::get_db_connection(); // Make sure to establish a database connection

    try {
        if ($status == '0') {
            // Assuming 'user' table structure
            $sql = "UPDATE `user` SET aktif = 1 WHERE id = :id";
        } elseif ($status == '1') {
            $sql = "UPDATE `user` SET aktif = 0 WHERE id = :id";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();


        
        return $stmt;
    } catch (PDOException $e) {
        echo 'Update failed: ' . $e->getMessage();
    }
} else {
    echo 'Invalid access!';
}
?>
