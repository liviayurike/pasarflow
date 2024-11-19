<?php
session_start();
include '../database.php'; // Connect to the database using PDO

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Redirect to login if not logged in
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get the form data
$username = $_POST['username'];
$plat_no = $_POST['plat_no'];
$store_name = $_POST['store_name'];
$tanggal = $_POST['tanggal'];
$delivery_time = $_POST['delivery_time'];

if (!isset($_POST['delivery_time']) || empty($_POST['delivery_time'])) {
    echo "Please select a valid delivery time.";
    exit;
}

// Check if the slot is already booked
$query = "SELECT * FROM booking_slots WHERE tanggal = ? AND delivery_time = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal, $delivery_time]);

if ($stmt->rowCount() > 0) {
    echo "Slot already booked. Please choose another time.";
    exit;
}

// Insert the booking into the database
$query = "INSERT INTO booking_slots (user_id, plat_no, store_name, tanggal, delivery_time) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id, $plat_no, $store_name, $tanggal, $delivery_time]);

// Set a success message in session
$_SESSION['booking_success'] = "Booking successful!";

// Redirect to the slot_booking.php page
header('Location: slot_booking.php');
exit;
