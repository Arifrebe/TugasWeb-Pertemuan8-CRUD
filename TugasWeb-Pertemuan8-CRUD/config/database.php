<?php
// Konfigurasi koneksi database menggunakan PDO

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host    = 'localhost';
$dbname  = 'inventaris_db';
$dbuser  = 'root';
$dbpass  = '';
$charset = 'utf8mb4';

// Sesuaikan BASE_URL jika nama folder project Anda berbeda
// Asumsi: folder project diletakkan langsung di dalam htdocs
define('BASE_URL', '/TugasWeb-Pertemuan8-CRUD/public/');

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass, $options);
} catch (PDOException $e) {
    die('Koneksi database gagal. Silakan periksa konfigurasi database Anda.');
}
