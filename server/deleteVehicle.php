<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'client_dev');
if (!$conn) {
    $_SESSION["erros"] = "Error: " . $conn . '<br/>';
    header('Location: ../views/addVehicle.php');
}

$vehicle_id = $_GET["vehicle_id"];

$query = "UPDATE vehicle SET enable_status = 0 WHERE vehicle_id = $vehicle_id";
if (mysqli_query($conn, $query)) {
    header('Location: ../views/kendaraan.php');
}
