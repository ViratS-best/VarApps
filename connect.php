<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db = $_ENV['DB_NAME'];

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Failed to connect DB: " . $conn->connect_error);
}
?>