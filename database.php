<?php
$host = 'localhost';
$dbname = 'pasarflow';
$username = 'root'; // atau username MySQL Anda
$password = ''; // password MySQL Anda (kosong jika default)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
