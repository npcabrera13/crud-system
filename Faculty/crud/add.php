<?php
require_once '../config/Faculty.php';

$faculty->Add();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Faculty</title>
    <?php include '../config/libraries.php'; ?>
    <style>
        .form-label { font-weight: bold; margin-bottom: 2px; font-size: 0.9rem; }
        .form-control { background-color: #f8f9fa; }
    </style>
</head>
<body class="p-4 bg-light">
    <div class="card text-center mb-4">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Back to List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">Adding New</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="container bg-white p-5 shadow-sm rounded">
        <h1 class="mb-4">Add New Faculty</h1>
        <form class="row g-3" method="POST" enctype="multipart/form-data">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Employee No.</label>
                    <input type="text" name="employee_no" class="form-control" placeholder="e.g. 994" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Academic Rank</label>
                    <input type="text" name="academic_rank" class="form-control" placeholder="e.g. Associate Professor IV" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date Created</label>
                    <input type="text" name="date_created" class="form-control" placeholder="e.g. February 9, 2025" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Birthday</label>
                        <input type="text" name="birthday" class="form-control" placeholder="e.g. May 16, 1979" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" placeholder="e.g. 9454662124" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">City/Municipality</label>
                    <input type="text" name="city_municipality" class="form-control" placeholder="e.g. Cabanatuan City" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Province</label>
                    <input type="text" name="province" class="form-control" placeholder="e.g. Nueva Ecija" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Discipline</label>
                    <input type="text" name="discipline" class="form-control" placeholder="e.g. Information Technology" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Campus</label>
                    <input type="text" name="campus" class="form-control" placeholder="e.g. San Isidro Campus" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">College</label>
                    <input type="text" name="college" class="form-control" placeholder="e.g. College of ICT" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Google Scholar ID</label>
                    <input type="text" name="google_scholar_id" class="form-control" placeholder="URL">
                </div>
                <div class="mb-3">
                    <label class="form-label">Research Gate ID</label>
                    <input type="text" name="research_gate_id" class="form-control" placeholder="URL">
                </div>
                <div class="mb-3">
                    <label class="form-label">Scopus ID</label>
                    <input type="text" name="scopus_id" class="form-control" placeholder="URL">
                </div>
                <div class="mb-3">
                    <label class="form-label">Web of Science ID</label>
                    <input type="text" name="web_of_science_id" class="form-control" placeholder="URL">
                </div>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" name="Add" class="btn btn-primary px-4">Submit</button>
                <a href="../index.php" class="btn btn-outline-danger px-4">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
