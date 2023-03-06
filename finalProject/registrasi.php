<?php
if (!session_id()) {
	session_start();
	require 'dist/function/function.php';
}

if (isset($_POST["buttonDaftar"])) {
	// foreach ($_POST as $key => $value)
	// 	echo $key . '=' . $value . '<br />';

	// var_dump($_FILES);
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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="dist/css/style.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link rel="icon" href="assets/icons/app/icon_SFM_Rounded.png" type="image/icon type">
	<title>Student Financial Management</title>
</head>

<body>

	<?php if (isset($error)): ?>
		<p style="color: red; font-style: italic;">Silahkan Ulangi Registrasi Anda</p>
	<?php endif; ?>





	<!-- component -->
	<div class="relative min-h-screen flex items-center justify-center bg-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 bg-no-repeat bg-cover "
		style="background-image: url(assets/images/background/bgLogin.jpg);">
		<div class="absolute bg-black opacity-60 inset-0 z-0"></div>







		<div id="chooseRole"
			class="p-5 bg-white grid grid-cols-1 justify-items-center gap-5 items-center w-fit h-fit rounded-xl z-10">

			<h2 class="font-poppins text-center align-self-center text-2xl">Pilih Tipe Member</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-center items-center w-full">
				<div
					class="w-full max-w-sm bg-white border-2 border-gray-300 border-dashed rounded-lg shadow-2xl px-5 py-8 items-center">
					<div class="grid grid-cols-1 gap-4 justify-items-center items-center">
						<img class="w-24 h-24 mb-3 rounded-full shadow-lg border-2 border-gray-300"
							src="assets/icons/student.png" alt="Bonnie image" />
						<span class="text-sm text-gray-500 dark:text-gray-400">Daftar Sebagai</span>
						<h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Siswa dan Orang Tua</h5>
						<button id="buttonSiswa"
							class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-opacity-90 focus:ring-4 focus:outline-none">Daftar</button>

					</div>
				</div>
				<div
					class="w-full max-w-sm bg-white border-2 border-gray-300 border-dashed rounded-lg shadow-2xl px-5 py-8 items-center">
					<div class="grid grid-cols-1 gap-4 justify-items-center items-center">
						<img class="w-24 h-24 mb-3 rounded-full shadow-lg border-2 border-gray-300"
							src="assets/icons/seller.png" alt="Bonnie image" />
						<span class="text-sm text-gray-500 dark:text-gray-400">Daftar Sebagai</span>
						<h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Penjual</h5>

						<button id="buttonPenjual"
							class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-opacity-90 focus:ring-4 focus:outline-none">Daftar</button>

					</div>
				</div>
			</div>
			<a href="login.php"
				class="inline-flex items-center px-4 py-2 mr-5 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-opacity-90 focus:ring-4 focus:outline-none">Back</a>
		</div>














		<div id="siswaPane" class="hidden max-w-xl w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
			<div class="grid  gap-8 grid-cols-1">
				<div class="flex flex-col ">
					<div class="flex flex-col sm:flex-row items-center">
						<h2 class="font-semibold font-poppins text-2xl text-center">Registrasi member</h2>
						<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
					</div>
					<div class="mt-5">
						<div>
							<form action="" method="post" enctype="multipart/form-data">








								<div class="md:space-y-2 mb-3">
									<!-- <label class="font-poppins text-xs font-semibold text-gray-600 py-2">Profil<abbr
										class="hidden" title="required">*</abbr></label> -->
									<div class="flex flex-col sm:flex-row items-center">
										<h2 class="font-semibold font-poppins text-xl text-center">Siswa</h2>
										<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
									</div>
									<div class="flex items-center">
										<div class="w-20 h-20 mr-4 flex-none rounded-xl border overflow-hidden">
											<img class="w-20 h-20 mr-4 object-cover"
												src="assets/images/avatar/defaultProfile.jpg">
										</div>
										<label class="font-poppins cursor-pointer ">

											<span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
												for="file_input">Foto profil</span>
											<input
												class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
												id="file_input" type="file" name="fotoProfilSiswa">
										</label>
									</div>
								</div>
								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nama
											lengkap</label>
										<input placeholder="Masukkan Nama Lengkap"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="realNameSiswa" id="realNameSiswa">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>

								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Tempat
											Lahir</label>
										<input placeholder="Masukkan Tempat Lahir"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="tempatLahirSiswa" id="tempatLahirSiswa">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Tanggal
											Lahir</label>
										<input placeholder="Masukkan Tanggal Lahir"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="date" name="tanggalLahirSiswa" id="tanggalLahirSiswa">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>
								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nomor
											Telfon</label>
										<input placeholder="Masukkan Nomor Telfon"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="nomorTelfonSiswa" id="nomorTelfonSiswa">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Email</label>
										<input placeholder="Masukkan Email"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="emailSiswa" id="emailSiswa">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>
								<div class="flex-auto w-full mb-1 text-xs space-y-2">
									<label class="font-poppins font-semibold text-gray-600 py-2">Alamat</label>
									<textarea name="alamatSiswa" id="alamatSiswa"
										class="min-h-[100px] max-h-[300px] h-28 appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4"
										placeholder="Masukkan Alamat Lengkap" spellcheck="false"></textarea>
									<!-- <p class="font-poppins text-xs text-gray-400 text-left my-3">You inserted 0 characters
								</p> -->
								</div>
								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Username</label>
										<input placeholder="Masukkan Username"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="usernameSiswa" id="usernameSiswa">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>

								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Password</label>
										<input placeholder="Masukkan Password"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="passwordSiswa" id="passwordSiswa">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Konfirmasi
											Password</label>
										<input placeholder="Masukkan Password"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="konfirmasiPasswordSiswa" id="konfirmasiPasswordSiswa">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>

								<div class="p-5"></div>

								<div class="md:space-y-2 mb-3">
									<!-- <label class="font-poppins text-xs font-semibold text-gray-600 py-2">Profil<abbr
										class="hidden" title="required">*</abbr></label> -->
									<div class="flex flex-col sm:flex-row items-center">
										<h2 class="font-semibold font-poppins text-xl text-center">Orang Tua</h2>
										<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
									</div>
									<div class="flex items-center">
										<div class="w-20 h-20 mr-4 flex-none rounded-xl border overflow-hidden">
											<img class="w-20 h-20 mr-4 object-cover"
												src="assets/images/avatar/defaultProfile.jpg">
										</div>
										<label class="font-poppins cursor-pointer ">

											<span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
												for="file_input">Foto profil</span>
											<input
												class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
												id="file_input" type="file" name="fotoProfilOrangTua">
										</label>
									</div>
								</div>
								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nama
											lengkap</label>
										<input placeholder="Masukkan Nama Lengkap"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="realNameOrangTua" id="realNameOrangTua">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>

								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Tempat
											Lahir</label>
										<input placeholder="Masukkan Tempat Lahir"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="tempatLahirOrangTua" id="tempatLahirOrangTua">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Tanggal
											Lahir</label>
										<input placeholder="Masukkan Tanggal Lahir"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="date" name="tanggalLahirOrangTua" id="tanggalLahirOrangTua">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>
								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nomor
											Telfon</label>
										<input placeholder="Masukkan Nomor Telfon"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="nomorTelfonOrangTua" id="nomorTelfonOrangTua">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Email</label>
										<input placeholder="Masukkan Email"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="emailOrangTua" id="emailOrangTua">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>
								<div class="flex-auto w-full mb-1 text-xs space-y-2">
									<label class="font-poppins font-semibold text-gray-600 py-2">Alamat</label>
									<textarea name="alamatOrangTua" id="alamatOrangTua"
										class="min-h-[100px] max-h-[300px] h-28 appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4"
										placeholder="Masukkan Alamat Lengkap" spellcheck="false"></textarea>
									<!-- <p class="font-poppins text-xs text-gray-400 text-left my-3">You inserted 0 characters
								</p> -->
								</div>
								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Username</label>
										<input placeholder="Masukkan Username"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="usernameOrangTua" id="usernameOrangTua">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>

								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Password</label>
										<input placeholder="Masukkan Password"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="passwordOrangTua" id="passwordOrangTua">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Konfirmasi
											Password</label>
										<input placeholder="Masukkan Password"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="konfirmasiPasswordOrangTua"
											id="konfirmasiPasswordOrangTua">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>













								<!-- <p class="font-poppins text-xs text-red-500 text-right my-3">Required fields are marked with
								an
								asterisk <abbr title="Required field">*</abbr></p> -->
								<div class="mt-5 text-center md:text-right md:space-x-3 md:block flex flex-col-reverse">
									<input type="hidden" name="role" value="3">
									<a href="login.php"
										class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
										<span class="">Cancel</span> </a>
									<button type="submit"
										class="mb-2 md:mb-0 bg-primary px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-opacity-90"
										name="buttonDaftar">Daftar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>


















		<div id="penjualPane" class="hidden max-w-xl w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
			<div class="grid  gap-8 grid-cols-1">
				<div class="flex flex-col ">
					<div class="flex flex-col sm:flex-row items-center">
						<h2 class="font-semibold font-poppins text-2xl text-center">Registrasi member</h2>
						<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
					</div>
					<div class="mt-5">
						<div>
							<form action="" method="post" enctype="multipart/form-data">








								<div class="md:space-y-2 mb-3">
									<!-- <label class="font-poppins text-xs font-semibold text-gray-600 py-2">Profil<abbr
										class="hidden" title="required">*</abbr></label> -->
									<div class="flex flex-col sm:flex-row items-center">
										<h2 class="font-semibold font-poppins text-xl text-center">Penjual</h2>
										<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
									</div>
									<div class="flex items-center">
										<div class="w-20 h-20 mr-4 flex-none rounded-xl border overflow-hidden">
											<img class="w-20 h-20 mr-4 object-cover"
												src="assets/images/avatar/defaultProfile.jpg">
										</div>
										<label class="font-poppins cursor-pointer ">

											<span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
												for="file_input">Foto profil</span>
											<input
												class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
												id="file_input" type="file" name="fotoProfilPenjual">
										</label>
									</div>
								</div>
								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nama
											lengkap</label>
										<input placeholder="Masukkan Nama Lengkap"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="realNamePenjual" id="realNamePenjual">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>

								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Tempat
											Lahir</label>
										<input placeholder="Masukkan Tempat Lahir"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="tempatLahirPenjual" id="tempatLahirPenjual">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Tanggal
											Lahir</label>
										<input placeholder="Masukkan Tanggal Lahir"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="date" name="tanggalLahirPenjual" id="tanggalLahirPenjual">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>
								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nomor
											Telfon</label>
										<input placeholder="Masukkan Nomor Telfon"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="nomorTelfonPenjual" id="nomorTelfonPenjual">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Email</label>
										<input placeholder="Masukkan Email"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="emailPenjual" id="emailPenjual">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>
								<div class="flex-auto w-full mb-1 text-xs space-y-2">
									<label class="font-poppins font-semibold text-gray-600 py-2">Alamat</label>
									<textarea name="alamatPenjual" id="alamatPenjual"
										class="min-h-[100px] max-h-[300px] h-28 appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4"
										placeholder="Masukkan Alamat Lengkap" spellcheck="false"></textarea>
									<!-- <p class="font-poppins text-xs text-gray-400 text-left my-3">You inserted 0 characters
								</p> -->
								</div>
								<div class="md:space-y-2 mb-3">
									<!-- <label class="font-poppins text-xs font-semibold text-gray-600 py-2">Profil<abbr
										class="hidden" title="required">*</abbr></label> -->
									<div class="flex flex-col sm:flex-row items-center">
										<h2 class="font-semibold font-poppins text-xl text-center">Toko</h2>
										<div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
									</div>
									<div class="flex items-center">
										<div class="w-20 h-20 mr-4 flex-none rounded-xl border overflow-hidden">
											<img class="w-20 h-20 mr-4 object-cover"
												src="assets/images/avatar/defaultProfile.jpg">
										</div>
										<label class="font-poppins cursor-pointer ">

											<span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
												for="file_input">Logo Toko</span>
											<input
												class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
												id="file_input" type="file" name="fotoProfilOrangTua">
										</label>
									</div>
								</div>

								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Nama Toko</label>
										<input placeholder="Masukkan Nama Toko"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="namaToko" id="namaToko">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>
								<div class="md:flex flex-row md:space-x-4 w-full text-xs">
									<div class="mb-3 space-y-2 w-full text-xs">
										<label class="font-poppins font-semibold text-gray-600 py-2">Username</label>
										<input placeholder="Masukkan Username"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											required type="text" name="usernamePenjual" id="usernamePenjual">
										<p class="font-poppins text-red text-xs hidden">Please fill out this field.</p>
									</div>
								</div>

								<div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Password</label>
										<input placeholder="Masukkan Password"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="passwordPenjual" id="passwordPenjual">
									</div>
									<div class="w-full flex flex-col mb-3">
										<label class="font-poppins font-semibold text-gray-600 py-2">Konfirmasi
											Password</label>
										<input placeholder="Masukkan Password"
											class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
											type="text" name="konfirmasiPasswordPenjual" id="konfirmasiPasswordPenjual">
										<p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
											out
											this field.
										</p>
									</div>
								</div>

								<div class="p-5"></div>










								<!-- <p class="font-poppins text-xs text-red-500 text-right my-3">Required fields are marked with
								an
								asterisk <abbr title="Required field">*</abbr></p> -->
								<div class="mt-5 text-center md:text-right md:space-x-3 md:block flex flex-col-reverse">
									<input type="hidden" name="role" value="2">
									<a href="login.php"
										class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
										<span class="">Cancel</span> </a>
									<button type="submit"
										class="mb-2 md:mb-0 bg-primary px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-opacity-90"
										name="buttonDaftar">Daftar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>





	</div>




	<script src="node_modules/flowbite/dist/flowbite.min.js"></script>
	<script src="dist/js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript">

		// $("#siswaPane").hide();
		// $("#penjualPane").hide();


		$("#buttonSiswa").click(function () {
			$("#chooseRole").hide();
			$("#siswaPane").show();
		});

		$("#buttonPenjual").click(function () {
			$("#chooseRole").hide();
			$("#penjualPane").show();
		});


	</script>
</body>

</html>