<?php
require_once '../config/Research.php';

if (isset($_POST['delete'])) {
    $research->delete($_POST['delete']);
    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../index.php');
    exit;
}
