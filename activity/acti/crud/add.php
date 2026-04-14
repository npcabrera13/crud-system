<?php
require_once '../config/Project.php';

$project->Add();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Record</title>
    <?php include '../config/libraries.php'; ?>
</head>
<body>
    <h3>Add New Record</h3>
    <form action="" method="POST">
        <div>
            <label for="firstname">Firstname</label>
            <input type="text" name="firstname" id="firstname" placeholder="ex. Juan">
            
            <label for="middlename">Middlename</label>
            <input type="text" name="middlename" id="middlename" placeholder="ex. Rizal">
            
            <label for="lastname">Lastname</label>
            <input type="text" name="lastname" id="lastname" placeholder="ex. Dela Cruz">
            
            <label for="suffix">Suffix</label>
            <input type="text" name="suffix" id="suffix" placeholder="ex. Jr.">
        </div>
        <div style="margin-top: 10px;">
            <button type="submit" name="Add">Submit</button>
            <a href="../index.php">Cancel</a>
        </div>
    </form>
</body>
</html>