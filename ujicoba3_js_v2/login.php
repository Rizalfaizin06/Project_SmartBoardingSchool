<?php
session_start();
include "fungsiAdmin.php";

if (isset($_SESSION["login"])) {
    header("location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM tbl_users WHERE username = '$username'");
    //cek username
    // var_dump($result);
    if (mysqli_num_rows($result) === 1) {
        //cek password
        $row = mysqli_fetch_assoc($result);
        var_dump(password_verify($password, $row["password"]));
        if (password_verify($password, $row["password"])) {
            var_dump($row['statusUser']);
            if ($row['statusUser'] == 1) {
                //set session
                $_SESSION["login"] = true;
                $_SESSION["idUser"] = $row['idUser'];
                $_SESSION["namaUser"] = $row['namaUser'];
                $_SESSION["saldoUser"] = $row['saldoUser'];
                $_SESSION["roleUser"] = $row['roleUser'];

                header("location: index.php");
                exit;
            }
            $error = "Akun anda masih menunggu persetujuan";
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Username salah";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/icon/bootstrap-icons.css">
    <title>Wirapustaka</title>
</head>

<body>


    <!-- Section: Design Block -->
    <section class="">
        <!-- Jumbotron -->
        <div class="px-4 py-5 px-md-5 text-center text-lg-start">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="my-5 display-3 fw-bold ls-tight">
                            Boarding School<br />
                            <span class="text-primary fs-1">SMKN 1 WIROSARI</span>
                        </h1>
                        <!-- <p style="color: hsl(217, 10%, 50.8%)">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                        quibusdam tempora at cupiditate quis eum maiores libero
                        veritatis? Dicta facilis sint aliquid ipsum atque?
                    </p> -->
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card">

                            <div class="card-body py-5 px-md-5">
                                <form action="" method="post">
                                    <!-- 2 column grid layout with text inputs for the first and last names -->
                                    <h1 class="mb-3 fw-bold">LOGIN</h1>
                                    <?php if (isset($error)): ?>
                                        <p style="color: red; font-style: italic;">
                                            <?= $error ?>
                                        </p>
                                    <?php endif; ?>
                                    <!-- Email input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control text-center text-lg-start">
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control text-center text-lg-start">
                                    </div>

                                    <!-- Checkbox -->
                                    <div class="form-check d-flex justify-content-center mb-4">
                                        <input class="form-check-input me-2" type="checkbox" value=""
                                            id="form2Example33" checked />
                                        <label class="form-check-label" for="form2Example33">
                                            Remember me
                                        </label>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="text-center">

                                        <button type="submit" name="login" class="btn btn-primary btn-block mb-4 ">
                                            Sign In
                                        </button>
                                    </div>

                                    <!-- Register buttons -->

                                    <div class="text-center">
                                        <p>Or sign up with :

                                            <a href="registrasi.php"
                                                class="text-decoration-none text text-black fw-bold">
                                                Sign
                                                Up</a>
                                        </p>
                                    </div>
                                </form>
                                <a href="../" class="text-decoration-none text text-black fw-bold text-center">
                                    Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <script src="assets/js/bootstrap.bundle.min.js">
    </script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>