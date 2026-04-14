<?php

require_once __DIR__ . '/Pdo.php';

class Project
{
    public string $firstname;
    public string $middlename;
    public string $lastname;
    public string $suffix;

    private $con;
    private string $response;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getPost(): void
    {
        if (!empty($_POST)) {
            $this->firstname = isset($_POST['fname']) ? $_POST['fname'] : $_POST['firstname'];
            $this->middlename = isset($_POST['mname']) ? $_POST['mname'] : $_POST['middlename'];
            $this->lastname = isset($_POST['lname']) ? $_POST['lname'] : $_POST['lastname'];
            $this->suffix = $_POST['suffix'];
        }
    }

    public function Add(): void
    {
        if (isset($_POST['Add'])) {
            $this->getPost();
            $stmt = $this->con->prepare("INSERT INTO membership (firstname,middlename,lastname,suffix) VALUES (?,?,?,?)");
            $stmt->execute([
                $this->firstname,
                $this->middlename,
                $this->lastname,
                $this->suffix,
            ]);
            $this->responseSQL($stmt);
            header('Location: ../index.php');
            exit;
        }
    }

    public function getAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM membership');
        $stmt->execute();
        if (!$stmt->rowCount()) {
            return [];
        }
        return $stmt->fetchAll();
    }

    public function getAllCount()
    {
        $stmt = $this->con->prepare('SELECT COUNT(*) FROM membership');
        $stmt->execute();
        if (!$stmt->rowCount()) {
            return [];
        }
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $stmt = $this->con->prepare("DELETE FROM membership WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function view($id)
    {
        if (!$id) return 0;
        $stmt = $this->con->prepare('SELECT * FROM membership WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() ? $stmt->fetch() : 0;
    }

    public function update($id)
    {
        // POST
        $this->getPost();
        if (!empty($_POST)) {
            // Query here
            $stmt = $this->con->prepare('UPDATE membership SET firstname = ?, middlename = ?, lastname = ?, suffix = ? WHERE id = ?');
            $stmt->execute([
                $this->firstname,
                $this->middlename,
                $this->lastname,
                $this->suffix,
                $id
            ]);
            $this->responseSQL($stmt);
            header('Location: index.php');
            // header('Location: view.php?id=' . $id . '');
            // return promise
        }
    }

    public function responseSQL($stmt)
    {
        if ($stmt->rowCount()) {
            $this->response = 'success';
            return;
        }
        $this->response = 'failed';
    }

    public function getResponse()
    {
        return $this->response;
    }
}

$project = new Project($db);
$Project = $project; // Keep uppercase for backward compatibility if needed
