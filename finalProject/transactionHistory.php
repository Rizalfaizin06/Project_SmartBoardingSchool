<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

if (!isset($_SESSION['buttonHariIni']) && !isset($_SESSION['buttonBulanIni']) && !isset($_SESSION['buttonTahunIni']) && !isset($_SESSION['buttonKeseluruhan'])):
    $_SESSION['buttonHariIni'] = true;
endif;

if (isset($_POST['buttonHariIni'])):
    $_SESSION['buttonHariIni'] = true;
    $_SESSION['buttonBulanIni'] = false;
    $_SESSION['buttonTahunIni'] = false;
    $_SESSION['buttonKeseluruhan'] = false;
elseif (isset($_POST['buttonBulanIni'])):
    $_SESSION['buttonHariIni'] = false;
    $_SESSION['buttonBulanIni'] = true;
    $_SESSION['buttonTahunIni'] = false;
    $_SESSION['buttonKeseluruhan'] = false;
elseif (isset($_POST['buttonTahunIni'])):
    $_SESSION['buttonHariIni'] = false;
    $_SESSION['buttonBulanIni'] = false;
    $_SESSION['buttonTahunIni'] = true;
    $_SESSION['buttonKeseluruhan'] = false;
elseif (isset($_POST['buttonKeseluruhan'])):
    $_SESSION['buttonHariIni'] = false;
    $_SESSION['buttonBulanIni'] = false;
    $_SESSION['buttonTahunIni'] = false;
    $_SESSION['buttonKeseluruhan'] = true;
endif;



$_SESSION["currentPage"] = "transaction";
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
    $PengeluaranHariIni = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

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

$category = query("SELECT DISTINCT namaCategory, C.idCategory FROM tbl_menu M, tbl_category C WHERE idPenjual = '$idUser' AND M.idCategory = C.idCategory");
// var_dump($category);

// if ($roleUser == 3) {
//     header("location: buyer.php");
//     exit;
// }


// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldoUser);




// $idPenjual = 1;





// $querydOrder = query("SELECT idOrder FROM tbl_order WHERE O.idPenjual = '$idUser' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");

// if (!empty($querydOrder)) {
//     $idOrder = $querydOrder[0]["idOrder"];
//     // var_dump($idOrder);

//     $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'");
//     // var_dump($dataOrderan);

//     $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
//     // var_dump($totalHarga);
// }

// $pembayaran = $querydOrder;





$logTransaksi = query("SELECT * FROM tbl_log WHERE DATE(waktuTransfer) = '$tanggal' ORDER BY idLog DESC");
$bulan = date("n");
$tahun = date("Y");

// var_dump($bulan);
// var_dump($tahun);


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
<?php include 'dist/template/navbar.php';





?>

    <div class="p-3 grid grid-cols-1" id="allContent">


        <div
            class="static md:sticky md:top-32 block m-3 p-3 bg-white border border-gray-200 rounded-xl shadow overflow-hidden">
            <form action="?" method="post">


            <div class="pb-5 grid grid-cols-2 gap-1">
                <?php if (isset($_SESSION['buttonHariIni']) && $_SESSION['buttonHariIni'] == true): ?>
                        <button id="buttonHariIni" name="buttonHariIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-gray-200 shadow-md text-xs font-poppins font-bold text-center" disabled>


                        Hari ini
                    </button>
                    <button id="buttonBulanIni" name="buttonBulanIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Bulan ini
                    </button>
                    <button id="buttonTahunIni" name="buttonTahunIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Tahun ini
                    </button>
                    <button id="buttonKeseluruhan" name="buttonKeseluruhan" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Keseluruhan
                    </button>
<?php elseif (isset($_SESSION['buttonBulanIni']) && $_SESSION['buttonBulanIni'] == true): ?>
                        <button id="buttonHariIni" name="buttonHariIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Hari ini
                    </button>
                    <button id="buttonBulanIni" name="buttonBulanIni" type="submit"
                    class="px-3 py-3 rounded-lg bg-gray-200 shadow-md text-xs font-poppins font-bold text-center" disabled>


                        Bulan ini
                    </button>
                    <button id="buttonTahunIni" name="buttonTahunIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Tahun ini
                    </button>
                    <button id="buttonKeseluruhan" name="buttonKeseluruhan" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Keseluruhan
                    </button>
