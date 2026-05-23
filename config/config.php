<?php
$env_file = __DIR__ . '/../.env';

if (file_exists($env_file)) {
    $lines = file($env_file);
    foreach ($lines as $line) {
        if (trim($line) !== '' && $line[0] !== '#') {
            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);

            $value = trim($value, "'\"");
            putenv("$key=$value");
        }
    }
}
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db_name = getenv('DB_NAME');

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Error 500");
}
