<?php

require_once __DIR__ . '/Pdo.php';
require_once __DIR__ . '/../../Research/config/filepic.php';

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../../PHPMailer-master/src/SMTP.php';

use Classes\FileUpload;

class Faculty
{
    public string $first_name;
    public string $middle_name;
    public string $last_name;
    public string $email_address;
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
            $this->email_address = $_POST['email_address'] ?? '';
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

            $stmt = $this->con->prepare("INSERT INTO faculties (first_name, middle_name, last_name, email_address, employee_no, academic_rank, date_created, gender, birthday, contact_number, city_municipality, province, discipline, campus, college, google_scholar_id, research_gate_id, scopus_id, web_of_science_id, image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $this->first_name,
                $this->middle_name,
                $this->last_name,
                $this->email_address,
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

            // Send notification email
            $lastId = $this->con->lastInsertId();
            $this->sendEmail($lastId, 'added');

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
        // Send email before deleting so we still have the record
        $this->sendEmail($id, 'deleted');

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

            $stmt = $this->con->prepare('UPDATE faculties SET first_name = ?, middle_name = ?, last_name = ?, email_address = ?, employee_no = ?, academic_rank = ?, date_created = ?, gender = ?, birthday = ?, contact_number = ?, city_municipality = ?, province = ?, discipline = ?, campus = ?, college = ?, google_scholar_id = ?, research_gate_id = ?, scopus_id = ?, web_of_science_id = ?, image = ? WHERE id = ?');
            $stmt->execute([
                $this->first_name,
                $this->middle_name,
                $this->last_name,
                $this->email_address,
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

            // Send notification email
            $this->sendEmail($id, 'updated');

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

    // Import from CSV with Duplicate Checking and Reporting
    public function importFromCSV($filePath)
    {
        $handle = fopen($filePath, "r");
        if ($handle !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            if (!$headers) return "Empty File";

            $expectedHeaders = ['first_name', 'middle_name', 'last_name', 'email_address', 'employee_no', 'academic_rank', 'date_created', 'gender', 'birthday', 'contact_number', 'city_municipality', 'province', 'discipline', 'campus', 'college', 'google_scholar_id', 'research_gate_id', 'scopus_id', 'web_of_science_id'];
            
            $headers = array_map('trim', array_map('strtolower', $headers));
            foreach ($expectedHeaders as $expected) {
                if (!in_array($expected, $headers)) {
                    fclose($handle);
                    return "Invalid Format: Missing column '$expected'";
                }
            }

            $inserted = 0;
            $skipped = 0;
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row = array_combine($headers, $data);
                $empNo = trim($row['employee_no']);

                // Duplicate Check
                $check = $this->con->prepare("SELECT id FROM faculties WHERE employee_no = ?");
                $check->execute([$empNo]);
                if ($check->rowCount() > 0) {
                    $skipped++;
                    continue;
                }
                
                $stmt = $this->con->prepare("INSERT INTO faculties (first_name, middle_name, last_name, email_address, employee_no, academic_rank, date_created, gender, birthday, contact_number, city_municipality, province, discipline, campus, college, google_scholar_id, research_gate_id, scopus_id, web_of_science_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([
                    $row['first_name'] ?? '',
                    $row['middle_name'] ?? '',
                    $row['last_name'] ?? '',
                    $row['email_address'] ?? '',
                    $empNo,
                    $row['academic_rank'] ?? '',
                    $row['date_created'] ?? date('Y-m-d'),
                    $row['gender'] ?? '',
                    $row['birthday'] ?? '',
                    $row['contact_number'] ?? '',
                    $row['city_municipality'] ?? '',
                    $row['province'] ?? '',
                    $row['discipline'] ?? '',
                    $row['campus'] ?? '',
                    $row['college'] ?? '',
                    $row['google_scholar_id'] ?? '',
                    $row['research_gate_id'] ?? '',
                    $row['scopus_id'] ?? '',
                    $row['web_of_science_id'] ?? ''
                ]);
                $inserted++;
            }
            fclose($handle);
            return ['inserted' => $inserted, 'skipped' => $skipped];
        }
        return "System Error: Could not read file";
    }

    // Sends email notifications based on action type
    private function sendEmail($id, $type)
    {
        $stmt = $this->con->prepare("SELECT * FROM faculties WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row)
            return;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'visionarywebco@gmail.com';
            $mail->Password = 'kqrzoggmmufzxlpk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('visionarywebco@gmail.com', 'Faculty Department');
            $mail->addAddress($row['email_address']);
            $mail->isHTML(true);

            $name = strtoupper($row['first_name'] . ' ' . $row['last_name']);

            if ($type === 'added') {
                $mail->Subject = 'Faculty Profile Created';
                $mail->Body = "<h3>Welcome!</h3><p>A new faculty profile has been created for <b>$name</b> in the ROMIS system.</p>";
            } elseif ($type === 'updated') {
                $mail->Subject = 'Faculty Profile Updated';
                $mail->Body = "<h3>Profile Update</h3><p>The faculty profile for <b>$name</b> has been successfully updated.</p>";
            } elseif ($type === 'deleted') {
                $mail->Subject = 'Faculty Profile Removed';
                $mail->Body = "<h3>Notice of Removal</h3><p>The faculty profile for <b>$name</b> has been removed from the ROMIS system.</p>";
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

$faculty = new Faculty($db);
