<?php
try {
    $pdo = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=app', 'app', '!ChangeMe!');
    echo "PDO PostgreSQL is working!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
