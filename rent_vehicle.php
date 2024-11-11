<?php
include 'koneksi.php';

$stmt = $pdo->query("SELECT * FROM rentals");
$rentals = $stmt->fetchAll();

echo "<form method='POST' action='reserve.php'>";
echo "<select name='rental_id'>";
foreach ($rentals as $rental) {
    echo "<option value='{$rental['rental_id']}'>{$rental['car_name']} ({$rental['type_car']})</option>";
}
echo "</select>";
echo "<input type='date' name='reservation_date' required />";
echo "<input type='time' name='start_time' required />";
echo "<input type='time' name='end_time' required />";
echo "<textarea name='booking_notes' placeholder='Additional Notes'></textarea>";
echo "<button type='submit' name='reserve'>Reserve</button>";
echo "</form>";
?>
