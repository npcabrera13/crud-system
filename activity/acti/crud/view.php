<?php
include "../config/Project.php";
$project->Add();

if (isset($_GET['id'])) {
    $row = $project->view($_GET['id']);
} else {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <?php include "../config/libraries.php"; ?>
</head>
<body class="modal-body text-center">
    <h1 class="text-center">Add New Record</h1>
    <form>
        <input class="form-control form-control-lg" type="text" value="<?= strtoupper($row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . ' ' . ($row['suffix'] )) ?>" readonly>
        
        <div class="row container-fluid">
            <div class="card-body">
                <div class="row justify-content-center">
                    <img src="../assets/img/view.png" alt="view" class="img-fluid mb-4" style="width: 200px;">
                    <div class="mt-3">
                        <a href="../index.php" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>