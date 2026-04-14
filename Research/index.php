<?php
include "config/Research.php";
$research->handleApprovals();
$data = $research->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Research List</title>
    <?php include "config/libraries.php"; ?>
</head>
<body class="bg-light">
    <!-- Global Nav -->
    <div class="card text-center mb-4 border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs px-3">
          <li class="nav-item">
            <a class="nav-link text-primary" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="/crud/Faculty/index.php">Faculty Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="#">Research Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="#">Downloadable Forms</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container-fluid px-4">
        <h1 class="mb-4">Welcome to the Research Index Page</h1>
        <a href="./crud/add.php" title="Add New Research" class="btn btn-primary mb-3">Add</a>
        
        <section class="m-0">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Research Title</th>
                            <th>Campus</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= date('M d, Y', strtotime($row['research_date'])) ?></td>
                            <td><?= strtoupper($row['research_title']) ?></td>
                            <td><?= strtoupper($row['campus']) ?></td>
                            <td><?= strtoupper($row['research_status']) ?></td>
                            <td class="text-end">
                                <a href="crud/view.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">View</a>
                                <a href="crud/update.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form method="POST" action="crud/delete.php" style="display:inline-block;">
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

        <!-- Pending Applications Section -->
        <?php include "../tempresearch.php"; ?>
    </div>

    <!-- Initialization Script -->
    <script src="config/jtable.js"></script>
</body>
</html>
