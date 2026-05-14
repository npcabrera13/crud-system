<?php
require_once '../config/Faculty.php';

if (isset($_POST['import'])) {
    // Handle CSV Import
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $result = $faculty->importFromCSV($_FILES['csv_file']['tmp_name']);
        
        if (is_array($result)) {
            $qs = "import_success=" . $result['inserted'] . "&import_skipped=" . $result['skipped'];
            header("Location: ../index.php?" . $qs);
        } else {
            header("Location: ../index.php?import_error=" . urlencode($result));
        }
        exit;
    }
}
header("Location: ../index.php");
exit;
