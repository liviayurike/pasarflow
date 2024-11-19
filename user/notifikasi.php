<?php
session_start();
include '../database.php';  // Include the database connection file (using PDO)

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Redirect to login page if user is not logged in
    exit;
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// SQL query to fetch booking notifications for the logged-in user
$sql = "SELECT u.username AS user_name, 
       b.store_name, 
       CONCAT(DATE(b.tanggal), ' ', TIME(b.delivery_time)) AS delivery_datetime, 
       b.delivery_time,
       TIMESTAMPDIFF(SECOND, NOW(), CONCAT(DATE(b.tanggal), ' ', TIME(b.delivery_time))) AS time_remaining
FROM booking_slots b
JOIN users u ON b.user_id = u.id
WHERE b.user_id = :user_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);  // Bind user_id to the prepared statement
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all the results as an associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Slot Waktu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Sidebar Styling */
.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: white;
    padding-top: 20px;
}

.sidebar a {
    color: black;
    padding: 15px 20px;
    text-decoration: none;
    display: block;
    transition: 0.3s;
    font-size: 16px;
}

.sidebar a:hover {
    background-color: #f39c12;
    color: #4a5a6c;
}

.sidebar a.active, .sidebar a.active:hover {
    font-weight: bold;
    background-color: rgba(0, 0, 0, 0.1);
    color: #333;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

/* Main Content */
.content {
    margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
    padding: 20px;
    flex: 1;
}

/* Navbar Styling */
.navbar-brand {
    font-family: 'Poppins', sans-serif;
    font-size: 30px;
    font-weight: 600;
    color: black;
}

.navbar-brand::after {
    content: "";
    display: block;
    width: 60px;
    height: 4px;
    background-color: #f39c12;
    margin-top: 12px;
    border-radius: 2px;
}

/* Footer Styling */
footer {
    background-color: #c9aa77;
    color: white;
    text-align: center;
    padding: 10px 0;
    font-size: 14px;
    width: 100%;
}

/* Responsif untuk tampilan kecil */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .content {
        margin-left: 0; /* Sesuaikan dengan sidebar yang menjadi 100% */
        padding: 20px;
    }
}

/* Center the card */
.card-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.card-custom {
    max-width: 350px;
    margin: 0 auto;
}

.btn-custom {
    background-color: #f39c12;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 10px 20px;
    font-weight: bold;
}

.btn-custom:hover {
    background-color: #e67e22;
}

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-black" style="font-weight: 600;">Dashboard</h3>
        <br>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="slot_booking.php"><i class="fas fa-calendar-alt"></i> Booking Slot</a>
        <a href="notifikasi.php" class="active"><i class="fas fa-bell"></i> Notifikasi </a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <br>
                <br>
                <a class="navbar-brand" href="home.php">Pasar - Flow</a>
                <!-- <span id="currentUser" class="ms-auto text-muted">Hi, <?php echo $_SESSION['username']; ?></span> -->
                <span id="currentUser" class="ms-auto text-muted">Hi, <?php echo $_SESSION['username']; ?></span>
                <button class="btn btn-danger ms-3" id="logoutButton">Logout</button>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h2></h2>
                    <p></p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h3>Notifikasi Booking</h3>
                    <?php if (count($result) > 0): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Toko</th>
                                    <th>Waktu Pengiriman</th>
                                    <th>Sisa Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['store_name']; ?></td>
                                        <td><?php echo date("d-m-Y H:i", strtotime($row['delivery_datetime'])); ?></td>
                                        <td>
                                            <?php 
                                                $remaining_time = $row['time_remaining'];

                                                if ($remaining_time > 0) {
                                                    $days = floor($remaining_time / 86400);
                                                    $hours = floor(($remaining_time % 86400) / 3600);
                                                    $minutes = floor(($remaining_time % 3600) / 60);

                                                    echo $days . " Hari " . $hours . " Jam " . $minutes . " Menit";
                                                } else {
                                                    echo "Waktu Habis";
                                                }
                                            ?>
                                        </td>



                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Anda belum melakukan booking slot waktu.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
   <!-- <footer>
        <p>&copy; 2024 Pasar - Flow | Semua Hak Dilindungi</p>
    </footer> -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById("logoutButton").addEventListener("click", function () {
            window.location.href = "../logout.php";
        });
    </script>
</body>
</html>