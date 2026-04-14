<?php
include "../config/Faculty.php";

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $faculty->delete($id);
}

header('Location: ../index.php');
exit;