<?php elseif (isset($_SESSION['buttonTahunIni']) && $_SESSION['buttonTahunIni'] == true): ?>
                        <button id="buttonHariIni" name="buttonHariIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Hari ini
                    </button>
                    <button id="buttonBulanIni" name="buttonBulanIni" type="submit"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Bulan ini
                    </button>
                    <button id="buttonTahunIni" name="buttonTahunIni" type="submit"
                    class="px-3 py-3 rounded-lg bg-gray-200 shadow-md text-xs font-poppins font-bold text-center" disabled>


                        Tahun ini
                    </button>
                    <button id="buttonKeseluruhan" name="buttonKeseluruhan" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Keseluruhan
                    </button>
<?php elseif (isset($_SESSION['buttonKeseluruhan']) && $_SESSION['buttonKeseluruhan'] == true): ?>
                        <button id="buttonHariIni" name="buttonHariIni" type="submit"
                        class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Hari ini
                    </button>
                    <button id="buttonBulanIni" name="buttonBulanIni" type="submit"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Bulan ini
                    </button>
                    <button id="buttonTahunIni" name="buttonTahunIni" type="submit"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                        Tahun ini
                    </button>
                    <button id="buttonKeseluruhan" name="buttonKeseluruhan" type="submit"
                    class="px-3 py-3 rounded-lg bg-gray-200 shadow-md text-xs font-poppins font-bold text-center" disabled>


                        Keseluruhan
                    </button>
                
                        
                <?php endif; ?>
                
            </div>
                <div>
                    <h2 class="text-2xl font-poppins font-bold underline text-center">
                        
                    <?php
                    if (isset($_SESSION['buttonHariIni']) && $_SESSION['buttonHariIni'] == true) {
                        echo "Transaksi Hari Ini";
                    } elseif (isset($_SESSION['buttonBulanIni']) && $_SESSION['buttonBulanIni'] == true) {
                        echo "Transaksi Bulan Ini";
                    } elseif (isset($_SESSION['buttonTahunIni']) && $_SESSION['buttonTahunIni'] == true) {
                        echo "Transaksi Tahun Ini";
                    } elseif (isset($_SESSION['buttonKeseluruhan']) && $_SESSION['buttonKeseluruhan'] == true) {
                        echo "Transaksi Keseluruhan";
                    }


                    ?>
                    </h2>
                </div>

                    <?php
                    if ($role == 2):
                        if (isset($_SESSION['buttonHariIni']) && $_SESSION['buttonHariIni'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

                            $namaPembeli = query("SELECT DISTINCT O.idPembeli, realName, uuidUser FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_siswa S WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPembeli = U.idUser AND U.idDetailUser = S.idDetailUser AND O.idPenjual = '$idUser' AND DATE(waktuOrder) = '$tanggal'");

                        } elseif (isset($_SESSION['buttonBulanIni']) && $_SESSION['buttonBulanIni'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

                            $namaPembeli = query("SELECT DISTINCT O.idPembeli, realName, uuidUser FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_siswa S WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPembeli = U.idUser AND U.idDetailUser = S.idDetailUser AND O.idPenjual = '$idUser' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'");

                        } elseif (isset($_SESSION['buttonTahunIni']) && $_SESSION['buttonTahunIni'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

                            $namaPembeli = query("SELECT DISTINCT O.idPembeli, realName, uuidUser FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_siswa S WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPembeli = U.idUser AND U.idDetailUser = S.idDetailUser AND O.idPenjual = '$idUser' AND YEAR(waktuOrder) = '$tahun'");

                        } elseif (isset($_SESSION['buttonKeseluruhan']) && $_SESSION['buttonKeseluruhan'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser'")[0]['total'];

                            $namaPembeli = query("SELECT DISTINCT O.idPembeli, realName, uuidUser FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_siswa S WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPembeli = U.idUser AND U.idDetailUser = S.idDetailUser AND O.idPenjual = '$idUser'");

                        }


                        ?>
        <div class="relative overflow-x-auto">

        <table class="w-full text-sm text-left text-gray-500  dark:text-gray-400">
        <?php foreach ($namaPembeli as $PembeliSingle):
            $idPembeliSingle = $PembeliSingle["idPembeli"];
            $uuidPembeliSingle = $PembeliSingle["uuidUser"];
            if (isset($_GET["trx-" . $uuidPembeliSingle])) {
                $_SESSION['Sessiontrx-' . $uuidPembeliSingle] = $_GET["trx-" . $uuidPembeliSingle];
            } else {
                $_SESSION['Sessiontrx-' . $uuidPembeliSingle] = 1;
            }

            if (isset($_SESSION['buttonHariIni']) && $_SESSION['buttonHariIni'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND DATE(waktuOrder) = '$tanggal'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPembeliSingle])) ? $_SESSION["Sessiontrx-" . $uuidPembeliSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND DATE(waktuOrder) = '$tanggal' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

            } elseif (isset($_SESSION['buttonBulanIni']) && $_SESSION['buttonBulanIni'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPembeliSingle])) ? $_SESSION["Sessiontrx-" . $uuidPembeliSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

            } elseif (isset($_SESSION['buttonTahunIni']) && $_SESSION['buttonTahunIni'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND YEAR(waktuOrder) = '$tahun'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPembeliSingle])) ? $_SESSION["Sessiontrx-" . $uuidPembeliSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND YEAR(waktuOrder) = '$tahun' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

            } elseif (isset($_SESSION['buttonKeseluruhan']) && $_SESSION['buttonKeseluruhan'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPembeliSingle])) ? $_SESSION["Sessiontrx-" . $uuidPembeliSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND idPembeli = '$idPembeliSingle'")[0]['total'];
            }







            ?>
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 w-full">
                            <tr>
                                <th colspan="5" class="p-5">
                                </th>
                            </tr>
                            <tr class="">
                                <th colspan="5" class="text-center text-2xl bg-slate-300 font-bold">
                                <?= $PembeliSingle["realName"]; ?>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-2 py-3">
                                    Menu
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Harga
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Jumlah
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Total
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Waktu
                                </th>
                            </tr>
                            <tr>
                                <th colspan="5">
                                    <div class="border-t-2 border-dashed border-gray-400 w-full"></div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($dataPesanan as $oneView):
                                ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                        class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $oneView["namaMenu"]; ?>
                                        </th>
                                        <td class="px-2 py-4">
                                        <?= $oneView["hargaMenu"]; ?>
                                        </td>
                                        <input id="<?='harga' . $oneView['idMenu']; ?>" class="span8" type="hidden"
                                        value="<?= $oneView["hargaMenu"]; ?>" />
                                        <td class="px-2 py-4">
                                        <input id="<?='jumlahPesan' . $oneView['idMenu']; ?>" type="number" min="1"
                                            class="border border-gray-300 borderad rounded-lg w-16"
                                            name="<?='jumlahPesan' . $oneView['idMenu']; ?>" value="<?= $oneView["jumlahPesan"]; ?>"
                                            disabled>
                                        </td>
                                        <td class="px-2 py-4">
                                        <?= $oneView["total"]; ?>
                                        </td>
                                        <td class="px-2 py-4">
                                        <?= $oneView["waktuOrder"]; ?>
                                        </td>
                                    </tr>

                            <?php endforeach; ?>
                            <tr>
                                <td class="pt-2" align="center" colspan="5">
                                                            <!-- navigasi -->
                            <?php $banyakNavigasi = 2;

                            $awalNavigasi = (($halamanAktif - $banyakNavigasi) < 1) ? 1 : $halamanAktif - $banyakNavigasi;

                            $akhirNavigasi = (($halamanAktif + $banyakNavigasi) > $jumlahHalaman) ? $jumlahHalaman : $halamanAktif + $banyakNavigasi;

                            ?>
                            <nav aria-label="Page navigation example" class="w-full h-full flex justify-center pb-3">
                                        <ul class="inline-flex items-center -space-x-px">
                                <?php if ($jumlahHalaman > 1 && $jumlahData != 0): ?>
                                                                                    <?php if ($halamanAktif > $banyakNavigasi + 1 && $jumlahData != 0): ?>
                                                                                                                                <li><a href="?trx-<?= $uuidPembeliSingle ?>=1"
                                                                                                                                        class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                                                                                        Awal

                                                                                                                                    </a>
                                                                                                                                </li>
                                                                                                                                <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $halamanAktif - 1 ?>"
                                                                                                                                        class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                                                                                        <span class="sr-only">Previous</span>
                                                                                                                                        <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                            <path fill-rule="evenodd"
                                                                                                                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                                                                                                                clip-rule="evenodd"></path>
                                                                                                                                        </svg>
                                                                                                                                    </a>
                                                                                                                                </li>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($halamanAktif > 1 && $jumlahData != 0 && $halamanAktif <= $banyakNavigasi + 1): ?>
                                                                                                                                <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $halamanAktif - 1 ?>"
                                                                                                                                        class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                                                                                        <span class="sr-only">Previous</span>
                                                                                                                                        <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                            <path fill-rule="evenodd"
                                                                                                                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                                                                                                                clip-rule="evenodd"></path>
                                                                                                                                        </svg>
                                                                                                                                    </a>
                                                                                                                                </li>
                                                                                    <?php endif; ?>

                                                                                    <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++):
                                                                                        if ($i == $halamanAktif): ?>
                                                                                                                                                                            <?php if ($halamanAktif == 1): ?>
                                                                                                                                                                                                                        <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $i ?>"
                                                                                                                                                                                                                                class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 rounded-l-lg border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $i ?></a></li>
                                                                                                                                                                            <?php elseif ($halamanAktif >= $jumlahHalaman): ?>
                                                                                                                                                                                                                        <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $i ?>"
                                                                                                                                                                                                                                class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 rounded-r-lg border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $i ?></a></li>
                                                                                                                                                                            <?php else: ?>
                                                                                                                                                                                                                        <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $i ?>"
                                                                                                                                                                                                                                class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $i ?></a></li>
                                                                                                                                                                            <?php endif; ?>
                                                                                                                                <?php else: ?>
                                                                                                                                                                            <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $i ?>"
                                                                                                                                                                                    class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= $i ?></a></li>
                                                                                                                                <?php endif; ?>
                                                                                    <?php endfor; ?>

                                                                                    <?php if ($halamanAktif < $jumlahHalaman && $halamanAktif >= $jumlahHalaman - $banyakNavigasi): ?>
                                                                                                                                <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $halamanAktif + 1 ?>"
                                                                                                                                        class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                                                                                        <span class="sr-only">Next</span>
                                                                                                                                        <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                            <path fill-rule="evenodd"
                                                                                                                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                                                                                                clip-rule="evenodd"></path>
                                                                                                                                        </svg>
                                                                                                                                    </a>
                                                                                                                                </li>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($halamanAktif < $jumlahHalaman - $banyakNavigasi && $jumlahData != 0): ?>
                                                                                                                                <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $halamanAktif + 1 ?>"
                                                                                                                                        class="block py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                                                                                        <span class="sr-only">Next</span>
                                                                                                                                        <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                            <path fill-rule="evenodd"
                                                                                                                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                                                                                                clip-rule="evenodd"></path>
                                                                                                                                        </svg>
                                                                                                                                    </a>
                                                                                                                                </li>
                                                                                                                                <li><a href="?trx-<?= $uuidPembeliSingle ?>=<?= $jumlahHalaman ?>"
                                                                                                                                        class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                                                                                        Akhir</a>
                                                                                                                                </li>

                                                                                    <?php endif; ?>
                                        <?php endif; ?>

                                        </ul>
                                    </nav>



                                                                                                                                        </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td colspan="5" class="px-2 py-4">

                                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">Total Transaksi
                                    </h2>
                                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">
                                        Rp.
                                        <span id="spanTotalHarga"><?= number_format($totalPesanan, 0, ",", ".") ?></span>
                                    </h2>


                                </td>
                            </tr>


                        </tbody>                        
                <?php endforeach;

        ?>
                </table>
                <?php
                if ((empty($dataPesanan))) {
                    echo '<table class="w-full"><tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th colspan="5" scope="row"
            class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
            Belum ada pesanan
            </th>
            </tr></table>';
                } ?>
                </div>

                    <?php
                    else:
                        if ($role == 4) {
                            $idUser = $idAnak;
                        }

                        if (isset($_SESSION['buttonHariIni']) && $_SESSION['buttonHariIni'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

                            $NamaPenjual = query("SELECT DISTINCT O.idPenjual, realName, uuidUser, namaToko FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_penjual J WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = U.idUser AND U.idDetailUser = J.idDetailUser AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'");

                        } elseif (isset($_SESSION['buttonBulanIni']) && $_SESSION['buttonBulanIni'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

                            $NamaPenjual = query("SELECT DISTINCT O.idPenjual, realName, uuidUser, namaToko FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_penjual J WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = U.idUser AND U.idDetailUser = J.idDetailUser AND idPembeli = '$idUser' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'");

                        } elseif (isset($_SESSION['buttonTahunIni']) && $_SESSION['buttonTahunIni'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

                            $NamaPenjual = query("SELECT DISTINCT O.idPenjual, realName, uuidUser, namaToko FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_penjual J WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = U.idUser AND U.idDetailUser = J.idDetailUser AND idPembeli = '$idUser' AND YEAR(waktuOrder) = '$tahun'");

                        } elseif (isset($_SESSION['buttonKeseluruhan']) && $_SESSION['buttonKeseluruhan'] == true) {
                            $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser'")[0]['total'];

                            $NamaPenjual = query("SELECT DISTINCT O.idPenjual, realName, uuidUser, namaToko FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_penjual J WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = U.idUser AND U.idDetailUser = J.idDetailUser AND idPembeli = '$idUser'");

                        }


                        ?>
    <div class="relative overflow-x-auto">

        <table class="w-full text-sm text-left text-gray-500  dark:text-gray-400">
        <?php foreach ($NamaPenjual as $penjualSingle):
            $idPenjualSingle = $penjualSingle["idPenjual"];
            $uuidPenjualSingle = $penjualSingle["uuidUser"];
            if (isset($_GET["trx-" . $uuidPenjualSingle])) {
                $_SESSION['Sessiontrx-' . $uuidPenjualSingle] = $_GET["trx-" . $uuidPenjualSingle];
            } else {
                $_SESSION['Sessiontrx-' . $uuidPenjualSingle] = 1;
            }

            if (isset($_SESSION['buttonHariIni']) && $_SESSION['buttonHariIni'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPenjualSingle])) ? $_SESSION["Sessiontrx-" . $uuidPenjualSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

            } elseif (isset($_SESSION['buttonBulanIni']) && $_SESSION['buttonBulanIni'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPenjualSingle])) ? $_SESSION["Sessiontrx-" . $uuidPenjualSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND MONTH(waktuOrder) = '$bulan' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

            } elseif (isset($_SESSION['buttonTahunIni']) && $_SESSION['buttonTahunIni'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND YEAR(waktuOrder) = '$tahun'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPenjualSingle])) ? $_SESSION["Sessiontrx-" . $uuidPenjualSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND YEAR(waktuOrder) = '$tahun' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND YEAR(waktuOrder) = '$tahun'")[0]['total'];

            } elseif (isset($_SESSION['buttonKeseluruhan']) && $_SESSION['buttonKeseluruhan'] == true) {
                $jumlahData = count(query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle'"));
                $jumlahDataPerHalaman = 5;
                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
                $halamanAktif = (isset($_SESSION["Sessiontrx-" . $uuidPenjualSingle])) ? $_SESSION["Sessiontrx-" . $uuidPenjualSingle] : 1;
                $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

                $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, waktuOrder, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' ORDER BY waktuOrder DESC, namaMenu LIMIT $awalData, $jumlahDataPerHalaman");

                $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle'")[0]['total'];
            }







            ?>
                    <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 w-full">
                        <tr>
                        <th colspan="5" class="p-5">
                        </th>
                        </tr>
                        <tr class="">
                        <th colspan="5" class="text-center text-2xl bg-slate-300 font-bold">
                        <?= $penjualSingle["namaToko"]; ?>
                        </th>
                        </tr>
                        <tr>
                        <th scope="col" class="px-2 py-3">
                        Menu
                        </th>
                        <th scope="col" class="px-2 py-3">
                        Harga
                        </th>
                        <th scope="col" class="px-2 py-3">
                        Jumlah
                        </th>
                        <th scope="col" class="px-2 py-3">
                        Total
                        </th>
                        <th scope="col" class="px-2 py-3">
                        Waktu
                        </th>
                        </tr>
                        <tr>
                        <th colspan="5">
                        <div class="border-t-2 border-dashed border-gray-400 w-full"></div>
                        </th>
                        </tr>
                    </thead>

        <tbody>
        <?php foreach ($dataPesanan as $oneView):
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row"
            class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            <?= $oneView["namaMenu"]; ?>
            </th>
            <td class="px-2 py-4">
            <?= $oneView["hargaMenu"]; ?>
            </td>
            <input id="<?='harga' . $oneView['idMenu']; ?>" class="span8" type="hidden"
            value="<?= $oneView["hargaMenu"]; ?>" />
            <td class="px-2 py-4">
            <input id="<?='jumlahPesan' . $oneView['idMenu']; ?>" type="number" min="1"
            class="border border-gray-300 borderad rounded-lg w-16"
            name="<?='jumlahPesan' . $oneView['idMenu']; ?>" value="<?= $oneView["jumlahPesan"]; ?>"
            disabled>
            </td>
            <td class="px-2 py-4">
            <?= $oneView["total"]; ?>
            </td>
            <td class="px-2 py-4">
            <?= $oneView["waktuOrder"]; ?>
            </td>
            </tr>

        <?php endforeach;

        ?>
        <tr>
        <td class="pt-2" align="center" colspan="5">
        <!-- navigasi -->
        <?php $banyakNavigasi = 2;

        $awalNavigasi = (($halamanAktif - $banyakNavigasi) < 1) ? 1 : $halamanAktif - $banyakNavigasi;

        $akhirNavigasi = (($halamanAktif + $banyakNavigasi) > $jumlahHalaman) ? $jumlahHalaman : $halamanAktif + $banyakNavigasi;

        ?>
        <nav aria-label="Page navigation example" class="w-full h-full flex justify-center pb-3">
        <ul class="inline-flex items-center -space-x-px">
        <?php if ($jumlahHalaman > 1 && $jumlahData != 0): ?>
            <?php if ($halamanAktif > $banyakNavigasi + 1 && $jumlahData != 0): ?>
                <li><a href="?trx-<?= $uuidPenjualSingle ?>=1"
                class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                Awal

                </a>
                </li>
                <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $halamanAktif - 1 ?>"
                class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <span class="sr-only">Previous</span>
                <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"></path>
                </svg>
                </a>
                </li>
            <?php endif; ?>

            <?php if ($halamanAktif > 1 && $jumlahData != 0 && $halamanAktif <= $banyakNavigasi + 1): ?>
                <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $halamanAktif - 1 ?>"
                class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <span class="sr-only">Previous</span>
                <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"></path>
                </svg>
                </a>
                </li>
            <?php endif; ?>

            <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++):
                if ($i == $halamanAktif): ?>
                    <?php if ($halamanAktif == 1): ?>
                        <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $i ?>"
                        class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 rounded-l-lg border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $i ?></a></li>
                    <?php elseif ($halamanAktif >= $jumlahHalaman): ?>
                        <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $i ?>"
                        class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 rounded-r-lg border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $i ?></a></li>
                    <?php else: ?>
                        <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $i ?>"
                        class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $i ?></a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $i ?>"
                    class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= $i ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($halamanAktif < $jumlahHalaman && $halamanAktif >= $jumlahHalaman - $banyakNavigasi): ?>
                <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $halamanAktif + 1 ?>"
                class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <span class="sr-only">Next</span>
                <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"></path>
                </svg>
                </a>
                </li>
            <?php endif; ?>

            <?php if ($halamanAktif < $jumlahHalaman - $banyakNavigasi && $jumlahData != 0): ?>
                <li><a href="?trx-<?= $uuidPenjualSingle ?>=<?= $halamanAktif + 1 ?>"
                class="block py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <span class="sr-only">Next</span>
                <svg aria-hidden="true" class="w-[1.20rem] h-[1.20rem]" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"></path>
                    </svg>
                    </a>
                    </li>
                    <li>
                        <a href="?trx-<?= $uuidPenjualSingle ?>=<?= $jumlahHalaman ?>"
                    class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Akhir</a>
                    </li>

                        <?php endif; ?>
                    <?php endif; ?>

                    </ul>
                </nav>



                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td colspan="5" class="px-2 py-4">

                                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">Total Transaksi
                                    </h2>
                                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">
                                        Rp.
                                        <span id="spanTotalHarga"><?= number_format($totalPesanan, 0, ",", ".") ?></span>
                                    </h2>


                            </td>
                        </tr>


                </tbody>
            <?php endforeach;

        ?>
            </table>
            <?php
            if ((empty($dataPesanan))) {
                echo '<table class="w-full"><tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
<th colspan="5" scope="row"
class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
Belum ada pesanan
</th>
</tr></table>';
            } ?>
    </div>
                                    <?php

                    endif; ?>
                <div>
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-5">Total Pengeluaran
                    </h2>
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">
                        Rp.
                        <span id="spanTotalHarga"><?= number_format($Pengeluaran, 0, ",", ".") ?></span>
                    </h2>
                    <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />

                    <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
                    <div class="w-full grid grid-cols-1 items-center justify-items-center">
                        <div id="qrPane" class="grid grid-cols-1 justify-items-center gap-3 p-5 w-64 items-center"></div>
                    </div>

                
                </div>


            </form>
        </div>


    </div>

    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>