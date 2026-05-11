<?php

require_once __DIR__ . '/Pdo.php';
require_once __DIR__ . '/../../Research/config/filepic.php';

use Classes\FileUpload;

class Faculty
{
    public string $first_name;
    public string $middle_name;
    public string $last_name;
    public string $employee_no;
    public string $academic_rank;
    public string $date_created;
    public string $gender;
    public string $birthday;
    public string $contact_number;
    public string $city_municipality;
    public string $province;
    public string $discipline;
    public string $campus;
    public string $college;
    public string $google_scholar_id;
    public string $research_gate_id;
    public string $scopus_id;
    public string $web_of_science_id;
    public string $image;

    private $con;
    private string $response;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getPost(): void
    {
        if (!empty($_POST)) {
            $this->first_name = $_POST['first_name'] ?? '';
            $this->middle_name = $_POST['middle_name'] ?? '';
            $this->last_name = $_POST['last_name'] ?? '';
            $this->employee_no = $_POST['employee_no'];
            $this->academic_rank = $_POST['academic_rank'];
            $this->date_created = $_POST['date_created'];
            $this->gender = $_POST['gender'];
            $this->birthday = $_POST['birthday'];
            $this->contact_number = $_POST['contact_number'];
            $this->city_municipality = $_POST['city_municipality'];
            $this->province = $_POST['province'];
            $this->discipline = $_POST['discipline'];
            $this->campus = $_POST['campus'];
            $this->college = $_POST['college'];
            $this->google_scholar_id = $_POST['google_scholar_id'];
            $this->research_gate_id = $_POST['research_gate_id'];
            $this->scopus_id = $_POST['scopus_id'];
            $this->web_of_science_id = $_POST['web_of_science_id'];
            $this->image = $_POST['image'] ?? '';
        }
    }

    public function Add(): void
    {
        if (isset($_POST['Add'])) {
            $this->getPost();

            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $uploads = new FileUpload($_FILES['image'], '../../pics/');
                if ($uploads->upload()) {
                    $this->image = $uploads->fileName;
                }
            }

            $stmt = $this->con->prepare("INSERT INTO faculties (first_name, middle_name, last_name, employee_no, academic_rank, date_created, gender, birthday, contact_number, city_municipality, province, discipline, campus, college, google_scholar_id, research_gate_id, scopus_id, web_of_science_id, image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $this->first_name,
                $this->middle_name,
                $this->last_name,
                $this->employee_no,
                $this->academic_rank,
                $this->date_created,
                $this->gender,
                $this->birthday,
                $this->contact_number,
                $this->city_municipality,
                $this->province,
                $this->discipline,
                $this->campus,
                $this->college,
                $this->google_scholar_id,
                $this->research_gate_id,
                $this->scopus_id,
                $this->web_of_science_id,
                $this->image,
            ]);
            $this->responseSQL($stmt);
            header('Location: /crud/Faculty/index.php');
            exit;
        }
    }

    public function getAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM faculties');
        $stmt->execute();
        if (!$stmt->rowCount()) {
            return [];
        }
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $stmt = $this->con->prepare("DELETE FROM faculties WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function view($id)
    {
        if (!$id)
            return 0;
        $stmt = $this->con->prepare('SELECT * FROM faculties WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() ? $stmt->fetch() : 0;
    }

    public function update($id)
    {
        $this->getPost();
        if (!empty($_POST)) {
            // Handle image upload if a new one is provided
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $uploads = new FileUpload($_FILES['image'], '../../pics/');
                if ($uploads->upload()) {
                    $this->image = $uploads->fileName;
                }
            } else {
                // Keep the old image if no new one is uploaded
                $existing = $this->view($id);
                $this->image = $existing['image'] ?? '';
            }

            $stmt = $this->con->prepare('UPDATE faculties SET first_name = ?, middle_name = ?, last_name = ?, employee_no = ?, academic_rank = ?, date_created = ?, gender = ?, birthday = ?, contact_number = ?, city_municipality = ?, province = ?, discipline = ?, campus = ?, college = ?, google_scholar_id = ?, research_gate_id = ?, scopus_id = ?, web_of_science_id = ?, image = ? WHERE id = ?');
            $stmt->execute([
                $this->first_name,
                $this->middle_name,
                $this->last_name,
                $this->employee_no,
                $this->academic_rank,
                $this->date_created,
                $this->gender,
                $this->birthday,
                $this->contact_number,
                $this->city_municipality,
                $this->province,
                $this->discipline,
                $this->campus,
                $this->college,
                $this->google_scholar_id,
                $this->research_gate_id,
                $this->scopus_id,
                $this->web_of_science_id,
                $this->image,
                $id
            ]);
            $this->responseSQL($stmt);
            header('Location: /crud/Faculty/index.php');
            exit;
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

$faculty = new Faculty($db);
