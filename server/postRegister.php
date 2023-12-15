<?php
session_start();

$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect('localhost', 'root', '', 'client_dev');
if (!$conn) {
    $_SESSION["invalid_credentials"] = "Error: " . $conn . '<br/>';
    header('Location: ../views/register.php');
}

// cek email apakah sudah dipakai
$query = "SELECT * FROM users WHERE email='$email' AND enable_status = 1 LIMIT 1";
$check_email = mysqli_query($conn, $query);

if (mysqli_num_rows($check_email) > 0) {
    $_SESSION["invalid_credentials"] = "Email sudah dipakai.";
    header('Location: ../views/register.php');
}

// cek username apakah sudah dipakai
$query = "SELECT * FROM users WHERE username='$username' AND enable_status = 1 LIMIT 1";
$check_username = mysqli_query($conn, $query);

if (mysqli_num_rows($check_username) > 0) {
    $_SESSION["invalid_credentials"] = "Username tidak tersedia.";
    header('Location: ../views/register.php');
}

// insert user
$query = "INSERT INTO users (email, username, password, level_user, date_created, enable_status)
        VALUES ('$email', '$username', '$password', 2, NOW(), 1)";
if (mysqli_query($conn, $query)) {
    $_SESSION["valid_credentials"] = "Berhasil membuat akun, silahkan masukkan username dan password.";
    header('Location: ../views/index.php');
} else {
    $_SESSION["invalid_credentials"] = "Error: " . $conn . '<br/>' . mysqli_error($conn);
    header('Location: ../views/register.php');
}

mysqli_close($conn);
exit();
