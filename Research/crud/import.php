<?php
require_once '../config/Research.php';

if (isset($_POST['import'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $target = $_POST['target_table'] ?? 'pending';
        $result = $research->importFromCSV($_FILES['csv_file']['tmp_name'], $target);
        
        if (is_array($result)) {
            $qs = "import_success=" . $result['inserted'] . "&import_skipped=" . $result['skipped'] . "&target=" . $result['target'];
            header("Location: ../index.php?" . $qs);
        } else {
            header("Location: ../index.php?import_error=" . urlencode($result));
        }
        exit;
    }
}
header("Location: ../index.php");
exit;
