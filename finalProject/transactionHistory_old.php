<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}


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





// $querydOrder = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idUser' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");

// if (!empty($querydOrder)) {
//     $idOrder = $querydOrder[0]["idOrder"];
//     // var_dump($idOrder);

//     $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'");
//     // var_dump($dataOrderan);

//     $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
//     // var_dump($totalHarga);
// }

// $pembayaran = $querydOrder;





$logTransaksi = query("SELECT * FROM tbl_log WHERE DATE(waktuTransfer) = '$tanggal' ORDER BY idLog DESC");


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

    <?php //include 'dist/template/navbar.php'; ?>
    <?php
    // $current_dir = __DIR__;
    // // echo $current_dir;
    
    // $delimiter = DIRECTORY_SEPARATOR;
    
    // $array = explode($delimiter, $current_dir);
    // // var_dump($array);
    // // Loop melalui array untuk mencari kata "css"
    // $index = null;
    // foreach ($array as $key => $value) {
    //     if ($value == "finalProject") {
    //         $index = $key + 1;
    //         break;
    //     }
    // }
    
    // // Memotong array dari awal hingga kata "css"
    // $slice = array_slice($array, 0, $index);
    
    // // Menggabungkan kembali potongan array menjadi string
    // $result = implode($delimiter, $slice);
    
    // echo $result;
    ?>
    <div class="p-3 grid grid-cols-1" id="allContent">


        <div
            class="static md:sticky md:top-32 block m-3 p-3 bg-white border border-gray-200 rounded-xl shadow overflow-hidden">
            <form action="" method="post">

                <div>
                    <h2 class="text-2xl font-poppins font-bold underline text-center">Transaksi Hari Ini
                    </h2>
                </div>
<?php if ($role == 1): ?>
    <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-3">
                                    Pengirim
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Penerima
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Jumlah
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    Waktu
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    <div class="border-t-2 border-gray-400 w-full"></div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($logTransaksi as $oneView):
                                ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $oneView["uuidPengirim"]; ?>
                                    </th>
                                    <td class="px-2 py-4">
                                        <?= $oneView["uuidPenerima"]; ?>
                                    </td>
                                    
                                    <td class="px-2 py-4">
                                    <?= $oneView["jumlahTransfer"]; ?>
                                    </td>
                                    
                                    <td class="px-2 py-4">
                                    <?= $oneView["waktuTransfer"]; ?>
                                    </td>
                                </tr>

                            <?php endforeach;
                            
                            ?>


                        </tbody>
                    </table>
                </div>



                <!-- <div>
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">Total Transaksi
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
                </div> -->
<?php elseif ($role == 2): ?>
    <?php 
        $NamaPembeli = query("SELECT DISTINCT O.idPembeli, realName FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_siswa S WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPembeli = U.idUser AND U.idDetailUser = S.idDetailUser AND O.idPenjual = '$idUser' AND DATE(waktuOrder) = '$tanggal'");

        
        ?>
                <div class="relative overflow-x-auto">
                
                    <table class="w-full text-sm text-left text-gray-500  dark:text-gray-400">
                    <?php foreach ($NamaPembeli as $PembeliSingle):
                    $idPembeliSingle =  $PembeliSingle["idPembeli"];


                    $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND O.idPembeli = '$idPembeliSingle' AND DATE(waktuOrder) = '$tanggal'");
                    
                    $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = '$idUser' AND O.idPembeli = '$idPembeliSingle' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];
                    ?>
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 w-full">
                            <tr>
                                <th colspan="4" class="p-5">
                                </th>
                            </tr>
                            <tr class="">
                                <th colspan="4" class="text-center text-2xl bg-slate-300 font-bold">
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
                                    Hapus
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">
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
                                        <input id="<?='jumlahPesan' . $oneView['idMenu']; ?>" type="number"  min="1"
                                            class="border border-gray-300 borderad rounded-lg w-16"
                                            name="<?='jumlahPesan' . $oneView['idMenu']; ?>" value="<?= $oneView["jumlahPesan"]; ?>"
                                            disabled>
                                    </td>
                                    <td class="px-2 py-4">
                                    <?= $oneView["total"]; ?>
                                    </td>
                                </tr>
                                
                            <?php endforeach;
                            
                            ?>

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    
                                    <td colspan="4" class="px-2 py-4">
                                        
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
                                <th colspan="4" scope="row"
                                    class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
                                    Belum ada pesanan
                                </th>
                            </tr></table>';
                    }?>
                </div>



                <div>
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-5">Total Pemasukan
                    </h2>
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">
                        Rp.
                        <span id="spanTotalHarga"><?= number_format($pemasukan, 0, ",", ".") ?></span>
                    </h2>
                    <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />

                    <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
                    <div class="w-full grid grid-cols-1 items-center justify-items-center">
                        <div id="qrPane" class="grid grid-cols-1 justify-items-center gap-3 p-5 w-64 items-center"></div>
                    </div>

                
                </div>
<?php elseif ($role == 3): ?>
        <?php 
        $NamaPenjual = query("SELECT DISTINCT O.idPenjual, realName, namaToko FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_penjual J WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = U.idUser AND U.idDetailUser = J.idDetailUser AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'");

        
        ?>
                <div class="relative overflow-x-auto">
                
                    <table class="w-full text-sm text-left text-gray-500  dark:text-gray-400">
                    <?php foreach ($NamaPenjual as $penjualSingle):
                    $idPenjualSingle =  $penjualSingle["idPenjual"];


                    $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal'");
                    
                    $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];
                    ?>
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 w-full">
                            <tr>
                                <th colspan="4" class="p-5">
                                </th>
                            </tr>
                            <tr class="">
                                <th colspan="4" class="text-center text-2xl bg-slate-300 font-bold">
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
                                    Hapus
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">
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
                                </tr>
                                
                            <?php endforeach;
                            
                            ?>

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    
                                    <td colspan="4" class="px-2 py-4">
                                        
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
                                <th colspan="4" scope="row"
                                    class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
                                    Belum ada pesanan
                                </th>
                            </tr></table>';
                    }?>
                </div>



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
<?php else: ?>
    
    <?php 
        $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idAnak' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];

        $NamaPenjual = query("SELECT DISTINCT O.idPenjual, realName, namaToko FROM tbl_order O, tbl_pesan P, tbl_menu M, tbl_users U, tbl_penjual J WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND O.idPenjual = U.idUser AND U.idDetailUser = J.idDetailUser AND idPembeli = '$idAnak' AND DATE(waktuOrder) = '$tanggal'");

        
        ?>
                <div class="relative overflow-x-auto">
                
                    <table class="w-full text-sm text-left text-gray-500  dark:text-gray-400">
                    <?php foreach ($NamaPenjual as $penjualSingle):
                    $idPenjualSingle =  $penjualSingle["idPenjual"];


                    $dataPesanan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idAnak' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal'");
                    
                    $totalPesanan = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idAnak' AND O.idPenjual = '$idPenjualSingle' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];
                    ?>
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 w-full">
                            <tr>
                                <th colspan="4" class="p-5">
                                </th>
                            </tr>
                            <tr class="">
                                <th colspan="4" class="text-center text-2xl bg-slate-300 font-bold">
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
                                    Hapus
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">
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
                                </tr>
                                
                            <?php endforeach;
                            
                            ?>

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    
                                    <td colspan="4" class="px-2 py-4">
                                        
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
                                <th colspan="4" scope="row"
                                    class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
                                    Belum ada pesanan
                                </th>
                            </tr></table>';
                    }?>
                </div>



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
<?php endif; ?>
                


            </form>
        </div>


    </div>

    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>