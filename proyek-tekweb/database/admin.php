<?php

class Admin
{
    private $row = null;

    public function __construct($Adminusername = null)
    {
        $conn = Admin::get_db_connection();
        $query = "";
        if ($Adminusername) {
            $query = "SELECT * FROM admin WHERE username = " . $Adminusername;
            //SELECT * FROM User ORDER BY username ASC/DESC
        }

        if ($query != "") {
            $stmt = $conn->query($query);
            $this->row = $stmt->fetch();
        }
    }


    public function update($arr = ['username' => null, 'password' => null, 'status' => null])
    {
        $conn = Admin::get_db_connection();
        $q = "UPDATE admin SET username = '" . $arr['username'] .
            "', password = '" . $arr['password'] .
            "', status = " . $arr['status'] .
            " WHERE username = " . $this->row['username'] . ";";
        $res = $conn->exec($q);
        return $res;
    }

    public function delete()
    {
        $q = "DELETE FROM admin WHERE username = " . $this->row['username'] . ";";
        $res = Admin::get_db_connection()->exec($q);
        return $res;
    }

    public function get_row()
    {
        return $this->row;
    }

    /**
     * Static function sama sperti java static method
     * Get all Users
     */
    public static function get_all()
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM admin";
        $stmt = $conn->query($query);
        return $stmt->fetchAll();
    }

    public static function search_by($username = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM admin where username = '{$username}'";
        $result = $conn->query($query);
        return $result->fetch();
    }

    public static function check_User($username = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM admin where username = '{$username}'";
        $result = $conn->query($query);
        return $result->rowCount();
    }

    public static function check_uname($username = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT `username` FROM admin where username = '{$username}'";
        $result = $conn->query($query);
        return $result->fetch();
    }

    public static function check_pass($password = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT `password` FROM admin where password = '{$password}'";
        $result = $conn->query($query);
        return $result->fetch();
    }

    public static function getCategory()
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM kategori_barang";
        $result = $conn->query($query);
        return $result->fetchAll();
    }


    public function insert_barang($arr = ['nama_barang' => "", 'deskripsi' => "", 'foto_barang' => null, 'harga' => "", 'qty' => "", 'kategori' => "1"])
    {
        $conn = Admin::get_db_connection();
        $cari_barang = "SELECT * FROM barang WHERE nama_barang LIKE '" . $arr['nama_barang'] . "'";

        $result = $conn->query($cari_barang);
        $barang_ada = $result->fetch();

        if ($barang_ada == "") {
            $q = $conn->prepare("INSERT INTO barang (nama_barang, deskripsi, foto_barang, harga, qty, kategori) VALUES (?, ?, ?, ?, ?, ?)");

            // Bind values from the array to the placeholders
            $q->bindParam(1, $arr['nama_barang']);
            $q->bindParam(2, $arr['deskripsi']);
            $q->bindValue(3, file_get_contents('file/' . $arr['foto_barang']));
            $q->bindParam(4, $arr['harga']);
            $q->bindParam(5, $arr['qty']);
            $q->bindParam(6, $arr['kategori']);

            $q->execute();
            return $q;
        } else {
            // Update only the qty column
            $q = $conn->prepare("UPDATE barang SET qty = qty + ? WHERE nama_barang = ?");

            // Bind values from the array to the placeholders
            $q->bindParam(1, $arr['qty']);
            $q->bindParam(2, $arr['nama_barang']);

            $q->execute();
            return $q;
        }
    }

    public static function create_admin($arr = ['username' => null, 'password' => null, 'email' => null, 'notelp' => null])
    {
        $conn = Admin::get_db_connection();
        $sql = "INSERT INTO admin (`username`,`password`, `email`, `notelp`) VALUES (:username, :password, :email , :notelp)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $arr['username']);
        $stmt->bindParam(':password', $arr['password']);
        $stmt->bindParam(':email', $arr['email']);
        $stmt->bindParam(':notelp', $arr['notelp']);


        $stmt->execute();
        return $stmt;
    }

    /**
     * Create new User
     */
    // public static function create_User($arr = ['name' => null, 'username' => null, 'alamat' => null, 'notelp' => null, 'password' => null])
    // {
    //     $conn = User::get_db_connection();
    //     $sql = "INSERT INTO User (`name`,`username`, `alamat`, `notelp`, `password`) VALUES (:name, :username, :alamat, :notelp, :password)";

    //     // Use prepared statements to prevent SQL injection
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':name', $arr['name']);
    //     $stmt->bindParam(':username', $arr['username']);
    //     $stmt->bindParam(':alamat', $arr['alamat']);
    //     $stmt->bindParam(':notelp', $arr['notelp']);
    //     $stmt->bindParam(':password', $arr['password']);

    //     // Execute the prepared statement
    //     $stmt->execute();
    // 	return $stmt;
    // }



    /**
     * Protected method pd php
     * Karena loosen-type return-type method deklarasai sama dengan vousername-type method
     */
    protected static function get_db_connection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "blingo";
        $conn = null;

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die;
        }
    }
}
