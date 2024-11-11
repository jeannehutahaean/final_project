<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.html');
    exit();
}

// Mendapatkan jumlah penyewa
$queryRenters = $conn->query("SELECT COUNT(*) as total_renters FROM users WHERE role = 'user'");
$totalRenters = $queryRenters->fetch_assoc()['total_renters'];

// Mendapatkan total penyewaan
$queryRentals = $conn->query("SELECT COUNT(*) as total_rentals FROM reservations");
$totalRentals = $queryRentals->fetch_assoc()['total_rentals'];

// Mendapatkan total pendapatan
$queryRevenue = $conn->query("SELECT SUM(total_price) as revenue FROM reservations WHERE status = 'completed'");
$totalRevenue = $queryRevenue->fetch_assoc()['revenue'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <div class="stats">
        <div>Total Penyewa: <?= $totalRenters ?></div>
        <div>Total Penyewaan: <?= $totalRentals ?></div>
        <div>Total Pendapatan: Rp <?= number_format($totalRevenue, 2) ?></div>
    </div>
    <a href="manage_rentals.php">Kelola Kendaraan</a>
    <a href="export_data.php">Ekspor Data ke Excel</a>
</body>
</html>
