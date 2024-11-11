<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.html');
    exit();
}

// Menambah kendaraan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $car_name = $_POST['car_name'];
    $type_car = $_POST['type_car'];
    $query = $conn->prepare("INSERT INTO rentals (car_name, type_car) VALUES (?, ?)");
    $query->bind_param("ss", $car_name, $type_car);
    $query->execute();
}

// Menghapus kendaraan
if (isset($_GET['delete'])) {
    $rental_id = $_GET['delete'];
    $conn->query("DELETE FROM rentals WHERE rental_id = $rental_id");
}

$rentals = $conn->query("SELECT * FROM rentals");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Kendaraan</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <h1>Kelola Kendaraan</h1>
    <form method="post">
        <input type="text" name="car_name" placeholder="Nama Kendaraan" required>
        <select name="type_car" required>
            <option value="lgcc">LGCC</option>
            <option value="suv">SUV</option>
            <option value="sedan">Sedan</option>
        </select>
        <button type="submit" name="add">Tambah Kendaraan</button>
    </form>

    <table>
        <tr>
            <th>Nama Kendaraan</th>
            <th>Tipe</th>
            <th>Aksi</th>
        </tr>
        <?php while ($rental = $rentals->fetch_assoc()) { ?>
        <tr>
            <td><?= $rental['car_name'] ?></td>
            <td><?= $rental['type_car'] ?></td>
            <td><a href="?delete=<?= $rental['rental_id'] ?>">Hapus</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
