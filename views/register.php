<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Daftar</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="./styles/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="POST" action="../server/postRegister.php" autocomplete="off">
            <div class="d-flex justify-content-center gap-3 mb-3">
                <span class="fw-bolder" style="font-size: 35px;">Pinjam Motor</span>
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" placeholder="username">
                <label for="email">Email</label>
            </div>
            <div class="form-floating">
                <input type="text" name="username" class="form-control" id="username" placeholder="username">
                <label for="username">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <span class="text-danger"><?= (isset($_SESSION["invalid_credentials"]) ? $_SESSION["invalid_credentials"] : '') ?></span>
            <br />
            <span>Sudah punya akun ? <a href="./index.php">Masuk</a></span>
            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Buat Akun</button>
        </form>
    </main>
</body>

</html>
<?php
session_destroy();
?>