<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'client_dev');
if (!$conn) {
    $_SESSION["erros"] = "Error: " . $conn . '<br/>';
    header('Location: ../views/addVehicle.php');
}

$vehicle_id = $_POST["vehicle_id"];
$plate_number = $_POST["plate_number"];
$brand = $_POST["brand"];
$model = $_POST["model"];
$type = $_POST["type"];
$image_file = $_FILES["image"];

$target_dir = "../uploads/";
$target_file = $target_dir . basename($image_file["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$ext = ["jpg", "jpeg", "png"];

if (!in_array(strtolower($imageFileType), $ext)) {
    $_SESSION["erros"] = "Format gambar tidak valid. (Harus jpg, jpeg, png).";
    mysqli_close($conn);
    header('Location: ../views/addVehicle.php');
}

if (move_uploaded_file($image_file["tmp_name"], $target_file)) {
    $query = "INSERT INTO vehicle (plate_number, brand, model, type, image, in_use, enable_status) VALUES ('$plate_number', '$brand', '$model', '$type', '" . $image_file["name"] . "', 0, 1)";
    if ($vehicle_id > 0) {
        $query = "UPDATE vehicle SET plate_number = '$plate_number', brand = '$brand', model = '$model', type = '$type', image = '" . $image_file["name"] . "' WHERE vehicle_id = $vehicle_id";
    }
    if (mysqli_query($conn, $query)) {
        mysqli_close($conn);
        header('Location: ../views/kendaraan.php');
    }
}
