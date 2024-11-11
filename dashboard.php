<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] == 'admin') {
    // Show admin dashboard
    include 'manage_rentals.php';  // Admin can manage rentals
} else {
    // Show user dashboard
    include 'rent_vehicle.php';    // User can rent a vehicle
}
?>
