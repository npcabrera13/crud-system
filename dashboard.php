<?php
require_once "Faculty/config/Analytics.php";
use Classes\Analytics;

$analytics = new Analytics();

// Fetch Real Data
$dbStatusData = $analytics->getResearchStatusDistribution();
$pubData    = $analytics->getPublicationStatusDistribution();
$campusData = $analytics->getResearchByCampus();
$collegeData = $analytics->getResearchByCollege();
$facultyStats = $analytics->getFacultyStats();

// Standardize Status Data to always show 4 statuses
$allStatuses = ['PROPOSAL' => 0, 'ONGOING' => 0, 'COMPLETED' => 0, 'PUBLISHED' => 0];
foreach ($dbStatusData as $row) {
    $allStatuses[strtoupper($row['label'])] = (int)$row['total'];
}
$statusData = [];
foreach ($allStatuses as $label => $total) {
    $statusData[] = ['label' => $label, 'total' => $total];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - ROMIS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .bg-purple {
            background-color: #9C27B0;
        }
        .faculty-summary-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .faculty-summary-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="bg-light">

    <!-- Global Nav -->
    <div class="card text-center mb-4 border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <ul class="nav nav-tabs card-header-tabs px-3">
                <li class="nav-item">
                    <a class="nav-link text-primary" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="analytics.php">Analytics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="Faculty/index.php">Faculty Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="Research/index.php">Research Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="Faculty/forms.php">Downloadable Forms</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container py-2">
        <!-- Status Summary Cards -->
        <div class="row mb-5 mt-3">
            <?php
            $statusCounts = ['PROPOSAL' => 0, 'ONGOING' => 0, 'COMPLETED' => 0, 'PUBLISHED' => 0];
            foreach ($statusData as $data) {
                $statusCounts[strtoupper($data['label'])] = $data['total'];
            }
            $colors = [
                'PROPOSAL' => 'bg-purple text-white',
                'ONGOING' => 'bg-primary text-white',
                'COMPLETED' => 'bg-success text-white',
                'PUBLISHED' => 'bg-danger text-white'
            ];
            ?>
            <?php foreach ($statusCounts as $label => $count): ?>
                <div class="col-md-3 mb-2">
                    <a href="Research/index.php?status=<?= $label ?>" class="text-decoration-none">
                        <div class="card shadow-sm border-0 <?= $colors[$label] ?? 'bg-secondary text-white' ?> text-center py-5 rounded-3"
                            style="transition: transform 0.2s; cursor: pointer;"
                            onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <h1 class="fw-bold mb-0"><?= $count ?></h1>
                            <span class="text-uppercase fw-bold"
                                style="letter-spacing: 2px; font-size: 1rem;"><?= $label ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <hr class="my-5 opacity-0">

        <!-- Centered Faculty Summary Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center mb-4">
                <h5 class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px;">Faculty Members Summary</h5>
            </div>
            <div class="col-md-3 mb-3">
                <a href="Faculty/index.php" class="text-decoration-none">
                    <div class="card faculty-summary-card text-center py-4 shadow-sm">
                        <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
                        <h2 class="fw-bold mb-0 text-dark"><?= $facultyStats['total'] ?></h2>
                        <span class="text-muted fw-bold">Total Staff</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="Faculty/index.php?gender=Male" class="text-decoration-none">
                    <div class="card faculty-summary-card text-center py-4 shadow-sm">
                        <i class="bi bi-gender-male fs-1 text-info mb-2"></i>
                        <h2 class="fw-bold mb-0 text-dark"><?= $facultyStats['male'] ?></h2>
                        <span class="text-muted fw-bold">Male</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="Faculty/index.php?gender=Female" class="text-decoration-none">
                    <div class="card faculty-summary-card text-center py-4 shadow-sm">
                        <i class="bi bi-gender-female fs-1 text-danger mb-2"></i>
                        <h2 class="fw-bold mb-0 text-dark"><?= $facultyStats['female'] ?></h2>
                        <span class="text-muted fw-bold">Female</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

</html>