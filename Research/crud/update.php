<?php
require_once '../config/Research.php';

if (isset($_GET['id'])) {
    $row = $research->view($_GET['id']);
} else {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['Update'])) {
    $research->update($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Research</title>
    <?php include '../config/libraries.php'; ?>
</head>
<body class="p-4">
    <a href="../index.php">Back to List</a>
    <hr>
    <h3>Update Research Form</h3>
    
    <form method="POST">
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="research_date" class="form-control" value="<?= $row['research_date'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Research Title</label>
            <input type="text" name="research_title" class="form-control" value="<?= htmlspecialchars($row['research_title']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Co-Author/s</label>
            <textarea name="co_authors" class="form-control" rows="2"><?= htmlspecialchars($row['co_authors']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email_address" class="form-control" value="<?= htmlspecialchars($row['email_address']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Campus</label>
            <input type="text" name="campus" class="form-control" value="<?= htmlspecialchars($row['campus']) ?>" required>
        </div>

        <div class="mb-3">
            <label>College/s</label>
            <input type="text" name="college" class="form-control" value="<?= htmlspecialchars($row['college']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Data Started</label>
            <input type="date" name="date_started" class="form-control" value="<?= $row['date_started'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Target Date of Completion</label>
            <input type="date" name="target_completion_date" class="form-control" value="<?= $row['target_completion_date'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Description/Abstract</label>
            <textarea name="description_abstract" class="form-control" rows="5"><?= htmlspecialchars($row['description_abstract']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>NEUST Research Agenda</label>
            <select name="research_agenda" class="form-select">
                <option value="Governance and Policy" <?= $row['research_agenda'] == 'Governance and Policy' ? 'selected' : '' ?>>Governance and Policy</option>
                <option value="Technology and Innovation" <?= $row['research_agenda'] == 'Technology and Innovation' ? 'selected' : '' ?>>Technology and Innovation</option>
                <option value="Environment and Sustainability" <?= $row['research_agenda'] == 'Environment and Sustainability' ? 'selected' : '' ?>>Environment and Sustainability</option>
            </select>
        </div>

        <div class="mb-3">
            <label>SDGs (Check all that apply)</label>
            <?php $current_sdgs = explode(", ", $row['sdg_goals']); ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sdg_goals[]" value="SDG 1" id="sdg1" <?= in_array("SDG 1", $current_sdgs) ? 'checked' : '' ?>>
                <label class="form-check-label" for="sdg1">SDG 1: No Poverty</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sdg_goals[]" value="SDG 2" id="sdg2" <?= in_array("SDG 2", $current_sdgs) ? 'checked' : '' ?>>
                <label class="form-check-label" for="sdg2">SDG 2: Zero Hunger</label>
            </div>
        </div>

        <div class="mb-3">
            <label>Research Status</label>
            <select name="research_status" class="form-select">
                <option value="Proposal" <?= $row['research_status'] == 'Proposal' ? 'selected' : '' ?>>Proposal</option>
                <option value="Ongoing" <?= $row['research_status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                <option value="Completed" <?= $row['research_status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Publication Status</label>
            <select name="publication_status" class="form-select">
                <option value="Pending" <?= $row['publication_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Published" <?= $row['publication_status'] == 'Published' ? 'selected' : '' ?>>Published</option>
                <option value="Unpublished" <?= $row['publication_status'] == 'Unpublished' ? 'selected' : '' ?>>Unpublished</option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" name="Update" class="btn btn-warning">Save Changes</button>
            <a href="../index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</body>
</html>


 