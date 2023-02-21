<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}


if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "profile";
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





    <div class="grid grid-cols-1 items-center justify-items-center bg-primary h-48 w-full rounded-b-3xl shadow-xl p-5">
        <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar" class="object-cover rounded-full h-24 w-24">
        <h3 class="text-xl font-poppins font-bold text-white">
            <?= $realName; ?>
        </h3>
        <h3 class="font-poppins font-bold text-white">
            <?="Rp " . number_format($saldo, 0, ",", ".") ?>
        </h3>

    </div>

    <div class="grid grid-cols-1 w-full h-full items-center justify-items-center mt-5">
        <div class="overflow-x-auto w-full h-full max-w-xl overflow-hidden p-5">
            <table class="w-full text-sm text-start text-gray-500 dark:text-gray-400">
                <tbody>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Nama
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            :
                            <?= $realName; ?>
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            TTL
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            :
                            <?= $tempatLahir; ?>,
                            <?= date("d F Y", strtotime($tanggalLahir)); ?>
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Alamat
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            :
                            <?= $alamat; ?>
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            No. HP
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            :
                            <?= $nomorTelfon; ?>
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Email
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            :
                            <?= $email; ?>
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Orang tua
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : RAB
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>




    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>