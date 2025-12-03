<?php
class Database {
    private $host = "localhost";
    private $db_name = "siboru";       // Pastikan nama database benar
    private $username = "root";
    private $password = "";            // Password Laragon biasanya kosong
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES utf8");
        } catch(PDOException $e) {
            // Jangan tampilkan error ke user di production
            error_log("Database error: " . $e->getMessage());
            die("Database connection error. Please try again later.");
        }
        return $this->conn;
    }
}
?>