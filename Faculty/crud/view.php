<?php
include "../config/Faculty.php";

if (isset($_GET['id'])) {
    $row = $faculty->view($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Faculty</title>
    <?php include "../config/libraries.php"; ?>
    <style>
        .form-label {
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 0.9rem;
        }

        .form-control {
            background-color: #f8f9fa;
        }
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
                    <a class="nav-link active" href="#">Viewing Details</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container bg-white p-5 shadow-sm rounded">
        <h1 class="mb-4">Faculty Information</h1>

        <?php if (!empty($row['image'])): ?>
            <div class="mb-4 text-center">
                <img src="../../pics/<?= htmlspecialchars($row['image']) ?>" alt="Profile Picture"
                    style="width: 150px; height: 150px; border-radius: 10%;">
            </div>
        <?php endif; ?>

        <form class="row g-3">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Employee No.</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['employee_no']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Academic Rank</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['academic_rank']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date Created</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['date_created']) ?>"
                        readonly>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($row['gender']) ?>"
                            readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Birthday</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($row['birthday']) ?>"
                            readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['contact_number']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">City/Municipality</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['city_municipality']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Province</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['province']) ?>" readonly>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Discipline</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['discipline']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Campus</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['campus']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">College</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['college']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Google Scholar ID</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['google_scholar_id']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Research Gate ID</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['research_gate_id']) ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Scopus ID</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['scopus_id']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Web of Science ID</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($row['web_of_science_id']) ?>"
                        readonly>
                </div>
            </div>

            <div class="col-12 mt-3">
                <a href="../index.php" class="btn btn-outline-secondary px-4">Go Back</a>
            </div>
        </form>
    </div>
</body>

</html>