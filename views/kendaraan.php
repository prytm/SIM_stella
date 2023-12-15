<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Location: ./index.php');
}

if ($_SESSION["level_user"] != 1) {
    session_destroy();
    header('Location: ./index.php');
}

$conn = mysqli_connect('localhost', 'root', '', 'client_dev');
if (!$conn) {
    var_dump("Error: " . $conn . '<br/>');
    exit();
}

$query = "SELECT * FROM vehicle WHERE enable_status = 1";
$fetch = mysqli_query($conn, $query);
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

    <style>
        .main {
            background-image: url('https://wallpapers.com/images/featured/dslr-blur-r11mojbz9mf7uwl6.jpg');
            background-size: 100%;
            background-position: center;
        }
    </style>

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
                    <?php if ($_SESSION["level_user"] == 1) : ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="./kendaraan.php">Kendaraan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./transaksi.php">Transaksi</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./home.php">Kendaraan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./home.php">Transaksi</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex align-items-center gap-3" method="POST" action="../server/logout.php">
                    <div>
                        <i class="bi bi-person-circle"></i>
                        <span><?= $_SESSION["username"] ?></span>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-door-open"></i> Keluar</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="main">
        <div class="container py-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="fw-bolder text-white">List Kendaraan</h5>
                <a href="./addVehicle.php" class="btn btn-sm btn-light">Tambah Kendaraan</a>
            </div>
            <div class="d-flex flex-wrap gap-5 mt-3">
                <?php while ($row = mysqli_fetch_assoc($fetch)) { ?>
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="../uploads/<?= $row["image"] ?>" alt="Card image cap" height="280" style="object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="card-title fw-bold"><?= $row["plate_number"] ?></span>
                                <span class="<?= $row["in_use"] == 0 ? "bg-success" : "bg-warning" ?> fw-bold <?= $row["in_use"] == 0 ? "text-white" : "" ?> px-2 py-1 rounded" style="font-size: 10px;"><?= $row["in_use"] == 0 ? "Available" : "Sedang Dipakai" ?></span>
                            </div>
                            <p class="card-text"><?= $row["brand"] ?> <?= $row["model"] ?> - <?= $row["type"] ?></p>
                            <p class="fw-bold">Rp. <?= $row["price"] ?></p>
                            <a href="addVehicle.php?vehicle_id=<?= $row["vehicle_id"] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="../server/deleteVehicle.php?vehicle_id=<?= $row["vehicle_id"] ?>" class="btn btn-sm btn-danger">Hapus</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>