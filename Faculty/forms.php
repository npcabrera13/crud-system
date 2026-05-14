<?php
include "config/Faculty.php";
$data = $faculty->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Downloadable Forms - ROMIS</title>
    <?php include "config/libraries.php"; ?>
    <!-- Add DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.css">
</head>
<body class="bg-light">
    <!-- Global Nav -->
    <div class="card text-center mb-4 border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs px-3">
          <li class="nav-item">
            <a class="nav-link text-primary" href="../dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="../analytics.php">Analytics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="index.php">Faculty Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="../Research/index.php">Research Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="#">Downloadable Forms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="../process_flow.php">Process Flow</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container-fluid px-4">
        <h2 class="mb-4 text-secondary">Downloadable Faculty Forms & Reports</h2>
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="exportTable" class="table table-striped table-bordered w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>Employee No</th>
                                <th>Full Name</th>
                                <th>Academic Rank</th>
                                <th>Discipline</th>
                                <th>Campus</th>
                                <th>College</th>
                                <th>Gender</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['employee_no']) ?></td>
                                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                                <td><?= htmlspecialchars($row['academic_rank']) ?></td>
                                <td><?= htmlspecialchars($row['discipline']) ?></td>
                                <td><?= htmlspecialchars($row['campus']) ?></td>
                                <td><?= htmlspecialchars($row['college']) ?></td>
                                <td><?= htmlspecialchars($row['gender']) ?></td>
                                <td><?= htmlspecialchars($row['contact_number']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#exportTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', className: 'btn btn-secondary btn-sm' },
                    { extend: 'csv', className: 'btn btn-secondary btn-sm' },
                    { extend: 'excel', className: 'btn btn-success btn-sm' },
                    { extend: 'pdf', className: 'btn btn-danger btn-sm' },
                    { extend: 'print', className: 'btn btn-info btn-sm' }
                ],
                pageLength: 10
            });
        });
    </script>
</body>
</html>
