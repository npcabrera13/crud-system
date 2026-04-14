<?php
class Database
{

    private $host = 'localhost';
    private $db = 'biodata';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';
    private $port = '3306';

    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    private $pdo;
    private $dsn;


    public function initConnection()
    {
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;port=$this->port";

        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass, $this->options);

            // ✅ Set PHP timezone (server-side)
            date_default_timezone_set('Asia/Manila');

            // ✅ Set MySQL timezone (database-side)
            $this->pdo->exec("SET time_zone = '+08:00'");

            // One-time migration: rename columns if old names still exist
            try {
                $this->pdo->exec("ALTER TABLE membership CHANGE fname firstname VARCHAR(255)");
                $this->pdo->exec("ALTER TABLE membership CHANGE mname middlename VARCHAR(255)");
                $this->pdo->exec("ALTER TABLE membership CHANGE lname lastname VARCHAR(255)");
            } catch (\PDOException $e) {
                // Columns already renamed, ignore
            }

        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $this->pdo;
    }
}

$connect = new Database();
$db = $connect->initConnection();