<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "listUser";

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
    $pemasukan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

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
    $queryUser = query("SELECT * FROM tbl_users U, tbl_orangtua O WHERE U.idDetailUser = O.idDetailUser AND idUser = '$idUser'")[0];


    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    $idAnak = $queryUser["idAnak"];

    $queryAnak = query("SELECT * FROM tbl_users U, tbl_siswa S WHERE U.idDetailUser = S.idDetailUser AND idUser = '$idAnak'")[0];

    $saldo = $queryAnak["saldo"];
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

if (isset($_POST['buttonRequest'])) {
    $jumlahRequest = $_POST['jumlahRequest'];
    $pesanRequest = $_POST['pesanRequest'];

    // $queryAdmin = query("SELECT * FROM tbl_users U, tbl_siswa S WHERE U.idDetailUser = S.idDetailUser AND idUser = '$idUser'")[0];
    // $realNameAdmin = $queryAdmin["realName"];
    // $saldoAdmin = $queryAdmin["saldo"];

    $queryNotif = "INSERT INTO tbl_notifikasi (idNotif, idUser, messageNotif, jumlahPermintaan, waktuNotif, statusNotif) VALUES (NULL, '$idUser', '$pesanRequest', '$jumlahRequest', '2023-02-20 15:27:49.000000', '0');";
    mysqli_query($koneksi, $queryNotif);

    header("Location: index.php");
    exit;
}

