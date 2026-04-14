<?php
include "config/Project.php";
$data = $project->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Testing Index</title>
    <?php include "config/libraries.php"; ?>
</head>
<body>
    <h1>Welcome to the Testing Index Page</h1>
    <a href="./crud/add.php" title="Add New Record" class="btn btn-primary mb-2">Add</a>
    <section class="m-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Middle Name</th>
                    <th>Lastname</th>
                    <th>Suffix</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= strtoupper($row['id']) ?></td>
                    <td><?= strtoupper($row['firstname']) ?></td>
                    <td><?= strtoupper($row['middlename']) ?></td>
                    <td><?= strtoupper($row['lastname']) ?></td>
                    <td><?= strtoupper($row['suffix']) ?></td>
                    <td>
                        <a href="crud/view.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">View</a>
                        <a href="crud/update.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <form method="POST" action="crud/delete.php" style="display:inline-block;">
                            <button type="submit" name="delete" value="<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </section>
</body>
</html>