<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    // Debugging: cek apakah koneksi berhasil
    if (!$pdo) {
        die("Database connection failed!");
    }

    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = $_POST['address'];
    $role = 'user';

    try {
        // Cek apakah email sudah terdaftar
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            echo "<p>Email sudah terdaftar!</p>";
        } else {
            // Insert data ke database
            $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, no_hp, email, PASSWORD, address, role)
                                   VALUES (:nama_lengkap, :no_hp, :email, :password, :address, :role)");
            $stmt->execute([
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'email' => $email,
                'password' => $password,
                'address' => $address,
                'role' => $role
            ]);
            echo "<p>Registrasi berhasil! <a href='login.php'>Login di sini</a></p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form method="POST" action="signup.php">
    <input type="text" name="nama_lengkap" placeholder="Full Name" required><br>
    <input type="text" name="no_hp" placeholder="Phone Number" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <button type="submit" name="signup">Sign Up</button>
</form>
