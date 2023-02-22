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
</head>

<body>
    <div id="chooseRole"
        class=" p-5 grid grid-cols-1 justify-items-center items-center w-full min-h-screen h-full bg-no-repeat bg-cover"
        style="background-image: url(assets/images/background/bgLogin.jpg);">
        <div class="p-5 bg-white grid grid-cols-1 justify-items-center items-center w-fit h-fit rounded-xl">

            <h2 class="font-poppins text-center align-self-center pb-5 text-2xl">Pilih Tipe Member</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 justify-items-center items-center w-full">
                <div
                    class="w-full max-w-sm bg-white border-2 border-gray-300 border-dashed rounded-lg shadow-2xl px-5 py-8 items-center">
                    <div class="grid grid-cols-1 gap-4 justify-items-center items-center">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg border-2 border-gray-300"
                            src="assets/icons/student.png" alt="Bonnie image" />
                        <span class="text-sm text-gray-500 dark:text-gray-400">Daftar Sebagai</span>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Siswa dan Orang Tua</h5>
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-opacity-90 focus:ring-4 focus:outline-none">Daftar</a>

                    </div>
                </div>
                <div
                    class="w-full max-w-sm bg-white border-2 border-gray-300 border-dashed rounded-lg shadow-2xl px-5 py-8 items-center">
                    <div class="grid grid-cols-1 gap-4 justify-items-center items-center">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg border-2 border-gray-300"
                            src="assets/icons/seller.png" alt="Bonnie image" />
                        <span class="text-sm text-gray-500 dark:text-gray-400">Daftar Sebagai</span>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Penjual</h5>

                        <a href="#"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-opacity-90 focus:ring-4 focus:outline-none">Daftar</a>

                    </div>
                </div>



            </div>
        </div>
    </div>


    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>

</body>

</html>