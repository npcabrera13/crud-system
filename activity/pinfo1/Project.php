<?php

namespace Classes;

use Classes\Pdo;

// PDO DB
require_once "Pdo.php"; //yours is Database.php


class Project
{
    public string $fname;
    public string $mname;
    public string $lname;

    private $con;
    private string $response;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getPost()
    {
        // Initialize project properties
        if (!empty($_POST)) {
            $this->fname = $_POST['fname'];
            $this->mname = $_POST['mname'];
            $this->lname = $_POST['lname'];
        }
    }

  
    public function getAll()
    {
        if (!$this->con) {
            return [];
        }
        $stmt = $this->con->prepare('SELECT * FROM users');
        $stmt->execute();
        if (!$stmt->rowCount()) {
            return [];
        }
        return $stmt->fetchAll();
    }

    public function responseSQL($stmt)
    {
        if ($stmt && $stmt->rowCount()) {
            $this->response = 'success';
            return;
        }
        $this->response = 'failed';
    }
    /**
     * Get the reponse from the query
     * @return string message
     */
    public function getResponse()
    {
        return $this->response;
    }
}

$Project = new Project(@$db);