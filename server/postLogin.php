<?php
session_start();
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect('localhost', 'root', '', 'client_dev');
if (!$conn) {
    $_SESSION["invalid_credentials"] = "Error: " . $conn . '<br/>';
    header('Location: ../views/index.php');
}

$query = "SELECT * FROM users WHERE username='$username' AND enable_status = 1 LIMIT 1";
$user = mysqli_query($conn, $query);

if (mysqli_num_rows($user) > 0) {
    $user_info = mysqli_fetch_assoc($user);

    if ($user_info["password"] != $password) {
        $_SESSION["invalid_credentials"] = "Password salah.";
        header('Location: ../views/index.php');
    }

    $_SESSION["user_id"] = $user_info["user_id"];
    $_SESSION["username"] = $user_info["username"];
    $_SESSION["level_user"] = $user_info["level_user"];
    if ($_SESSION["level_user"] == 1) {
        header('Location: ../views/kendaraan.php');
    } else {
        header('Location: ../views/listKendaraan.php');
    }
} else {
    $_SESSION["invalid_credentials"] = "Username tidak tersedia.";
    header('Location: ../views/index.php');
}

mysqli_close($conn);
