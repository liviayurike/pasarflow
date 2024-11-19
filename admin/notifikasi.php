<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Kembalikan ke login jika tidak memiliki akses
    exit;
}

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pasarflow"; // Ganti dengan nama database kamu

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data booking dengan melakukan JOIN ke tabel users untuk mendapatkan username
$sql = "SELECT b.id, u.username, b.plat_no, b.store_name, b.tanggal, b.delivery_time, b.status
        FROM booking_slots b
        LEFT JOIN users u ON b.user_id = u.id"; // Melakukan JOIN ke tabel users untuk mendapatkan username
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasar - Flow</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
        <a href="dashboard_admin.php"><i class="fas fa-home"></i> Beranda</a>
        <!-- <a href="booking.php" class="active"><i class="fas fa-chart-line"></i> Data Booking</a> -->
        <a href="notifikasi.php"><i class="fas fa-bell"></i> Notifikasi </a>
        <!-- <a href="report.php"><i class="fas fa-chart-line"></i> Laporan</a> -->
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="home.php">Pasar - Flow</a>
            <span id="currentUser" class="ms-auto text-muted">Hi, <?php echo $_SESSION['username']; ?></span>
            <button class="btn btn-danger ms-3" id="logoutButton">Logout</button>
        </nav>

        <!-- Tabel Data Booking Slots -->
        <main class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Daftar Booking Slots</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Booking</th>
                                <th>Plat Kendaraan</th>
                                <th>Nama Toko</th>
                                <th>Tanggal Booking</th>
                                <th>Waktu Pengiriman</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <br>
                        <tbody>
                            <?php
                            $no = 1; // Inisialisasi variabel untuk nomor urut
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Ambil waktu sekarang
                                    $currentTime = new DateTime();
                                    
                                    // Gabungkan tanggal dan waktu delivery_time untuk mendapatkan waktu lengkap
                                    $deliveryTime = new DateTime($row['tanggal'] . ' ' . $row['delivery_time']);
                                    
                                    // Tentukan status berdasarkan perbandingan waktu
                                    if ($currentTime > $deliveryTime) {
                                        $status = "Selesai"; // Jika waktu sekarang lebih besar dari waktu pengiriman
                                    } else {
                                        $status = "Sedang Berjalan"; // Jika waktu sekarang lebih kecil dari waktu pengiriman
                                    }

                                    echo "<tr>";
                                    // Menampilkan nomor urut
                                    echo "<td>" . $no++ . "</td>";  // Increment nomor urut setelah ditampilkan
                                    echo "<td>" . $row['username'] . "</td>"; 
                                    echo "<td>" . $row['plat_no'] . "</td>";
                                    echo "<td>" . $row['store_name'] . "</td>";
                                    echo "<td>" . $row['tanggal'] . "</td>";
                                    echo "<td>" . $row['delivery_time'] . "</td>";
                                    echo "<td>" . $status . "</td>"; // Tampilkan status yang telah ditentukan
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Tidak ada data booking slots</td></tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById("logoutButton").addEventListener("click", function () {
            window.location.href = "../logout.php";
        });
    </script>
</body>
</html>

<?php
$conn->close(); // Tutup koneksi database
?>
