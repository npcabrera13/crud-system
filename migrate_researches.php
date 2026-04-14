<?php
$host = '127.0.0.1';
$db   = 'biodata';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     
     $sql = "CREATE TABLE IF NOT EXISTS researches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        research_date DATE,
        research_title VARCHAR(255),
        co_authors TEXT,
        email_address VARCHAR(255),
        campus VARCHAR(100),
        college VARCHAR(100),
        date_started DATE,
        target_completion_date DATE,
        research_status VARCHAR(50),
        description_abstract TEXT,
        research_agenda VARCHAR(255),
        sdg_goals TEXT,
        publication_status VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
     
     $pdo->exec($sql);
     echo "Table 'researches' created successfully.";
} catch (\PDOException $e) {
     echo "Connection failed: " . $e->getMessage();
}
?>


