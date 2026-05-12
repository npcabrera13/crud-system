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
    <h3>View Research Details</h3>
    
    <form>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" class="form-control" value="<?= $row['research_date'] ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>Research Title</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['research_title']) ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>Co-Author/s</label>
            <textarea class="form-control" rows="2" readonly disabled><?= htmlspecialchars($row['co_authors']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($row['email_address']) ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>Campus</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['campus']) ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>College/s</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['college']) ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>Data Started</label>
            <input type="date" class="form-control" value="<?= $row['date_started'] ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>Target Date of Completion</label>
            <input type="date" class="form-control" value="<?= $row['target_completion_date'] ?>" readonly disabled>
        </div>

        <div class="mb-3">
            <label>Description/Abstract</label>
            <textarea class="form-control" rows="5" readonly disabled><?= htmlspecialchars($row['description_abstract']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>NEUST Research Agenda</label>
            <select class="form-select" disabled>
                <option value="Governance and Policy" <?= $row['research_agenda'] == 'Governance and Policy' ? 'selected' : '' ?>>Governance and Policy</option>
                <option value="Technology and Innovation" <?= $row['research_agenda'] == 'Technology and Innovation' ? 'selected' : '' ?>>Technology and Innovation</option>
                <option value="Environment and Sustainability" <?= $row['research_agenda'] == 'Environment and Sustainability' ? 'selected' : '' ?>>Environment and Sustainability</option>
            </select>
        </div>

        <div class="mb-3">
            <label>SDGs (Check all that apply)</label>
            <?php $current_sdgs = explode(", ", $row['sdg_goals']); ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="sdg1" <?= in_array("SDG 1", $current_sdgs) ? 'checked' : '' ?> disabled>
                <label class="form-check-label" for="sdg1">SDG 1: No Poverty</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="sdg2" <?= in_array("SDG 2", $current_sdgs) ? 'checked' : '' ?> disabled>
                <label class="form-check-label" for="sdg2">SDG 2: Zero Hunger</label>
            </div>
        </div>

        <div class="mb-3">
            <label>Research Status</label>
            <select class="form-select" disabled>
                <option value="Proposal" <?= strtoupper($row['research_status']) == 'PROPOSAL' ? 'selected' : '' ?>>Proposal</option>
                <option value="Ongoing" <?= strtoupper($row['research_status']) == 'ONGOING' ? 'selected' : '' ?>>Ongoing</option>
                <option value="Completed" <?= strtoupper($row['research_status']) == 'COMPLETED' ? 'selected' : '' ?>>Completed</option>
                <option value="Published" <?= strtoupper($row['research_status']) == 'PUBLISHED' ? 'selected' : '' ?>>Published</option>
            </select>
        </div>

        <div class="mt-4">
            <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit This Record</a>
            <a href="../index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </form>
</body>
</html>
