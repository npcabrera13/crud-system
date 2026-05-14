<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=biodata', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Disable foreign key checks just in case
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE faculties");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "SUCCESS: Faculty table has been cleared and reset!";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
