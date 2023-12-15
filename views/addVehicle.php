<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Location: ./index.php');
}

$vehicle_id = 0;
$plate_number = "";
$brand = "";
$model = "";
$type = "";
$price = "";
$image = "";

if (isset($_GET["vehicle_id"])) {
    $vehicle_id = $_GET["vehicle_id"];
    $conn = mysqli_connect('localhost', 'root', '', 'client_dev');
    if (!$conn) {
        var_dump("Error: " . $conn . '<br/>');
        exit();
    }

    $query = "SELECT * FROM vehicle WHERE vehicle_id = $vehicle_id LIMIT 1";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($res);

    $plate_number = $row["plate_number"];
    $brand = $row["brand"];
    $model = $row["model"];
    $type = $row["type"];
    $price = $row["price"];
    $image = $row["image"];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Home</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="navbar-brand d-flex justify-content-center gap-1">
                <span class="fw-bolder" style="font-size: 18px;">Stella Moto</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="./kendaraan.php">Kendaraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./transaksi.php">Transaksi</a>
                    </li>
                </ul>
                <form method="POST" action="../server/logout.php">
                    <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-door-open"></i> Keluar</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container my-2">
        <form method="POST" action="../server/postVehicle.php" enctype="multipart/form-data" class="d-flex flex-column align-items-stretch justify-content-center mx-auto" style="max-width: 480px;" autocomplete="off">
            <h5 class="fw-bolder text-center mb-3"><?= ($vehicle_id > 0) ? "Perbarui Kendaraan" : "Tambah Kendaraan Baru" ?></h5>
            <input type="hidden" name="vehicle_id" value="<?= $vehicle_id; ?>" />
            <div class="form-group mb-3">
                <label for="plate_number">Nopol</label>
                <input type="text" class="form-control" id="plate_number" name="plate_number" placeholder="Masukkan nopol" value="<?= $plate_number; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand kendaraan" value="<?= $brand; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="model">Model</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Model kendaraan" value="<?= $model; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="type">Tipe</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Tipe kendaraan" value="<?= $type; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="type">Harga Sewa</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Harga Sewa" value="<?= $price; ?>" required>
            </div>
            <div class="mb-5">
                <label for="image" class="form-label">Gambar Kendaraan</label>
                <input class="form-control" type="file" id="image" name="image" <?= ($vehicle_id > 0) ? '' : 'required' ?>>
            </div>

            <button type="submit" class="btn btn-primary"><?= $vehicle_id == 0 ? "Tambah Kendaraan" : "Perbarui Kendaraan" ?></button>
        </form>
    </div>
</body>

</html>