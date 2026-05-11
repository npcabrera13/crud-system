<?php

namespace Classes;

use PDO;

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

    public function initConnection()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;port=$this->port";

        try {
            $pdo = new PDO($dsn, $this->user, $this->pass, $this->options);
            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
}
