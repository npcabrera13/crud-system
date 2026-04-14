<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=biodata', 'root', '');
$stmt = $pdo->query('SELECT id, employee_no, image FROM faculties ORDER BY id DESC LIMIT 5');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    print_r($row);
}
?>
