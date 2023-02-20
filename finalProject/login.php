<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}
if (isset($_SESSION["login"])) {
    header("location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty(query("SELECT username FROM tbl_users WHERE username = '$username'"))) {

        $queryUser = query("SELECT * FROM tbl_users WHERE username = '$username'")[0];

        if (password_verify($password, $queryUser['password'])) {
            if ($queryUser['status'] == 1) {
                //set session
                $_SESSION["idUser"] = $queryUser['idUser'];
                $_SESSION["uuidUser"] = $queryUser['uuidUser'];
                $_SESSION["login"] = true;

                header("location: index.php");
                exit;
            }
            $error = "Akun anda masih menunggu persetujuan";
        } else {

            $error = "Username atau password salah";
        }
    } else {
        $error = "Username atau password salah";
    }




    // //cek username
    // // var_dump($result);
    // if (mysqli_num_rows($result) === 1) {
    //     //cek password
    //     $row = mysqli_fetch_assoc($result);
    //     // var_dump(password_verify($password, $row["password"]));
    //     if (password_verify($password, $row["password"])) {
    //         // var_dump($row['statusUser']);
    //         if ($row['statusUser'] == 1) {
    //             //set session
    //             $_SESSION["login"] = true;
    //             $_SESSION["idUser"] = $row['idUser'];
    //             $_SESSION["namaUser"] = $row['namaUser'];
    //             $_SESSION["saldoUser"] = $row['saldoUser'];
    //             $_SESSION["roleUser"] = $row['roleUser'];

    //             header("location: index.php");
    //             exit;
    //         }
    //         $error = "Akun anda masih menunggu persetujuan";
    //     } else {
    //         $error = "Password salah";
    //     }
    // } else {
    //     $error = "Username salah";
    // }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="dist/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Student Spending Management</title>
    <link rel="manifest" href="manifest.json">
</head>

<body>












    <div class="relative min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8  bg-no-repeat bg-cover"
        style="background-image: url(https://images.unsplash.com/photo-1525302220185-c387a117886e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80);">
        <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
        <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl z-10">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold font-poppins text-gray-900">
                    Selamat Datang
                </h2>
                <p class="mt-2 text-sm text-gray-600">Silahkan login dengan akun anda</p>

                <?php if (isset($error)): ?>
                    <p class="mt-2 text-sm text-red-500">
                        <?= $error ?>
                    </p>
                <?php endif; ?>
            </div>

            <form class="mt-8 space-y-6" action="" method="POST">
                <input type="hidden" name="remember" value="true">
                <div class="relative">

                    <label class="text-sm font-bold text-gray-700 tracking-wide">Username</label>
                    <input id="username" name="username"
                        class=" w-full text-base py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                        type="text" placeholder="Masukkan username" value="">
                </div>
                <div class="mt-8 content-center">
                    <label class="text-sm font-bold text-gray-700 tracking-wide">
                        Password
                    </label>
                    <input id="password" name="password"
                        class="w-full content-center text-base py-2  border border-gray-300 rounded-xl  focus:outline-none focus:border-indigo-500"
                        type="password" placeholder="Masukkan password" value="">
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="rememberMe" name="rememberMe" type="checkbox"
                            class="h-4 w-4 bg-indigo-500 focus:ring-indigo-400 border-gray-300 rounded">
                        <label for="rememberMe" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-500 hover:text-indigo-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>
                <div>
                    <button type="submit" name="login"
                        class="w-full flex justify-center bg-indigo-500 text-gray-100 p-4  rounded-full tracking-wide
                                font-semibold  focus:outline-none focus:shadow-outline hover:bg-indigo-600 shadow-lg cursor-pointer transition ease-in duration-300">
                        Sign in
                    </button>
                </div>
                <p class="flex flex-col items-center justify-center mt-10 text-center text-md text-gray-500">
                    <span>Belum terdaftar sebagai member?</span>
                    <a href="#"
                        class="text-indigo-500 hover:text-indigo-500 no-underline hover:underline cursor-pointer transition ease-in duration-300">Sign
                        up</a>
                </p>
            </form>
        </div>
    </div>


    <script src="/PWA/test1/main.js"></script>
</body>

</html>