<?php

require_once __DIR__ . '/config.php';

try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false, // Consultes parametritzades reals
    ]);
} catch (PDOException $e) {
    die("Error de connexió a la base de dades: $dsn");
    //die("Error de connexió a la base de dades: $dsn" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

