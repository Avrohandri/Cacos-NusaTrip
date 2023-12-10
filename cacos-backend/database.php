<?php
class Database {
    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "travel";
    protected $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
