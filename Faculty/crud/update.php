<?php
include "../config/Faculty.php";

if (isset($_GET['id'])) {
    $data = $faculty->view($_GET['id']);
}

if (isset($_POST['update'])) {
    $faculty->update($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Faculty</title>
    <?php include "../config/libraries.php"; ?>
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
            <a class="nav-link active" href="#">Updating Record</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="container bg-white p-5 shadow-sm rounded">
        <h1 class="mb-4">Update Faculty Record</h1>
        <form class="row g-3" method="POST" enctype="multipart/form-data">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($data['first_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="<?= htmlspecialchars($data['middle_name']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($data['last_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email_address" class="form-control" value="<?= htmlspecialchars($data['email_address']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Employee No.</label>
                    <input type="text" name="employee_no" class="form-control" value="<?= htmlspecialchars($data['employee_no']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Academic Rank</label>
                    <input type="text" name="academic_rank" class="form-control" value="<?= htmlspecialchars($data['academic_rank']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date Created</label>
                    <input type="text" name="date_created" class="form-control" value="<?= htmlspecialchars($data['date_created']) ?>" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="Male" <?= ($data['gender']) == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= ($data['gender']) == 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Birthday</label>
                        <input type="text" name="birthday" class="form-control" value="<?= htmlspecialchars($data['birthday']) ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="<?= htmlspecialchars($data['contact_number']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">City/Municipality</label>
                    <input type="text" name="city_municipality" class="form-control" value="<?= htmlspecialchars($data['city_municipality']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Province</label>
                    <input type="text" name="province" class="form-control" value="<?= htmlspecialchars($data['province']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Update Profile Picture</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Current image: <?= $data['image'] ?: 'None' ?></small>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Discipline</label>
                    <input type="text" name="discipline" class="form-control" value="<?= htmlspecialchars($data['discipline']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Campus</label>
                    <input type="text" name="campus" class="form-control" value="<?= htmlspecialchars($data['campus']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">College</label>
                    <input type="text" name="college" class="form-control" value="<?= htmlspecialchars($data['college']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Google Scholar ID</label>
                    <input type="text" name="google_scholar_id" class="form-control" value="<?= htmlspecialchars($data['google_scholar_id']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Research Gate ID</label>
                    <input type="text" name="research_gate_id" class="form-control" value="<?= htmlspecialchars($data['research_gate_id']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Scopus ID</label>
                    <input type="text" name="scopus_id" class="form-control" value="<?= htmlspecialchars($data['scopus_id']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Web of Science ID</label>
                    <input type="text" name="web_of_science_id" class="form-control" value="<?= htmlspecialchars($data['web_of_science_id']) ?>">
                </div>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" name="update" class="btn btn-outline-primary px-4">Update</button>
                <a href="../index.php" class="btn btn-outline-danger px-4">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
