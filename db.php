<?php
// db.php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$serverName = $_ENV['DB_SERVER']; 
$connectionInfo = array(
    "Database" => $_ENV['DB_DATABASE'],
    "Uid"      => $_ENV['DB_USERNAME'],
    "PWD"      => $_ENV['DB_PASSWORD'],
    "TrustServerCertificate" => true
);

$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

