<?php
include "config/Faculty.php";
$data = $faculty->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty List</title>
    <?php include "config/libraries.php"; ?>
</head>
<body>
    <!-- Global Nav -->
    <div class="card text-center mb-4 border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs px-3">
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="#">Faculty Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/Research/index.php">Research Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="forms.php">Downloadable Forms</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container-fluid px-4">
        <h1 class="mb-4">Welcome to the Faculty Index Page</h1>
        <a href="./crud/add.php" title="Add New Faculty" class="btn btn-primary mb-3">Add</a>
        
        <!-- Gender Filter Tabs -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-2">
                <ul class="nav nav-pills" id="genderFilter">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-gender="all">All Faculty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-gender="Male">Male</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-gender="Female">Female</a>
                    </li>
                </ul>
            </div>
        </div>

        <section class="m-0">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Employee No.</th>
                            <th>Gender</th>
                            <th>Academic Rank</th>
                            <th>Campus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td class="fw-bold"><?= strtoupper($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td><?= strtoupper($row['employee_no']) ?></td>
                            <td><?= strtoupper($row['gender']) ?></td>
                            <td><?= strtoupper($row['academic_rank']) ?></td>
                            <td><?= strtoupper($row['campus']) ?></td>
                            <td>
                                <a href="crud/view.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">View</a>
                                <a href="crud/update.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form method="POST" action="crud/delete.php" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="config/jtable.js"></script>
    <script>
        $(document).ready(function () {
            // DataTables is initialized in jtable.js
            const table = $('#myTable').DataTable();

            // Custom Filter Logic for Tabs
            $('#genderFilter .nav-link').on('click', function(e) {
                e.preventDefault();
                $('#genderFilter .nav-link').removeClass('active');
                $(this).addClass('active');
                
                const gender = $(this).data('gender');
                if (gender === 'all') {
                    table.column(3).search('').draw();
                } else {
                    table.column(3).search('^' + gender + '$', true, false).draw();
                }
            });

            // Check for URL Parameter to auto-filter
            const urlParams = new URLSearchParams(window.location.search);
            const genderParam = urlParams.get('gender');
            if (genderParam) {
                $(`#genderFilter .nav-link[data-gender="${genderParam}"]`).trigger('click');
            }
        });
    </script>
</body>

</html>