<?php
include "../config/Research.php";

if (isset($_GET['id'])) {
    $row = $research->view($_GET['id']);
} else {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Research</title>
    <?php include '../config/libraries.php'; ?>
</head>
<body class="p-4">
    <a href="../index.php">Back to List</a>
    <hr>
    <h3>Research Details</h3>
    
    <div class="mb-3">
        <label class="fw-bold">Date:</label>
        <p><?= htmlspecialchars($row['research_date']) ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Research Title:</label>
        <p><?= htmlspecialchars($row['research_title']) ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Co-Author/s:</label>
        <p><?= htmlspecialchars($row['co_authors'] ?: 'None') ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Email Address:</label>
        <p><?= htmlspecialchars($row['email_address']) ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Campus:</label>
        <p><?= htmlspecialchars($row['campus']) ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">College/s:</label>
        <p><?= htmlspecialchars($row['college']) ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Research Status:</label>
        <p><?= htmlspecialchars($row['research_status']) ?></p>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Abstract:</label>
        <p><?= nl2br(htmlspecialchars($row['description_abstract'])) ?></p>
    </div>

    <div class="mt-4">
        <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit This Record</a>
        <a href="../index.php" class="btn btn-secondary">Back to List</a>
    </div>
</body>
</html>
