<?php
session_start();
include "config/Research.php";
$research->handleApprovals();
$data = $research->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Research List - ROMIS</title>
    <!-- Add simple script to show alerts from session -->
    <?php if (isset($_SESSION['email_status'])): ?>
        <script>
            alert("<?php echo $_SESSION['email_status']; ?>");
        </script>
        <?php unset($_SESSION['email_status']); ?>
    <?php endif; ?>
    <?php include "config/libraries.php"; ?>
    <style>
        .status-pill {
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: bold;
        }
        .status-proposal { background: #E1BEE7; color: #9C27B0; }
        .status-ongoing { background: #BBDEFB; color: #1976D2; }
        .status-completed { background: #C8E6C9; color: #388E3C; }
        .status-published { background: #F8BBD0; color: #C2185B; }
        
        .nav-pills .nav-link.active {
            background-color: #3f51b5;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Global Nav -->
    <div class="card text-center mb-4 border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs px-3">
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/Faculty/index.php">Faculty Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="#">Research Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="../Faculty/forms.php">Downloadable Forms</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-secondary">Research Directory</h2>
            <a href="crud/add.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg"></i> Add New Research
            </a>
        </div>

        <!-- Status Filter Tabs -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-2">
                <ul class="nav nav-pills" id="statusFilter">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-status="all">All Research</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-status="PROPOSAL">Proposal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-status="ONGOING">Ongoing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-status="COMPLETED">Completed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-status="PUBLISHED">Published</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Research Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="researchTable" class="table table-hover w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Research Title</th>
                                <th>Campus</th>
                                <th>College</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= date('Y-m-d', strtotime($row['research_date'])) ?></td>
                                <td class="fw-bold"><?= strtoupper($row['research_title']) ?></td>
                                <td><?= $row['campus'] ?></td>
                                <td><?= $row['college'] ?></td>
                                <td>
                                    <?php 
                                        $statusClass = 'status-' . strtolower($row['research_status']);
                                        echo "<span class='status-pill $statusClass'>".strtoupper($row['research_status'])."</span>";
                                    ?>
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="crud/view.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">View</a>
                                    <a href="crud/update.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="crud/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pending Applications Section -->
        <?php include "../tempresearch.php"; ?>
    </div>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            const table = $('#researchTable').DataTable({
                "pageLength": 10,
                "order": [[0, "desc"]],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', className: 'btn btn-success btn-sm', text: 'Excel' },
                    { extend: 'pdf', className: 'btn btn-danger btn-sm', text: 'PDF' }
                ]
            });

            // Custom Filter Logic for Tabs
            $('#statusFilter .nav-link').on('click', function(e) {
                e.preventDefault();
                
                // UI Toggle
                $('#statusFilter .nav-link').removeClass('active');
                $(this).addClass('active');
                
                // Filter Table
                const status = $(this).data('status');
                if (status === 'all') {
                    table.column(4).search('').draw();
                } else {
                    table.column(4).search('^' + status + '$', true, false).draw();
                }
            });
        });
    </script>
</body>
</html>
