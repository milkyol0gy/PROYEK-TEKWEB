<?php

/**
 * Class Admin
 */
class Admin
{
    private $row = null;
    private $db;

    public function __construct($username = null)
    {
        $this->db = Admin::get_db_connection();
        $query = "";
        if ($username) {
            $query = "SELECT * FROM Admin WHERE username = :username";
        }

        if ($query != "") {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $this->row = $stmt->fetch();
        }
    }


    public function update($arr = ['username' => null, 'password' => null, 'status' => null])
    {
        $conn = Admin::get_db_connection();
        $q = "UPDATE Admin SET username = :username, password = :password, status = :status WHERE username = :current_username;";

        $stmt = $conn->prepare($q);
        $stmt->bindParam(':username', $arr['username']);
        $stmt->bindParam(':password', $arr['password']);
        $stmt->bindParam(':status', $arr['status']);
        $stmt->bindParam(':current_username', $this->row['username']);

        $res = $stmt->execute();
        return $res;
    }

    public function search_user($searchTerm)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM user WHERE username LIKE :searchTerm OR email LIKE :searchTerm";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function search_pengiriman($searchTerm)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM pengiriman WHERE jenis_pengiriman LIKE :searchTerm";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function search_promo($searchTerm)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM promo WHERE nama LIKE :searchTerm ";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }
    public function search_admin($searchTerm)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM admin WHERE username LIKE :searchTerm OR email LIKE :searchTerm";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function search_barang($searchTerm)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM barang WHERE nama_barang LIKE :searchTerm";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function update_user($arr = ['id' => null, 'username' => null, 'alamat' => null, 'notelp' => null, 'email' => null])
    {
        $conn = Admin::get_db_connection();
        $q = "UPDATE user SET username = :username, alamat = :alamat, notelp = :notelp, email = :email WHERE id = :id;";

        $stmt = $conn->prepare($q);
        $stmt->bindParam(':id', $arr['id']);
        $stmt->bindParam(':username', $arr['username']);
        $stmt->bindParam(':alamat', $arr['alamat']);
        $stmt->bindParam(':notelp', $arr['notelp']);
        $stmt->bindParam(':email', $arr['email']);

        $res = $stmt->execute();
        return $res;
    }

    public function update_barang($arr = ['id' => null, 'nama_barang' => null, 'deskripsi' => null, 'image' => null, 'harga' => null, 'qty' => null])
    {

        $conn = Admin::get_db_connection();
        $q = "UPDATE barang SET nama_barang = :nama_barang, deskripsi = :deskripsi, foto_barang = :image, harga = :harga, qty = :qty WHERE id = :id;";

        $stmt = $conn->prepare($q);
        $stmt->bindParam(':id', $arr['id']);
        $stmt->bindParam(':nama_barang', $arr['nama_barang']);
        $stmt->bindParam(':deskripsi', $arr['deskripsi']);
        $stmt->bindValue(':image', file_get_contents('file/' . $arr['image']));

        $stmt->bindParam(':harga', $arr['harga']);
        $stmt->bindParam(':qty', $arr['qty']);

        $res = $stmt->execute();
        return $res;
    }

    public function update_admin($arr = ['id' => null, 'username' => null, 'email' => null, 'notelp' => null])
    {
        $conn = Admin::get_db_connection();
        $q = "UPDATE admin SET username = :username, email = :email, notelp = :notelp  WHERE id = :id;";

        $stmt = $conn->prepare($q);
        $stmt->bindParam(':id', $arr['id']);
        $stmt->bindParam(':username', $arr['username']);
        $stmt->bindParam(':email', $arr['email']);
        $stmt->bindParam(':notelp', $arr['notelp']);

        $res = $stmt->execute();
        return $res;
    }

    public function update_pengiriman($arr = ['id' => null, 'jenis_pengiriman' => null, 'deskripsi' => null, 'harga' => null])
    {
        $conn = Admin::get_db_connection();
        $q = "UPDATE pengiriman SET jenis_pengiriman = :jenis_pengiriman, deskripsi = :deskripsi, harga = :harga  WHERE id = :id;";

        $stmt = $conn->prepare($q);
        $stmt->bindParam(':id', $arr['id']);
        $stmt->bindParam(':jenis_pengiriman', $arr['jenis_pengiriman']);
        $stmt->bindParam(':deskripsi', $arr['deskripsi']);
        $stmt->bindParam(':harga', $arr['harga']);
        $res = $stmt->execute();
        return $res;
    }



    public function update_promo($arr = ['id' => null, 'nama' => null, 'deskripsi' => null, 'potongan' => null, 'valid_from' => null, 'valid_until' => null])
    {
        $conn = Admin::get_db_connection();

        if (!isset($arr['id'])) {

            return false;
        }

        $q = "UPDATE promo SET nama = :nama, deskripsi = :deskripsi, potongan = :potongan, valid_from = :valid_from, valid_until = :valid_until WHERE id = :id;";

        $stmt = $conn->prepare($q);
        $stmt->bindParam(':id', $arr['id']);
        $stmt->bindParam(':nama', $arr['nama']);
        $stmt->bindParam(':deskripsi', $arr['deskripsi']);
        $stmt->bindParam(':potongan', $arr['potongan']);
        $stmt->bindParam(':valid_from', $arr['valid_from']);
        $stmt->bindParam(':valid_until', $arr['valid_until']);

        return $stmt->execute();
    }



