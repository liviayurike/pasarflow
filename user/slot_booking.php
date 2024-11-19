<?php
session_start();
include '../database.php'; // Connect to the database using PDO

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Prepare the query to fetch both user booking status and all booked slots for today
$query = "
    SELECT 
        booking_slots.delivery_time, 
        (SELECT COUNT(*) FROM booking_slots WHERE user_id = ? AND tanggal = CURDATE()) AS isBooked 
    FROM booking_slots 
    WHERE tanggal = CURDATE()
";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);

// Get all booked slots for today
$bookedSlots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize array for booked times
$bookedTimes = [];

// Check if the user has booked a slot today
$isBooked = false;

foreach ($bookedSlots as $slot) {
    $bookedTimes[] = $slot['delivery_time']; // Store the booked times for today
    if ($slot['isBooked'] > 0) {
        $isBooked = true; // User has already booked a slot for today
    }
}

// Check if 'store_name' exists in the user data
$store_name = isset($user['store_name']) ? $user['store_name'] : ''; // Empty if not set
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
        <a href="slot_booking.php" class="active"><i class="fas fa-calendar-alt"></i> Booking Slot</a>
        <!-- <a href="notifikasi.php"><i class="fas fa-bell"></i> Notifikasi </a> -->
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Pasar - Flow</a>
                <span id="currentUser" class="ms-auto text-muted">Hi, <?php echo $user['username']; ?></span>
                <button class="btn btn-danger ms-3" id="logoutButton">Logout</button>
            </div>
        </nav>

        <!-- Booking Slot Page -->
        <div class="container mt-4">
            <br>
            <h2 class="text-center">Pesan Slot Waktu Penurunan</h2>
            <br>
            
            <!-- Success Message Alert -->
            <?php if (isset($_SESSION['booking_success'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['booking_success']; ?>
                </div>
                <?php unset($_SESSION['booking_success']); // Clear the message after display ?>
            <?php endif; ?>

            <form action="proses_booking.php" method="POST" <?php echo $isBooked ? 'disabled' : ''; ?>>
                <div class="row">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="plat_no" class="form-label">Nomor Plat Kendaraan</label>
                        <input type="text" class="form-control" id="plat_no" name="plat_no" placeholder="Masukkan PLAT Kendaraan" required>
                    </div>

                    <div class="col-md-6">
                        <br>
                        <label for="store_name" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" id="store_name" name="store_name" value="<?php echo $store_name; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <label for="tanggal" class="form-label">Tanggal Penurunan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required <?php echo $isBooked ? 'disabled' : ''; ?>>
                    </div>
                    <div class="col-md-6">
                    <br>
                    <label for="delivery_time" class="form-label">Waktu Penurunan</label>
                    <select class="form-select" id="delivery_time" name="delivery_time" required <?php echo $isBooked ? 'disabled' : ''; ?>>
                        <?php
                        // Daftar waktu yang tersedia
                        $timeSlots = [
                            "07:00-07:30",
                            "07:30-08:00",
                            "08:00-08:30",
                            "08:30-09:00",
                            "09:00-09:30",
                            "09:30-10:00",
                            "10:00-10:30",
                            "10:30-11:00",
                            "11:00-11:30",
                            "11:30-12:00",
                            "12:00-12:30",
                            "12:30-13:00",
                            "13:00-13:30",
                            "13:30-14:00"
                        ];

                        // Loop untuk membuat opsi waktu
                        foreach ($timeSlots as $slot) {
                            $disabled = in_array($slot, $bookedTimes) ? 'disabled' : '';
                            echo "<option value=\"$slot\" $disabled>$slot</option>";
                        }
                        ?>
                    </select>
                </div>

                </div>

                <!-- Booking Button -->
                <div class="d-grid gap-2">
                    <br>
                    <button type="submit" class="btn-custom" <?php echo $isBooked ? 'disabled' : ''; ?>>Pesan Slot</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            window.location.href = '../logout.php';
        });
    </script>
</body>
</html>
