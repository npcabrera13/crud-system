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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

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
                    <a class="nav-link active fw-bold" href="#">Home</a>
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
        <div class="row mb-4">
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
                        <div class="card shadow-sm border-0 <?= $colors[$label] ?? 'bg-secondary text-white' ?> text-center py-4 rounded-3"
                            style="transition: transform 0.2s; cursor: pointer;"
                            onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <h2 class="fw-bold mb-0"><?= $count ?></h2>
                            <span class="text-uppercase fw-semibold"
                                style="letter-spacing: 1px; font-size: 0.85rem;"><?= $label ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Centered Faculty Summary Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center mb-3">
                <h6 class="text-uppercase fw-bold text-muted" style="letter-spacing: 2px;">Faculty Members Summary</h6>
            </div>
            <div class="col-md-2 mb-2">
                <a href="Faculty/index.php" class="text-decoration-none">
                    <div class="card faculty-summary-card text-center py-3 shadow-sm">
                        <i class="bi bi-people-fill fs-3 text-primary mb-1"></i>
                        <h4 class="fw-bold mb-0 text-dark"><?= $facultyStats['total'] ?></h4>
                        <span class="text-muted small fw-semibold">Total Staff</span>
                    </div>
                </a>
            </div>
            <div class="col-md-2 mb-2">
                <a href="Faculty/index.php?gender=Male" class="text-decoration-none">
                    <div class="card faculty-summary-card text-center py-3 shadow-sm">
                        <i class="bi bi-gender-male fs-3 text-info mb-1"></i>
                        <h4 class="fw-bold mb-0 text-dark"><?= $facultyStats['male'] ?></h4>
                        <span class="text-muted small fw-semibold">Male</span>
                    </div>
                </a>
            </div>
            <div class="col-md-2 mb-2">
                <a href="Faculty/index.php?gender=Female" class="text-decoration-none">
                    <div class="card faculty-summary-card text-center py-3 shadow-sm">
                        <i class="bi bi-gender-female fs-3 text-danger mb-1"></i>
                        <h4 class="fw-bold mb-0 text-dark"><?= $facultyStats['female'] ?></h4>
                        <span class="text-muted small fw-semibold">Female</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <!-- 1. Research Status Distribution -->
            <div class="col-md-6">
                <div class="card chart-card p-3">
                    <h6 class="fw-bold mb-3">Research Status Distribution</h6>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- 2. Publication Status Distribution -->
            <div class="col-md-6">
                <div class="card chart-card p-3">
                    <h6 class="fw-bold mb-3">Publication Status Distribution</h6>
                    <div class="chart-container">
                        <canvas id="pubChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- 3. Research by Campus -->
            <div class="col-md-6">
                <div class="card chart-card p-3">
                    <h6 class="fw-bold mb-3">Research by Campus</h6>
                    <div class="chart-container">
                        <canvas id="campusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- 4. list of Colleges -->
            <div class="col-md-6">
                <div class="card chart-card p-3">
                    <h6 class="fw-bold mb-3">list of Colleges</h6>
                    <div class="chart-container">
                        <canvas id="collegeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data from PHP
        const statusRaw = <?= json_encode($statusData) ?>;
        const pubRaw = <?= json_encode($pubData) ?>;
        const campusRaw = <?= json_encode($campusData) ?>;
        const collegeRaw = <?= json_encode($collegeData) ?>;

        // Colors
        const chartColors = {
            purple: '#9C27B0', // Added for Proposal
            blue: '#2196F3',
            pink: '#FF4081',
            yellow: '#FFC107',
            teal: '#00BCD4'
        };

        // 1. Vertical Bar Chart (Status)
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: statusRaw.map(d => d.label),
                datasets: [{
                    label: '# of Research',
                    data: statusRaw.map(d => d.total),
                    backgroundColor: [
                        chartColors.purple,
                        chartColors.blue,
                        chartColors.pink,
                        chartColors.yellow,
                        chartColors.teal
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } },
                onClick: (e, activeEls) => {
                    if (activeEls.length > 0) {
                        const index = activeEls[0].index;
                        const label = statusRaw[index].label.toUpperCase();
                        window.location.href = 'Research/index.php?status=' + label;
                    }
                }
            }
        });

        // 2. Vertical Bar Chart (Publication)
        new Chart(document.getElementById('pubChart'), {
            type: 'bar',
            data: {
                labels: pubRaw.map(d => d.label || 'Not Submitted'),
                datasets: [{
                    label: '# of Publications',
                    data: pubRaw.map(d => d.total),
                    backgroundColor: chartColors.pink
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        // 3. Horizontal Bar Chart (Campus)
        new Chart(document.getElementById('campusChart'), {
            type: 'bar',
            data: {
                labels: campusRaw.map(d => d.label),
                datasets: [{
                    label: '# of Research',
                    data: campusRaw.map(d => d.total),
                    backgroundColor: chartColors.yellow
                }]
            },
            options: {
                indexAxis: 'y', // Official Chart.js Horizontal Bar Config
                responsive: true,
                maintainAspectRatio: false,
                scales: { x: { beginAtZero: true } }
            }
        });

        // 4. Vertical Bar Chart (Colleges)
        new Chart(document.getElementById('collegeChart'), {
            type: 'bar',
            data: {
                labels: collegeRaw.map(d => d.label),
                datasets: [{
                    label: '# of Research',
                    data: collegeRaw.map(d => d.total),
                    backgroundColor: chartColors.teal
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true },
                    x: { ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 } }
                }
            }
        });
    </script>
</body>

</html>