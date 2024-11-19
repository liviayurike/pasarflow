<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Kembalikan ke login jika tidak memiliki akses
    exit;
}
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
        <a href="home.php" class="active"><i class="fas fa-home"></i> Beranda</a>
        <a href="slot_booking.php"><i class="fas fa-calendar-alt"></i> Booking Slot</a>
        <!-- <a href="notifikasi.php"><i class="fas fa-bell"></i> Notifikasi </a> -->
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
                    <h2>Selamat Datang di Aplikasi Penjadwalan</h2>
                    <p>Atur waktu pengiriman barang dan pantau zona berhenti dengan mudah.</p>
                </div>
            </div>

            <!-- Fitur Penjadwalan Pengiriman Barang -->
            <div class="row card-container">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 card-custom">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calendar-check"></i> Pesan Slot Waktu</h5>
                            <p class="card-text">Pemasok dan toko dapat memesan slot waktu untuk menurunkan barang, mengurangi penumpukan kendaraan pada jam sibuk.</p>
                            <a href="slot_booking.php" class="btn btn-custom">Pesan Sekarang</a>
                        </div>
                    </div>
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
