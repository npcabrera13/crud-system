<?php

require_once __DIR__ . '/Pdo.php';

// Load PHPMailer classes (Adjusted paths to match your folder)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../../PHPMailer-master/src/SMTP.php';

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
            
            // Send submission email confirmation
            $lastId = $this->con->lastInsertId();
            $this->sendEmail($lastId, 'submitted');
            
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

            // Send notification email
            $this->sendEmail($id, 'updated');

            header('Location: /crud/Research/index.php');
            exit;
        }
    }

    public function delete($id)
    {
        // Send email before deleting
        $this->sendEmail($id, 'deleted');

        $stmt = $this->con->prepare("DELETE FROM researches WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    // Handles the POST actions for the Accept and Decline buttons
    public function handleApprovals()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accept_id'])) {
                if ($this->sendEmail($_POST['accept_id'], 'accepted')) {
                    $_SESSION['email_status'] = "Research Accepted and email sent successfully!";
                } else {
                    $_SESSION['email_status'] = "Research Accepted, but email notification failed. Please check SMTP settings.";
                }
                $this->accept($_POST['accept_id']);
                header("Location: index.php");
                exit;
            }
            if (isset($_POST['decline_id'])) {
                if ($this->sendEmail($_POST['decline_id'], 'declined')) {
                    $_SESSION['email_status'] = "Notification email sent regarding the rejection.";
                } else {
                    $_SESSION['email_status'] = "Research Declined, but email notification failed.";
                }
                $this->decline($_POST['decline_id']);
                header("Location: index.php");
                exit;
            }
        }
    }

    // Sends email notifications based on action type
    private function sendEmail($id, $type)
    {
        // If it's update/delete, check main researches table, else check temp
        if ($type === 'updated' || $type === 'deleted') {
            $stmt = $this->con->prepare("SELECT * FROM researches WHERE id = ?");
        } else {
            $stmt = $this->con->prepare("SELECT * FROM temp_research WHERE id = ?");
        }
        
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) return;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'visionarywebco@gmail.com';
            $mail->Password = 'kqrzoggmmufzxlpk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('visionarywebco@gmail.com', 'Research Department');
            $mail->addAddress($row['email_address']);
            $mail->isHTML(true);

            $title = strtoupper($row['research_title']);

            if ($type === 'accepted') {
                $mail->Subject = 'Research Proposal Accepted';
                $mail->Body = "<h3>Congratulations!</h3><p>Your research proposal titled <b>$title</b> has been <b>Accepted</b>. You may now proceed with your research.</p>";
            } elseif ($type === 'declined') {
                $mail->Subject = 'Research Proposal Status Update';
                $mail->Body = "<h3>Notice of Status</h3><p>We regret to inform you that your research proposal titled <b>$title</b> has been <b>Declined</b> at this time.</p>";
            } elseif ($type === 'submitted') {
                $mail->Subject = 'Research Proposal Submitted';
                $mail->Body = "<h3>Thank You!</h3><p>Your research proposal titled <b>$title</b> has been successfully <b>Submitted</b> and is currently pending admin review.</p>";
            } elseif ($type === 'updated') {
                $mail->Subject = 'Research Details Updated';
                $mail->Body = "<h3>Research Update</h3><p>Your research titled <b>$title</b> has been successfully updated in the system.</p>";
            } elseif ($type === 'deleted') {
                $mail->Subject = 'Research Entry Removed';
                $mail->Body = "<h3>Notice of Removal</h3><p>The research entry for <b>$title</b> has been removed from the ROMIS system.</p>";
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
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
            
            // If the status is PUBLISHED, we set the publication_status accordingly
            $pubStatus = (strtoupper($row['research_status']) === 'PUBLISHED') ? 'PUBLISHED' : 'NOT SUBMITTED';
            
            $stmt->execute([
                $row['research_date'], $row['research_title'], $row['co_authors'], $row['email_address'],
                $row['campus'], $row['college'], $row['date_started'], $row['target_completion_date'],
                strtoupper($row['research_status']), $row['description_abstract'], $row['research_agenda'],
                $row['sdg_goals'], $pubStatus
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

    // Import from CSV with Target Selection and Duplicate Checking
    public function importFromCSV($filePath, $target = 'pending')
    {
        $handle = fopen($filePath, "r");
        if ($handle !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            if (!$headers) return "Empty File";

            $expectedHeaders = ['research_date', 'research_title', 'co_authors', 'email_address', 'campus', 'college', 'date_started', 'target_completion_date', 'research_status', 'description_abstract', 'research_agenda', 'sdg_goals', 'publication_status'];
            
            $headers = array_map('trim', array_map('strtolower', $headers));
            foreach ($expectedHeaders as $expected) {
                if (!in_array($expected, $headers)) {
                    fclose($handle);
                    return "Invalid Format: Missing column '$expected'";
                }
            }

            $inserted = 0;
            $skipped = 0;
            $tableName = ($target === 'main') ? 'researches' : 'temp_research';
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row = array_combine($headers, $data);
                $title = trim($row['research_title']);

                // Duplicate Check in BOTH tables
                $check = $this->con->prepare("SELECT id FROM researches WHERE research_title = ? UNION SELECT id FROM temp_research WHERE research_title = ?");
                $check->execute([$title, $title]);
                if ($check->rowCount() > 0) {
                    $skipped++;
                    continue;
                }
                
                $status = ($target === 'main') ? 'PROPOSAL' : ($row['research_status'] ?? 'PROPOSAL');

                $stmt = $this->con->prepare("INSERT INTO $tableName (research_date, research_title, co_authors, email_address, campus, college, date_started, target_completion_date, research_status, description_abstract, research_agenda, sdg_goals, publication_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([
                    $row['research_date'] ?? date('Y-m-d'),
                    $title,
                    $row['co_authors'] ?? '',
                    $row['email_address'] ?? '',
                    $row['campus'] ?? '',
                    $row['college'] ?? '',
                    $row['date_started'] ?? date('Y-m-d'),
                    $row['target_completion_date'] ?? date('Y-m-d'),
                    $status,
                    $row['description_abstract'] ?? '',
                    $row['research_agenda'] ?? '',
                    $row['sdg_goals'] ?? '',
                    $row['publication_status'] ?? 'NOT SUBMITTED'
                ]);
                $inserted++;
            }
            fclose($handle);
            return ['inserted' => $inserted, 'skipped' => $skipped, 'target' => $target];
        }
        return "System Error: Could not read file";
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
