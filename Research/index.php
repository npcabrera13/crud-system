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
            <a class="nav-link text-primary" href="/crud/dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/analytics.php">Analytics</a>
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
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/process_flow.php">Process Flow</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="text-secondary">Research Directory</h2>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel"></i> Import Excel
                </button>
                <a href="crud/add.php" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Add New Research
                </a>
            </div>
        </div>

        <?php if(isset($_GET['import_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <strong>Success!</strong> Successfully imported <?= htmlspecialchars($_GET['import_success']) ?> records to 
                <?= ($_GET['target'] ?? 'pending') === 'main' ? 'the Main Directory' : 'Pending Research' ?>.
                <?php if(isset($_GET['import_skipped']) && $_GET['import_skipped'] > 0): ?>
                    <span class="ms-2 badge bg-warning text-dark"><?= htmlspecialchars($_GET['import_skipped']) ?> duplicates skipped</span>
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['import_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <strong>Error!</strong> <?= htmlspecialchars($_GET['import_error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
                                    <form method="POST" action="crud/delete.php" style="display:inline-block;" onsubmit="return confirm('Delete this record?');">
                                        <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
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

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="crud/import.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Research from Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Please use our template for the correct format.
                            <br>
                            <a href="crud/template.php" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="bi bi-download"></i> Download Template (.csv)
                            </a>
                        </div>
                        <div class="mb-3">
                            <label for="csv_file" class="form-label fw-bold">Select Excel (CSV) File</label>
                            <input type="file" name="csv_file" class="form-control" id="csv_file" accept=".csv" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Import To:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="target_table" id="targetPending" value="pending" checked>
                                <label class="form-check-label" for="targetPending">
                                    Pending Research (Requires Admin Approval)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="target_table" id="targetMain" value="main">
                                <label class="form-check-label" for="targetMain">
                                    Main Research Directory (Bypass Approval)
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1">* Main directory imports will default to "PROPOSAL" status.</small>
                        </div>
                        <small class="text-muted">Note: Only .csv files are supported.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="import" class="btn btn-success">Upload and Import</button>
                    </div>
                </form>
            </div>
        </div>
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

            // Check for URL Parameter to auto-filter
            const urlParams = new URLSearchParams(window.location.search);
            const statusParam = urlParams.get('status');
            if (statusParam) {
                $(`#statusFilter .nav-link[data-status="${statusParam}"]`).trigger('click');
            }
        });
    </script>
</body>
</html>
