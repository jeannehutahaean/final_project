<?php
include 'koneksi.php';

if (isset($_POST['reserve'])) {
    $user_id = $_SESSION['user_id'];
    $rental_id = $_POST['rental_id'];
    $reservation_date = $_POST['reservation_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $duration_time = calculate_duration($start_time, $end_time); // Function to calculate duration
    $booking_notes = $_POST['booking_notes'];

    // Example: calculate total price based on duration and car type
    $stmt = $pdo->prepare("SELECT * FROM rentals WHERE rental_id = :rental_id");
    $stmt->execute(['rental_id' => $rental_id]);
    $rental = $stmt->fetch();
    $price_per_hour = 100; // Set price
    $total_price = $duration_time * $price_per_hour;

    $stmt = $pdo->prepare("INSERT INTO reservations (user_id, rental_id, reservation_date, start_time, end_time, duration_time, booking_notes, total_price, status)
                           VALUES (:user_id, :rental_id, :reservation_date, :start_time, :end_time, :duration_time, :booking_notes, :total_price, 'pending')");
    $stmt->execute([
        'user_id' => $user_id,
        'rental_id' => $rental_id,
        'reservation_date' => $reservation_date,
        'start_time' => $start_time,
        'end_time' => $end_time,
        'duration_time' => $duration_time,
        'booking_notes' => $booking_notes,
        'total_price' => $total_price
    ]);

    echo "Reservation created successfully!";
}
?>

<?php
function calculate_duration($start_time, $end_time) {
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $interval = $start->diff($end);
    return $interval->h; // Return hours as duration
}
?>
