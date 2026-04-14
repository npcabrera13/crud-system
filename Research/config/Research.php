<?php

require_once __DIR__ . '/Pdo.php';

class Research
{
    public $research_date;
    public $research_title;
    public $co_authors;
    public $email_address;
    public $campus;
    public $college;
    public $date_started;
    public $target_completion_date;
    public $research_status;
    public $description_abstract;
    public $research_agenda;
    public $sdg_goals;
    public $publication_status;

    private $con;
    private string $response;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getPost(): void
    {
        if (!empty($_POST)) {
            $this->research_date = $_POST['research_date'];
            $this->research_title = $_POST['research_title'];
            $this->co_authors = $_POST['co_authors'];
            $this->email_address = $_POST['email_address'];
            $this->campus = $_POST['campus'];
            $this->college = $_POST['college'];
            $this->date_started = $_POST['date_started'];
            $this->target_completion_date = $_POST['target_completion_date'];
            $this->research_status = $_POST['research_status'];
            $this->description_abstract = $_POST['description_abstract'];
            $this->research_agenda = $_POST['research_agenda'];
            $this->sdg_goals = isset($_POST['sdg_goals']) ? implode(", ", $_POST['sdg_goals']) : '';
            $this->publication_status = $_POST['publication_status'];
        }
    }

    public function Add(): void
    {
        if (isset($_POST['Add'])) {
            $this->getPost();
            $stmt = $this->con->prepare("INSERT INTO temp_research (research_date, research_title, co_authors, email_address, campus, college, date_started, target_completion_date, research_status, description_abstract, research_agenda, sdg_goals, publication_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $this->research_date,
                $this->research_title,
                $this->co_authors,
                $this->email_address,
                $this->campus,
                $this->college,
                $this->date_started,
                $this->target_completion_date,
                $this->research_status,
                $this->description_abstract,
                $this->research_agenda,
                $this->sdg_goals,
                $this->publication_status,
            ]);
            $this->responseSQL($stmt);
            header('Location: /crud/Research/index.php');
            exit;
        }
    }

    public function getAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM researches ORDER BY id DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* ==================================================================================
       REASEARCH APPROVAL WORKFLOW FUNCTIONS (TEMPORARY RESEARCH)
       ================================================================================== */

    // Fetches all pending applications from the temp_research table
    public function getTempAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM temp_research');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function view($id)
    {
        if (!$id)
            return 0;
        $stmt = $this->con->prepare('SELECT * FROM researches WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() ? $stmt->fetch() : 0;
    }

    public function update($id)
    {
        if (isset($_POST['Update'])) {
            $this->getPost();
            $stmt = $this->con->prepare('UPDATE researches SET research_date = ?, research_title = ?, co_authors = ?, email_address = ?, campus = ?, college = ?, date_started = ?, target_completion_date = ?, research_status = ?, description_abstract = ?, research_agenda = ?, sdg_goals = ?, publication_status = ? WHERE id = ?');
            $stmt->execute([
                $this->research_date,
                $this->research_title,
                $this->co_authors,
                $this->email_address,
                $this->campus,
                $this->college,
                $this->date_started,
                $this->target_completion_date,
                $this->research_status,
                $this->description_abstract,
                $this->research_agenda,
                $this->sdg_goals,
                $this->publication_status,
                $id
            ]);
            $this->responseSQL($stmt);
            header('Location: /crud/Research/index.php');
            exit;
        }
    }

    public function delete($id)
    {
        $stmt = $this->con->prepare("DELETE FROM researches WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    // Handles the POST actions for the Accept and Decline buttons
    public function handleApprovals()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accept_id'])) {
                $this->accept($_POST['accept_id']);
                header("Location: index.php");
                exit;
            }
            if (isset($_POST['decline_id'])) {
                $this->decline($_POST['decline_id']);
                header("Location: index.php");
                exit;
            }
        }
    }

    // Moves a record from temp_research to the main researches table
    public function accept($id)
    {
        $stmt = $this->con->prepare("SELECT * FROM temp_research WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            $stmt = $this->con->prepare("INSERT INTO researches (research_date, research_title, co_authors, email_address, campus, college, date_started, target_completion_date, research_status, description_abstract, research_agenda, sdg_goals, publication_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $row['research_date'], $row['research_title'], $row['co_authors'], $row['email_address'],
                $row['campus'], $row['college'], $row['date_started'], $row['target_completion_date'],
                $row['research_status'], $row['description_abstract'], $row['research_agenda'],
                $row['sdg_goals'], $row['publication_status']
            ]);
            $this->decline($id);
            return true;
        }
        return false;
    }

    // Permanently deletes a record from the temp_research table
    public function decline($id)
    {
        $stmt = $this->con->prepare("DELETE FROM temp_research WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function responseSQL($stmt)
    {
        if ($stmt->rowCount()) {
            $this->response = 'success';
            return;
        }
        $this->response = 'failed';
    }
}

$research = new Research($db);
