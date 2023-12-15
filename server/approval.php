<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'client_dev');

if (!$conn) {
    var_dump("Error: " . $conn . '<br/>');
    exit();
}

$user_id = $_SESSION["user_id"];
$vehicle_id = $_GET["vehicle_id"];

$query = "SELECT * FROM vehicle WHERE vehicle_id = $vehicle_id LIMIT 1";
$fetch_vehicle = mysqli_query($conn, $query);
$vehicle = mysqli_fetch_assoc($fetch_vehicle);

$query = "INSERT INTO trx (user_id, vehicle_id, amount, status)
          VALUES ($user_id, $vehicle_id, " . $vehicle["price"] . ", 0)";
if (mysqli_query($conn, $query)) {
    $query = "UPDATE vehicle SET in_use = 1 WHERE vehicle_id = '$vehicle_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../views/approval.php');
    }
}
