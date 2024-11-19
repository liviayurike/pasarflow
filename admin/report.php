<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Zona Berhenti</title>
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
            margin-top: 8px;
            border-radius: 2px;
        }


        /* Responsif untuk tampilan kecil */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content {
                margin-left: 0; /* Menyesuaikan dengan sidebar yang menyesuaikan ukuran layar */
                padding: 20px;
                flex: 1;
            }
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
        <!-- <a href="booking.php"><i class="fas fa-calendar-alt"></i> Booking Slot</a> -->
        <a href="notifikasi.php"><i class="fas fa-bell"></i> Notifikasi </a>
        <a href="report.php" class="active"><i class="fas fa-chart-line"></i> Laporan</a>
    </div>

    <div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.html">Pasar - Flow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    
    <!-- Main Content -->
    <!-- Halaman Laporan Penggunaan Zona Berhenti -->
<div class="container mt-4">
    <h2 class="text-center">Laporan Penggunaan Zona Berhenti</h2>
    <div id="laporan-zona">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Zona Parkir</th>
                    <th>Waktu Puncak</th>
                    <th>Durasi Rata-rata Berhenti</th>
                    <th>Pengguna Terbanyak</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Zona A</td>
                    <td>09:00</td>
                    <td>15 Menit</td>
                    <td>ABC1234</td>
                </tr>
                <tr>
                    <td>Zona B</td>
                    <td>10:00</td>
                    <td>20 Menit</td>
                    <td>XYZ5678</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    <!-- Footer -->
    <!-- <footer>
        <p>&copy; 2024 Pasar - Flow | Semua Hak Dilindungi</p>
    </footer> -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script>
        // AJAX untuk mengambil data dari report.php
        document.getElementById('generateReport').addEventListener('click', function () {
            $.ajax({
                url: 'php/report.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    const tableBody = document.querySelector('#reportTable tbody');
                    tableBody.innerHTML = ''; // Kosongkan tabel sebelumnya

                    if (data.length > 0) {
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${row.zone}</td>
                                <td>${row.time_slot}</td>
                                <td>${row.jumlah_kendaraan}</td>
                            `;
                            tableBody.appendChild(tr);
                        });
                    } else {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data tersedia.</td>
                            </tr>
                        `;
                    }
                },
                error: function () {
                    alert('Gagal mengambil data laporan. Silakan coba lagi.');
                }
            });
        });
    </script>
</body>
</html>
