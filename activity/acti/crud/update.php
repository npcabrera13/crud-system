<?php
include "../config/Project.php";

if (isset($_GET['id'])) {
    $data = $project->view($_GET['id']);
}

if (isset($_POST['update'])) {
    $project->update($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <?php include "../config/libraries.php"; ?>
</head>
<body class="modal-body">
    <h1 class="text-center">Add New Record</h1>
    <form method="POST">
        <div class="row container-fluid">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="floating-select">Firstname</label>
                            <input type="text" class="form-control" placeholder="ex. Juan" name="firstname" value="<?= htmlspecialchars($data['firstname']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="floating-select">Middlename</label>
                            <input type="text" class="form-control" placeholder="ex. Rizal" name="middlename" value="<?= htmlspecialchars($data['middlename']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="floating-select">Lastname</label>
                            <input type="text" class="form-control" placeholder="ex. Dela Cruz" name="lastname" value="<?= htmlspecialchars($data['lastname']) ?>">
                        </div>
                    </div>
                </div>
                <div class="float-end mt-4">
                    <button type="submit" name="update" class="btn btn-outline-primary btn-sm border-2">Update</button>
                    <a href="../index.php" class="btn btn-outline-danger btn-sm border-2">
                        <i class="fas fa-backspace" style="font-size: 20px;"></i>&nbsp;Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>