<?php
require_once "Faculty/config/Pdo.php";

/**
 * MOCK DATA GENERATOR
 * This is a hidden utility page to populate the system with 10 faculty and 10 research records.
 */

$message = "";

if (isset($_POST['generate_faculty'])) {
    try {
        $faculties = [
            ['Maria', 'Santos', 'Dela Cruz', 'maria.dc@univ.edu.ph', 'EMP-2024-001', 'Professor', 'Female', '1975-03-12', 'CAS', 'Main Campus'],
            ['Juan', 'Luna', 'Ramos', 'juan.ramos@univ.edu.ph', 'EMP-2024-002', 'Associate Professor', 'Male', '1982-07-25', 'COE', 'San Isidro Campus'],
            ['Elena', 'Grace', 'Torres', 'elena.t@univ.edu.ph', 'EMP-2024-003', 'Assistant Professor', 'Female', '1990-11-05', 'CBA', 'Main Campus'],
            ['Ricardo', 'Dalisay', 'Fernandez', 'carding@univ.edu.ph', 'EMP-2024-004', 'Instructor', 'Male', '1995-01-30', 'CCIT', 'San Isidro Campus'],
            ['Sofia', 'Isabelle', 'Reyes', 'sofia.reyes@univ.edu.ph', 'EMP-2024-005', 'Professor', 'Female', '1970-05-15', 'COE', 'Main Campus'],
            ['Antonio', 'P.', 'Contreras', 'antonio.c@univ.edu.ph', 'EMP-2024-006', 'Assistant Professor', 'Male', '1988-09-20', 'CAS', 'San Isidro Campus'],
            ['Liza', 'S.', 'Mendoza', 'liza.m@univ.edu.ph', 'EMP-2024-007', 'Instructor', 'Female', '1992-04-10', 'CCIT', 'Main Campus'],
            ['Gabriel', 'M.', 'Santos', 'gab.santos@univ.edu.ph', 'EMP-2024-008', 'Associate Professor', 'Male', '1980-12-01', 'CBA', 'San Isidro Campus'],
            ['Victoria', 'A.', 'Bautista', 'vicky.b@univ.edu.ph', 'EMP-2024-009', 'Professor', 'Female', '1972-08-18', 'COE', 'Main Campus'],
            ['Manuel', 'L.', 'Quezon', 'mlq@univ.edu.ph', 'EMP-2024-010', 'Instructor', 'Male', '1994-02-14', 'CAS', 'San Isidro Campus']
        ];

        foreach ($faculties as $f) {
            $stmt = $db->prepare("INSERT INTO faculties (first_name, middle_name, last_name, email_address, employee_no, academic_rank, gender, birthday, college, campus, date_created) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$f[0], $f[1], $f[2], $f[3], $f[4], $f[5], $f[6], $f[7], $f[8], $f[9], date('Y-m-d')]);
        }
        $message = "Successfully generated 10 Faculty records!";
    } catch (Exception $e) { $message = "Error: " . $e->getMessage(); }
}

if (isset($_POST['generate_research'])) {
    try {
        $researches = [
            ['Solar Energy Efficiency in Rural Areas', 'maria.dc@univ.edu.ph', 'Main Campus', 'PROPOSAL'],
            ['AI-Driven Crop Monitoring System', 'juan.ramos@univ.edu.ph', 'San Isidro Campus', 'ONGOING'],
            ['Impact of Online Learning on Mental Health', 'elena.t@univ.edu.ph', 'Main Campus', 'PROPOSAL'],
            ['Blockchain for Secure Student Records', 'carding@univ.edu.ph', 'San Isidro Campus', 'PROPOSAL'],
            ['Sustainable Urban Architecture', 'sofia.reyes@univ.edu.ph', 'Main Campus', 'ONGOING'],
            ['Linguistic Evolution in Philippine Dialects', 'antonio.c@univ.edu.ph', 'San Isidro Campus', 'PROPOSAL'],
            ['E-Commerce Trends Post-Pandemic', 'liza.m@univ.edu.ph', 'Main Campus', 'ONGOING'],
            ['Climate Change Resilience in Coastal Cities', 'gab.santos@univ.edu.ph', 'San Isidro Campus', 'PROPOSAL'],
            ['Next-Gen Battery Technology', 'vicky.b@univ.edu.ph', 'Main Campus', 'PROPOSAL'],
            ['Ethical Implications of Gene Editing', 'mlq@univ.edu.ph', 'San Isidro Campus', 'ONGOING']
        ];

        foreach ($researches as $r) {
            $stmt = $db->prepare("INSERT INTO temp_research (research_title, email_address, campus, research_status, research_date, date_started, target_completion_date) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$r[0], $r[1], $r[2], $r[3], date('Y-m-d'), date('Y-m-d'), date('Y-m-d', strtotime('+1 year'))]);
        }
        $message = "Successfully generated 10 Pending Research records!";
    } catch (Exception $e) { $message = "Error: " . $e->getMessage(); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mock Data Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        <h2 class="fw-bold mb-4">ROMIS Mock Data Utility</h2>
                        <p class="mb-4 text-light">Clicking the button below will insert 10 Faculty members and 10 Pending Research proposals into your database for testing purposes.</p>
                        
                        <?php if($message): ?>
                            <div class="alert alert-info"><?= $message ?></div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-6">
                                <form method="POST">
                                    <button type="submit" name="generate_faculty" class="btn btn-primary w-100 py-3 fw-bold">
                                        <i class="bi bi-people"></i><br>Gen 10 Faculty
                                    </button>
                                </form>
                                <a href="Faculty/crud/template.php" class="btn btn-outline-light btn-sm mt-2 w-100">
                                    <i class="bi bi-download"></i> Faculty Template
                                </a>
                            </div>
                            <div class="col-6">
                                <form method="POST">
                                    <button type="submit" name="generate_research" class="btn btn-success w-100 py-3 fw-bold">
                                        <i class="bi bi-file-earmark-text"></i><br>Gen 10 Research
                                    </button>
                                </form>
                                <a href="Research/crud/template.php" class="btn btn-outline-light btn-sm mt-2 w-100">
                                    <i class="bi bi-download"></i> Research Template
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-5 pt-3 border-top border-secondary">
                            <p class="small text-white-50">Note: Use the "Template" buttons above to download the Excel formats you need for manual importing.</p>
                            <a href="index.php" class="text-white-50 small text-decoration-none">← Return to System</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
