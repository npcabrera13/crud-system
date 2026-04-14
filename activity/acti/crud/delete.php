<?php
require_once '../config/Project.php';

if (isset($_POST['delete'])) {
    $id = (int) $_POST['delete'];
    $project->delete($id);
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $project->delete($id);
}

header('Location: ../index.php');
exit;