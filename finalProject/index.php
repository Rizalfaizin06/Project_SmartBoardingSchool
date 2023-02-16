<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "dashboard";

$menu = query("SELECT * FROM tbl_menu");
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];


$roleUser = $_SESSION["roleUser"];
$querydLihatSaldo = query("SELECT saldoUser FROM tbl_users WHERE idUser = '$idUser'");
$saldoUser = $querydLihatSaldo[0]["saldoUser"];


$_SESSION["saldoUser"] = $saldoUser;

// var_dump($_SESSION['saldoUser']);




// if ($roleUser == 3) {
//     header("location: buyer.php");
//     exit;
// }


// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldoUser);



?>


<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dist/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'dist/template/navbar.php'; ?>





    <div class="grid grid-cols-1 items-center justify-items-center bg-primary h-64 w-full rounded-b-3xl shadow-xl p-5">
        <img src="assets/images/gb.jpg" alt="avatar" class="object-cover rounded-full h-24 w-2h-24">
        <h3 class="text-xl font-poppins font-bold text-white">
            <?= $namaUser; ?>
        </h3>
        <h3 class="font-poppins font-bold text-white">
            <?="Rp " . number_format($saldoUser, 0, ",", ".") ?>
        </h3>
        <div class=" w-full grid grid-cols-1 justify-items-center">
            <button
                class="px-4 py-2 mt-2 text-sm font-medium text-center text-primary bg-white rounded-lg hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300">
                <div class="grid grid-cols-2 h-10 items-center justify-items-center">
                    <img src="assets/icon/topUp.png" alt="" class="h-6">
                    <h3 class="text-md font-poppins font-bold px-1">
                        Top Up
                    </h3>
                </div>
            </button>
        </div>
    </div>

    <div class="w-xl grid  items-center justify-items-center ">
        <div class="grid grid-cols-1 gap-8 p-5 w-full max-w-xl">

            <?php
            if ($roleUser == 2): ?>
                <div
                    class="p-5 w-full border border-gray-200 shadow-lg rounded-xl grid grid-cols-1 gap-5 justify-items-center">
                    <h3 class="text-xl font-poppins font-bold">
                        Pendapatan Harian
                    </h3>
                    <h3 class="text-2xl font-poppins font-bold">
                        <?="Rp " . number_format($saldoUser, 0, ",", ".") ?>
                    </h3>

                </div>
            <?php elseif ($roleUser == 3): ?>
                <div
                    class="p-5 w-full border border-gray-200 shadow-lg rounded-xl grid grid-cols-1 gap-5 justify-items-center">
                    <h3 class="text-xl font-poppins font-bold">
                        Pengeluaran Harian
                    </h3>
                    <h3 class="text-2xl font-poppins font-bold">
                        <?="Rp " . number_format($saldoUser, 0, ",", ".") ?>
                    </h3>

                </div>
            <?php endif; ?>




            <div class=" w-full grid grid-cols-1 justify-items-center">

                <?php
                if ($roleUser == 2): ?>
                    <a href="entryMenu.php"
                        class="text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300 w-44">
                        <div class="grid grid-cols-2 gap-3 h-10 items-center justify-items-center">
                            <img src="assets/icon/foodMenu.png" alt="" class="w-8">
                            <h3 class="text-md font-poppins font-bold mr-10 whitespace-nowrap">
                                Buat Pesanan
                            </h3>

                        </div>
                    </a>
                <?php elseif ($roleUser == 3): ?>
                    <a href="pay.php"
                        class="px-4 py-2 mt-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300">
                        <div class="grid grid-cols-2 h-10 items-center justify-items-center">
                            <img src="assets/icon/scanQR.png" alt="" class="h-6">
                            <h3 class="text-md font-poppins font-bold px-1">
                                Bayar
                            </h3>

                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>