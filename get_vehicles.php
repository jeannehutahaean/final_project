<?php
include 'koneksi.php';

$query = "SELECT * FROM vehicles";
$result = $conn->query($query);

$vehicles = [];

while ($row = $result->fetch_assoc()) {
    $vehicles[] = $row;
}

echo json_encode($vehicles);

$conn->close();
?>
