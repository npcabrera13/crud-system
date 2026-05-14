<?php
require_once "Faculty/config/Analytics.php";
use Classes\Analytics;

$analytics = new Analytics();

// Fetch Real Data
$dbStatusData = $analytics->getResearchStatusDistribution();
$pubData    = $analytics->getPublicationStatusDistribution();
$campusData = $analytics->getResearchByCampus();
$collegeData = $analytics->getResearchByCollege();

// Standardize Status Data to always show 4 statuses for the chart
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
    <title>Analytics - ROMIS</title>
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
            height: 350px;
            width: 100%;
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
                    <a class="nav-link text-primary" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold" href="#">Analytics</a>
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

    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h3 class="fw-bold">System Analytics</h3>
                <p class="text-muted">Real-time distribution of research data across all campuses and colleges.</p>
            </div>
            
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
            purple: '#9C27B0',
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
                        chartColors.yellow
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
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
                indexAxis: 'y',
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
