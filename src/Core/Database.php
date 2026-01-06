<?php
require_once __DIR__ . '/../../autoload.php';

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=Apex_Manager;charset=utf8mb4", 
            "root",
            "laarif+osb2002",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
?>
