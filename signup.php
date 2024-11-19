<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $role = $_POST['role'] ?? 'user'; // Default role is 'user'

    // Cek apakah username atau email sudah ada
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    if ($stmt->fetchColumn() > 0) {
        die('Username or Email already exists!');
    }

    // Simpan data pengguna
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
    if ($stmt->execute([$username, $email, $password, $role])) {
        // Jika berhasil, arahkan ke login.html
        header('Location: index.html');
        exit; // Hentikan eksekusi setelah redirect
    } else {
        echo 'Signup failed!';
    }
}
?>