    public function delete_user($id)
    {
        $delete_data = "DELETE FROM `user` WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $success = $delete_data->execute([$id]);

        return $success;
    }

    public function delete_pengiriman($id)
    {
        $delete_data = "DELETE FROM `pengiriman` WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $success = $delete_data->execute([$id]);

        return $success;
    }


    public function delete_promo($id)
    {
        $delete_data = "DELETE FROM `promo` WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $success = $delete_data->execute([$id]);

        return $success;
    }

    public function delete_admin($id)
    {
        $delete_data = "DELETE FROM `admin` WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $success = $delete_data->execute([$id]);

        return $success;
    }

    public function delete_barang($id)
    {
        $delete_data = "DELETE FROM `barang` WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $success = $delete_data->execute([$id]);

        return $success;
    }



    public function delete()
    {
        $q = "DELETE FROM Admin WHERE username = :username;";
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':username', $this->row['username']);
        $res = $stmt->execute();
        return $res;
    }

    public function get_row()
    {
        return $this->row;
    }


    public function tampil_user()
    {
        $select_data = "SELECT * FROM `user` ";
        $select_data = $this->db->prepare($select_data);
        $select_data->execute();

        return $select_data;
    }


    public function tampil_admin()
    {
        $select_data = "SELECT * FROM `admin` ";
        $select_data = $this->db->prepare($select_data);
        $select_data->execute();

        return $select_data;
    }

    public function tampil_barang()
    {
        $select_data = "SELECT * FROM `barang` ";
        $select_data = $this->db->prepare($select_data);
        $select_data->execute();

        return $select_data;
    }
    /**
     * Static function sama sperti java static method
     * Get all Users
     */
    public static function get_all()
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM Admin";
        $stmt = $conn->query($query);
        return $stmt->fetchAll();
    }

    public static function search_by($username = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM Admin where username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function check_Admin($username = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM admin where username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function check_Admin1($username = null, $password = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public static function getId($username, $password)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT id FROM  WHERE username = :username and password = :password";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_id_username($id)
    {
        $check_id = "SELECT id FROM `user` WHERE id = ?";
        $check_id = $this->db->prepare($check_id);
        $check_id->execute([$id]);
        return $check_id;
    }


    public function get_id_admin($id)
    {
        $check_id = "SELECT id FROM `admin` WHERE id = ?";
        $check_id = $this->db->prepare($check_id);
        $check_id->execute([$id]);
        return $check_id;
    }


    public function get_id_pengiriman($id)
    {
        $check_id = "SELECT id FROM `pengiriman` WHERE id = ?";
        $check_id = $this->db->prepare($check_id);
        $check_id->execute([$id]);
        return $check_id;
    }
    public function get_id_promo($id)
    {
        $check_id = "SELECT id FROM `promo` WHERE id = ?";
        $check_id = $this->db->prepare($check_id);
        $check_id->execute([$id]);
        return $check_id;
    }

    public function get_id_barang($id)
    {
        $check_id = "SELECT id FROM `barang` WHERE id = ?";
        $check_id = $this->db->prepare($check_id);
        $check_id->execute([$id]);
        return $check_id;
    }


    public static function check_uname($username = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT `username` FROM Admin where username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function check_pass($password = null)
    {
        $conn = Admin::get_db_connection();
        $query = "SELECT `password` FROM Admin where password = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Create new Admin
     */
    public static function create_Admin($arr = ['username' => null, 'email' => null, 'notelp' => null, 'password' => null])
    {
        $conn = Admin::get_db_connection();
        $sql = "INSERT INTO Admin (`username`, `email`, `notelp`, `password`) VALUES (:username, :email, :notelp, :password)";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $arr['username']);
        $stmt->bindParam(':password', $arr['password']);
        $stmt->bindParam(':email', $arr['email']);
        $stmt->bindParam(':notelp', $arr['notelp']);


        // Execute the prepared statement
        $stmt->execute();
        return $stmt;
    }

    public static function create_promo($arr = ['nama' => null, 'deskripsi' => null, 'potongan' => null, 'valid_from' => null, 'valid_until' => null])
    {
        $conn = Admin::get_db_connection();
        $sql = "INSERT INTO promo (`nama`, `deskripsi`, `potongan`, `valid_from`, `valid_until`) VALUES (:nama, :deskripsi, :potongan, :valid_from, :valid_until)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nama', $arr['nama']);
        $stmt->bindParam(':deskripsi', $arr['deskripsi']);
        $stmt->bindParam(':potongan', $arr['potongan']);
        $stmt->bindParam(':valid_from', $arr['valid_from']);
        $stmt->bindParam(':valid_until', $arr['valid_until']);

        $stmt->execute();
        return $stmt;
    }

    public static function create_pengiriman($arr = ['jenis_pengiriman' => null, 'deskripsi' => null, 'harga' => null])
    {
        $conn = Admin::get_db_connection();
        $sql = "INSERT INTO pengiriman (`jenis_pengiriman`, `deskripsi`, `harga`) VALUES (:jenis_pengiriman, :deskripsi, :harga)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':jenis_pengiriman', $arr['jenis_pengiriman']);
        $stmt->bindParam(':deskripsi', $arr['deskripsi']);
        $stmt->bindParam(':harga', $arr['harga']);

        $stmt->execute();
        return $stmt;
    }



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