if (isset($_POST['buttonNonaktifkan'])) {
    $uuidUser = $_POST['uuidUser'];


    mysqli_autocommit($koneksi, false);

    try {

        $sql = "UPDATE tbl_users SET `status` = '0' WHERE uuidUser = '$uuidUser'";
        mysqli_query($koneksi, $sql);

        mysqli_commit($koneksi);

        // echo "Transfer saldo berhasil!";
    } catch (Exception $e) {
        //rollback transaction jika terjadi kesalahan pada operasi transfer
        mysqli_rollback($koneksi);
        // echo "Transfer saldo gagal: " . $e->getMessage();
    }

    mysqli_autocommit($koneksi, true);

}
if (isset($_POST['buttonTolak'])) {
    // $idNotif = $_POST['idNotif'];


    // mysqli_autocommit($koneksi, false);

    // try {

    //     $sql = "UPDATE tbl_notifikasi SET statusNotif = '1' WHERE idNotif = '$idNotif'";
    //     mysqli_query($koneksi, $sql);

    //     mysqli_commit($koneksi);

    //     // echo "Transfer saldo berhasil!";
    // } catch (Exception $e) {
    //     //rollback transaction jika terjadi kesalahan pada operasi transfer
    //     mysqli_rollback($koneksi);
    //     // echo "Transfer saldo gagal: " . $e->getMessage();
    // }

    // mysqli_autocommit($koneksi, true);

    // $_SESSION["idPenjual"] = '';
    // header("Location: index.php");
    // exit;
}

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
            <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar" class="object-cover rounded-full h-24 w-24">
            <h3 class="text-xl font-poppins font-bold text-white">
                <?= $realName; ?>
            </h3>
            <h3 class="font-poppins font-bold text-white">
                <?="Rp " . number_format($saldo, 0, ",", ".") ?>
            </h3>
        <?php elseif ($role == 2): ?>
            <img src="assets/images/avatar/<?= $logoToko; ?>" alt="avatar" class="object-cover rounded-full h-24 w-24">
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
                        <img src="assets/icons/withdraw.png" alt="" class="h-6">

                        <h3 class="text-md font-poppins font-bold ">
                            Withdraw
                        </h3>
                    </div>
                </a>
            </div>
        <?php elseif ($role == 3): ?>
            <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar" class="object-cover rounded-full h-24 w-24">
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
                        <img src="assets/icons/topUp.png" alt="" class="h-6">

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
            <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar" class="object-cover rounded-full h-24 w-24">
            <h3 class="text-xl font-poppins font-bold text-white">
                <?= $realName; ?>
            </h3>
            <h3 class="font-poppins font-bold text-white">
                <?="Rp " . number_format($saldo, 0, ",", ".") ?>
            </h3>

        <?php endif; ?>

    </div>

    <div class="w-xl grid items-center justify-items-center ">
        <div class="grid grid-cols-1 gap-8 p-5 w-full max-w-xl">



            <div class=" w-full grid grid-cols-1 justify-items-center">



                <?php
                $logNotif = query("SELECT * FROM tbl_users WHERE `status` = 1 ORDER BY `role`, realName");
                // var_dump($logNotif); ?>

                <div class="border-2 border-gray-200 w-full rounded-xl overflow-hidden">
                    <div class="relative overflow-x-auto ">
                        <?php
                        if ((!empty($logNotif))): ?>
                            <table class="w-full text-sm text-left text-gray-500  dark:text-gray-400 ">
                                <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 w-full">

                                    <tr>
                                        <th scope="col" class="px-2 py-3">
                                            Nama
                                        </th>
                                        <th scope="col" class="px-2 py-3">
                                            Role
                                        </th>
                                        <th scope="col" class="px-2 py-3">
                                            Saldo
                                        </th>
                                        <th scope="col" class="px-2 py-3">
                                            Action
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">
                                            <div class="border-t-2 border-dashed border-gray-400 w-full"></div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    foreach ($logNotif as $oneView):
                                        ?>
                                        <form action="" method="post">
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <?= $oneView["realName"]; ?>
                                                </th>
                                                <td class="px-2 py-4">
                                                    <?php
                                                    if ($oneView["role"] == 1) {
                                                        echo "Admin";
                                                    } elseif ($oneView["role"] == 2) {
                                                        echo "Penjual";
                                                    } elseif ($oneView["role"] == 3) {
                                                        echo "Siswa";
                                                    } else {
                                                        echo "Orang Tua";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="px-2 py-4">
                                                    <?php
                                                    if ($oneView["role"] == 1) {
                                                        echo "-";
                                                    } elseif ($oneView["role"] == 2) {
                                                        $idUser = $oneView["idUser"];
                                                        $queryUser = query("SELECT * FROM tbl_users U, tbl_penjual P WHERE U.idDetailUser = P.idDetailUser AND idUser = '$idUser'")[0]['saldo'];
                                                        echo "Rp " . number_format($queryUser, 0, ",", ".");
                                                    } elseif ($oneView["role"] == 3) {
                                                        $idUser = $oneView["idUser"];
                                                        $queryUser = query("SELECT * FROM tbl_users U, tbl_siswa S WHERE U.idDetailUser = S.idDetailUser AND idUser = '$idUser'")[0]['saldo'];
                                                        echo "Rp " . number_format($queryUser, 0, ",", ".");
                                                    } else {
                                                        $idUser = $oneView["idUser"];
                                                        $queryUser = query("SELECT * FROM tbl_users U, tbl_orangtua O WHERE U.idDetailUser = O.idDetailUser AND idUser = '$idUser'")[0]['idAnak'];
                                                        $querySaldoAnak = query("SELECT * FROM tbl_users U, tbl_siswa S WHERE U.idDetailUser = S.idDetailUser AND idUser = '$queryUser'")[0]['saldo'];
                                                        echo "Rp " . number_format($querySaldoAnak, 0, ",", ".");
                                                    }
                                                    ?>
                                                </td>

                                                <td class="px-2 py-4">
                                                    <div class="grid grid-cols-1 gap-2">
                                                        <input type="hidden" name="uuidUser"
                                                            value="<?= $oneView["uuidUser"]; ?>">
                                                        <button type="submit" name="buttonNonaktifkan" class="text-red-500">
                                                            Nonaktifkan
                                                        </button>
                                                        <!-- <button type="submit" name="buttonTolak" class="text-red-500">
                                                                                                                                                                                                    Tolak
                                                                                                                                                                                                </button> -->
                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                    <?php endforeach;

                                    ?>
                                </tbody>
                            </table>
                            <?php
                        else:
                            echo '<table class="w-full"><tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th colspan="4" scope="row"
                        class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
                        Tidak ada User yang belum terverifikasi
                    </th>
                    </tr></table>';
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>