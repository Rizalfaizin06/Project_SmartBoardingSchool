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
$idUser = $_SESSION["idUser"];

$queryUser = query("SELECT * FROM tbl_users WHERE idUser = '$idUser'")[0];
$role = $queryUser["role"];


if ($role == 1) {
    $queryUser = query("SELECT * FROM tbl_users U, tbl_admin A WHERE U.idDetailUser = A.idDetailUser AND idUser = '$idUser'")[0];
    // var_dump($queryUser);
    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    // $PemasukanHariIni = 128000;

} elseif ($role == 2) {
    $queryUser = query("SELECT * FROM tbl_users U, tbl_penjual P WHERE U.idDetailUser = P.idDetailUser AND idUser = '$idUser'")[0];
    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    $saldo = $queryUser["saldo"];
    $namaToko = $queryUser["namaToko"];
    $logoToko = $queryUser["logoToko"];
    $PemasukanHariIni = 128000;
} elseif ($role == 3) {
    $queryUser = query("SELECT * FROM tbl_users U, tbl_siswa S WHERE U.idDetailUser = S.idDetailUser AND idUser = '$idUser'")[0];

    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    $idOrangTua = $queryUser["idOrangTua"];
    $saldo = $queryUser["saldo"];
    $spendingLimit = $queryUser["spendingLimit"];
    $additionalLimit = $queryUser["additionalLimit"];
    $totalLimit = $spendingLimit + $additionalLimit;
    $listPesanan = query("SELECT *, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'");

    $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];
    $PengeluaranHariIni = 17000;
} else {

}

// $myuuid = createUUID();
// echo $myuuid;

// var_dump($_SESSION['sal$saldo']);
// var_dump($tanggal);




// if ($role == 3) {
//     header("location: buyer.php");
//     exit;
// }


// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldo);



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

        <?php if ($role == 1): ?>
            <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar"
                class="object-cover rounded-full h-24 w-2h-24">
            <h3 class="text-xl font-poppins font-bold text-white">
                <?= $realName; ?>
            </h3>
            <h3 class="font-poppins font-bold text-white">
                <?="Rp " . number_format($saldo, 0, ",", ".") ?>
            </h3>
        <?php elseif ($role == 2): ?>
            <img src="assets/images/avatar/<?= $logoToko; ?>" alt="avatar" class="object-cover rounded-full h-24 w-2h-24">
            <h3 class="text-xl font-poppins font-bold text-white">
                <?= $namaToko; ?>
            </h3>
            <h3 class="font-poppins font-bold text-white">
                <?="Rp " . number_format($saldo, 0, ",", ".") ?>
            </h3>
            <div class=" w-full grid grid-cols-1 justify-items-center">
                <a href="withdraw.php" id="buttonWithdrawPenjual"
                    class="px-4 py-2 mt-2 text-sm font-medium text-center text-primary bg-white rounded-lg hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300">
                    <div class="grid grid-cols-2 h-10 items-center justify-items-center">
                        <img src="assets/icon/withdraw.png" alt="" class="h-6">

                        <h3 class="text-md font-poppins font-bold ">
                            Withdraw
                        </h3>
                    </div>
                </a>
            </div>
        <?php elseif ($role == 3): ?>
            <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar"
                class="object-cover rounded-full h-24 w-2h-24">
            <h3 class="text-xl font-poppins font-bold text-white">
                <?= $realName; ?>
            </h3>
            <h3 class="font-poppins font-bold text-white">
                <?="Rp " . number_format($saldo, 0, ",", ".") ?>
            </h3>
            <div class=" w-full grid grid-cols-1 justify-items-center">
                <button id="buttonTopUpSiswa"
                    class="px-4 py-2 mt-2 text-sm font-medium text-center text-primary bg-white rounded-lg hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300">
                    <div class="grid grid-cols-2 h-10 items-center justify-items-center">
                        <img src="assets/icon/topUp.png" alt="" class="h-6">

                        <h3 class="text-md font-poppins font-bold px-1">
                            Top Up
                        </h3>
                    </div>
                </button>
            </div>

            <script src="dist/js/jquery-3.6.0.min.js"></script>
            <script>             $("#buttonTopUpSiswa").click(function () { $(this).hide(); $("#buttonBayar").hide(); $.ajax({ type: "GET", url: "dist/ajax/ajaxGenerateQR.php", data: "", success: function (data) { console.log(data); $("#siswaPane").html(data) } }); });


            </script>
        <?php else: ?>
        <?php endif; ?>

    </div>

    <div class="w-xl grid items-center justify-items-center ">
        <div class="grid grid-cols-1 gap-8 p-5 w-full max-w-xl">

            <?php
            if ($role == 1): ?>
                <div id="adminPane" class="grid grid-cols-1 gap-5 justify-items-center">
                    <a href="topUp.php" id="buttonQR"
                        class="p-5 w-full border border-gray-200 shadow-lg rounded-xl grid grid-cols-2 gap-5 items-center">
                        <h3 class="text-2xl font-poppins font-bold justify-self-end ">
                            <img src="assets/icon/topUp.png" alt="" class="">
                        </h3>
                        <h3 class="text-xl font-poppins font-bold justify-self-start">
                            Top Up
                        </h3>

                    </a>
                    <button id="buttonWithdraw"
                        class="p-5 w-full border border-gray-200 shadow-lg rounded-xl grid grid-cols-2 gap-5 items-center">
                        <h3 class="text-2xl font-poppins font-bold justify-self-end ">
                            <img src="assets/icon/withdraw.png" alt="" class="">
                        </h3>
                        <h3 class="text-xl font-poppins font-bold justify-self-start">
                            withdraw
                        </h3>

                    </button>
                </div>
                <a href="index.php" id="buttonBack"
                    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300"
                    type="submit" id="buttonCancel" name="buttonCancel">Back</a>
                <script src="dist/js/jquery-3.6.0.min.js"></script>
                <script>                 $("#buttonBack").hide(); $("#buttonWithdraw").click(function () { $.ajax({ type: "GET", url: "dist/ajax/ajaxGenerateQR.php", data: "", success: function (data) { console.log(data); $("#adminPane").html(data)                             $("#buttonBack").show(); } }); });


                </script>
            <?php elseif ($role == 2): ?>
                <div
                    class="p-5 w-full border border-gray-200 shadow-lg rounded-xl grid grid-cols-1 gap-5 justify-items-center">
                    <h3 class="text-xl font-poppins font-bold">
                        Pendapatan Harian
                    </h3>
                    <h3 class="text-2xl font-poppins font-bold">
                        <?="Rp " . number_format($saldo, 0, ",", ".") ?>
                    </h3>

                </div>
            <?php elseif ($role == 3): ?>
                <div id="siswaPane"
                    class="p-5 w-full border border-gray-200 shadow-lg rounded-xl grid grid-cols-1 gap-5 justify-items-center">
                    <h3 class="text-xl font-poppins font-bold">
                        Pengeluaran Harian
                    </h3>
                    <h3 class="text-2xl font-poppins font-bold">
                        <?="Rp " . number_format($Pengeluaran, 0, ",", ".") ?>/
                        <?="Rp " . number_format($totalLimit, 0, ",", ".") ?>
                    </h3>
                    <h3 class="font-poppins font-bold">
                        <?php

                        $persentase = ($Pengeluaran / $totalLimit) * 100;

                        echo round($persentase, 2) . "%";
                        ?>
                    </h3>
                </div>

            <?php endif; ?>




            <div class=" w-full grid grid-cols-1 justify-items-center">

                <?php
                if ($role == 2): ?>
                    <a href="entryMenu.php"
                        class="text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300 w-44">
                        <div class="grid grid-cols-2 gap-3 h-10 items-center justify-items-center">
                            <img src="assets/icon/foodMenu.png" alt="" class="w-8">
                            <h3 class="text-md font-poppins font-bold mr-10 whitespace-nowrap">
                                Buat Pesanan
                            </h3>

                        </div>
                    </a>
                <?php elseif ($role == 3): ?>
                    <a href="pay.php" id="buttonBayar"
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