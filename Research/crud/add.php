<?php
require_once '../config/Research.php';
$research->Add();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Research</title>
    <?php include '../config/libraries.php'; ?>
</head>
<body class="p-4">
    <a href="../index.php">Back to List</a>
    <hr>
    <h3>Research Form</h3>
    
    <form method="POST">
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="research_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label>Research Title</label>
            <input type="text" name="research_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Co-Author/s</label>
            <textarea name="co_authors" class="form-control" rows="2" placeholder="List co-authors here..."></textarea>
        </div>

        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email_address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Campus</label>
            <input type="text" name="campus" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>College/s</label>
            <input type="text" name="college" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Data Started</label>
            <input type="date" name="date_started" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Target Date of Completion</label>
            <input type="date" name="target_completion_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description/Abstract</label>
            <textarea name="description_abstract" class="form-control" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label>NEUST Research Agenda</label>
            <select name="research_agenda" class="form-select">
                <option value="">Select Agenda</option>
                <option value="Governance and Policy">Governance and Policy</option>
                <option value="Technology and Innovation">Technology and Innovation</option>
                <option value="Environment and Sustainability">Environment and Sustainability</option>
            </select>
        </div>

        <div class="mb-3">
            <label>SDGs (Check all that apply)</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sdg_goals[]" value="SDG 1" id="sdg1">
                <label class="form-check-label" for="sdg1">SDG 1: No Poverty</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sdg_goals[]" value="SDG 2" id="sdg2">
                <label class="form-check-label" for="sdg2">SDG 2: Zero Hunger</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sdg_goals[]" value="SDG 3" id="sdg3">
                <label class="form-check-label" for="sdg3">SDG 3: Good Health</label>
            </div>
        </div>

        <!-- Hidden fields for new submissions -->
        <input type="hidden" name="research_status" value="Proposal">
        <input type="hidden" name="publication_status" value="N/A">

        <div class="mt-4">
            <button type="submit" name="Add" class="btn btn-primary">Submit</button>
            <a href="../index.php" class="btn btn-secondary">Cancel</a>
        </div>
        
    </form>
</body>
</html>
