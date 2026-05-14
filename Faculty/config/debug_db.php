<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=biodata', 'root', '');
$stmt = $pdo->query('SELECT COUNT(*) FROM faculties');
echo "TOTAL FACULTIES: " . $stmt->fetchColumn() . "\n";

$stmt = $pdo->query('SELECT employee_no FROM faculties');
echo "EXISTING EMPLOYEE NUMBERS:\n";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "- " . $row['employee_no'] . "\n";
}
?>
