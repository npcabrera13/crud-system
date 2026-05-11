<?php
require_once "Faculty/config/Analytics.php";
use Classes\Analytics;

$analytics = new Analytics();

// Fetch Real Data
$statusData = $analytics->getResearchStatusDistribution();
$pubData    = $analytics->getPublicationStatusDistribution();
$campusData = $analytics->getResearchByCampus();
$collegeData = $analytics->getResearchByCollege();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - ROMIS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .chart-container {
            position: relative;
            height: 300px;
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
        const pubRaw    = <?= json_encode($pubData) ?>;
        const campusRaw = <?= json_encode($campusData) ?>;
        const collegeRaw = <?= json_encode($collegeData) ?>;

        // Colors
        const chartColors = {
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
                    backgroundColor: chartColors.blue
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
