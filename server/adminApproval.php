<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'client_dev');

if (!$conn) {
    var_dump("Error: " . $conn . '<br/>');
    exit();
}

$user_id = $_SESSION["user_id"];
$trx_id = $_GET["trx_id"];
$vehicle_id = $_GET["vehicle_id"];
$approve = $_GET["approve"];

$query = "UPDATE trx SET trx_date = NOW(), status = $approve WHERE trx_id = $trx_id";
if ($approve == 2) {
    $query = "UPDATE trx SET trx_date = NOW(), status = $approve, close_date = NOW() WHERE trx_id = $trx_id";
} else if($approve == 3){
    $query = "UPDATE trx SET trx_date = NOW(), status = $approve, amount = 0 WHERE trx_id = $trx_id";
}
if (mysqli_query($conn, $query)) {
    if ($approve == 3 || $approve == 2) {
        $query = "UPDATE vehicle SET in_use = 0 WHERE vehicle_id = '$vehicle_id'";
        mysqli_query($conn, $query);
    }

    header('Location: ../views/adminApprove.php');
}
