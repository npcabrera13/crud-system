<?php
class Database
{
    private $host = '127.0.0.1';
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
            date_default_timezone_set('Asia/Manila');
            $this->pdo->exec("SET time_zone = '+08:00'");
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage(), (int) $e->getCode());
        }

        return $this->pdo;
    }
}

$connect = new Database();
$db = $connect->initConnection();
