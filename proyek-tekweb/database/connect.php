<?php

function initializeConn() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "blingo";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;  // Handle connection failure as needed
    }
}

?>
