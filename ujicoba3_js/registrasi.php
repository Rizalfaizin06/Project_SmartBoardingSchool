<?php
// require 'fungsiAdmin.php';

// if (isset($_POST["register"])) {
//     if (registrasi($_POST) > 0) {
//         echo "<script>
// 				alert('Sign Up berhasil');
// 			</script>";
//         header("location: login.php");
//     } else {
//         echo mysqli_error($koneksi);
//     }
// }


?>


<!-- 

<!DOCTYPE html>
<html>

<head>
	<title>Registrasi</title>
</head>

<body>
	<h1>Registrasi</h1>

	<form action="" method="post">
		<ul>
			<li>
				<label for="username">username :</label>
				<input type="text" name="username" id="username">
			</li>
			<li>
				<label for="password">password :</label>
				<input type="password" name="password" id="password">
			</li>
			<li>
				<label for="password2">konfirmasi password :</label>
				<input type="password" name="password2" id="password2">
			</li>
			<li>
				<button type="submit" name="register">Sign Up</button>
			</li>
		</ul>
	</form>
	<a href="login.php">Back</a>
</body>

</html> -->




<?php
include "fungsiAdmin.php";


if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
				alert('Sign Up berhasil');
			</script>";
        header("location: login.php");
    } else {
        echo mysqli_error($koneksi);
        $error = true;
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
						<div class="card">
							<div class="card-body py-5 px-md-5">
								<form action="" method="post">
									<!-- 2 column grid layout with text inputs for the first and last names -->
									<h1 class="mb-3 fw-bold">Register</h1>
									<?php if (isset($error)) : ?>
									<p style="color: red; font-style: italic;">Silahkan Ulangi Registrasi Anda</p>
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

									<div class="form-outline mb-4">
										<label class="form-label" for="password2">Konfirmasi Password :</label>
										<input type="password" name="password2" id="password2"
											class="form-control text-center text-lg-start">
									</div>

									<!-- Checkbox -->
									<!-- <div class="form-check d-flex justify-content-center mb-4">
										<input class="form-check-input me-2" type="checkbox" value=""
											id="form2Example33" checked />
										<label class="form-check-label" for="form2Example33">
											Remember me
										</label>
									</div> -->

									<!-- Submit button -->
									<div class="text-center">

										<button type="submit" name="register" class="btn btn-primary btn-block mb-4 ">
											Register
										</button>
									</div>

									<!-- Register buttons -->

									<!-- <div class="text-center">
										<p>Or sign up with :

											<a href="registrasi.php"
												class="text-decoration-none text text-black fw-bold">
												Sign
												Up</a>
										</p>
									</div> -->
								</form>
								<a href="login.php" class="text-decoration-none text text-black fw-bold text-center">
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