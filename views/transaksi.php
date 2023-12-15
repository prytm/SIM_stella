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

$query = "SELECT a.*, b.username FROM
          (
            SELECT a.*, b.plate_number, b.brand, b.model, b.type FROM trx a 
            INNER JOIN vehicle b ON a.vehicle_id = b.vehicle_id
          ) a INNER JOIN users b ON a.user_id = b.user_id";
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
                            <a class="nav-link" href="./kendaraan.php">Kendaraan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./transaksi.php">Transaksi</a>
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
    <div class="container my-2">
        <h5 class="fw-bold text-center mb-3">Daftar Transaksi Kendaraan</h5>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nopol</th>
                    <th scope="col">Peminjam</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th scope="col">Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal Pinjam</th>
                    <th scope="col">Tanggal Selesai</th>
                    <th scope="col">Income</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($fetch)) { ?>
                    <tr>
                        <th scope="row">
                            <?= $no; ?>
                        </th>
                        <td>
                            <?= $row["plate_number"] ?>
                        </td>
                        <td>
                            <?= $row["username"] ?>
                        </td>
                        <td>
                            <?= $row["brand"] ?>
                        </td>
                        <td>
                            <?= $row["model"] ?>
                        </td>
                        <td>
                            <?= $row["type"] ?>
                        </td>
                        <td>
                            <span class="bg-secondary text-white px-2 py-1 rounded fw-bold" style="font-size: 12px;">
                                <?php if ($row["status"] == 0) : ?>
                                    Menunggu Approval
                                <?php elseif ($row["status"] == 1) : ?>
                                    Sedang Dipinjam
                                <?php elseif ($row["status"] == 2) : ?>
                                    Selesai
                                <?php elseif ($row["status"] == 3) : ?>
                                    Transaksi Dibatalkan
                                <?php else : ?>
                                    Status Tidak Valid
                                <?php endif; ?>
                            </span>
                        </td>
                        <td>
                            <?= $row["trx_date"] ?>
                        </td>
                        <td>
                            <?= $row["close_date"] == "0000-00-00" ? "-" : $row["close_date"] ?>
                        </td>
                        <td>
                            Rp. <?= $row["amount"] ?>
                        </td>
                        <td>
                            <?php if ($row["status"] == 0) : ?>
                                <a href="../server/adminApproval.php?approve=1&vehicle_id=<?= $row["vehicle_id"] ?>&trx_id=<?= $row["trx_id"] ?>" class="btn btn-sm btn-outline-success">Approve</a>
                                <a href="../server/adminApproval.php?approve=3&vehicle_id=<?= $row["vehicle_id"] ?>&trx_id=<?= $row["trx_id"] ?>" class="btn btn-sm btn-outline-danger">Reject</a>
                            <?php elseif ($row["status"] == 1) : ?>
                                <a href="../server/adminApproval.php?approve=2&vehicle_id=<?= $row["vehicle_id"] ?>&trx_id=<?= $row["trx_id"] ?>" class="btn btn-sm btn-outline-success">Selesaikan Transaksi</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>