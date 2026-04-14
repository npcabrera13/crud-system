<?php
require_once 'Pdo.php';

$stmt = $db-> prepare('SELECT * FROM membership');
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Users List</title>
    <!-- Add Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>   
<body class="p-4">
    <a href="#" class="btn btn-primary mb-3">Add</a>

    <h2>Users List</h2>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
           <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Action</th>
            </tr>  
      </thead>
      <tbody>
        <?php foreach ($data as $row4): ?>
        <tr>
            <td><?= htmlspecialchars($row4['id']) ?> </td>
            <td><?= htmlspecialchars(strtoupper($row4['firstname'])) ?> </td>
            <td><?= htmlspecialchars(strtoupper($row4['middlename'])) ?> </td>
            <td><?= htmlspecialchars(strtoupper($row4['lastname'])) ?> </td>
            <td>
                <a href="#" class="btn btn-sm btn-info">View</a>
                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($data)): ?>
        <tr><td colspan="5" class="text-center">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
</body>
</html>