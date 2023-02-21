<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}


if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$errorMessage = $_SESSION["errorMessage"];
$_SESSION["currentPage"] = "pay";
$idUser = $_SESSION["idUser"];

$queryUser = query("SELECT * FROM tbl_users WHERE idUser = '$idUser'")[0];
$role = $queryUser["role"];


if ($role == 1) {
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
    $Pengeluaran = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_order O, tbl_pesan P, tbl_menu M WHERE O.idOrder = P.idOrder AND P.idMenu = M.idMenu AND idPembeli = '$idUser' AND DATE(waktuOrder) = '$tanggal'")[0]['total'];
    $sisaLimit = $totalLimit - $Pengeluaran;
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


if (isset($_POST['buttonBayar'])) {
    $idPenjual = $_SESSION["idPenjual"];
    $pembayaran = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idPenjual' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
    $idOrder = $pembayaran[0]["idOrder"];
    var_dump($idOrder);

    $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
    var_dump($dataOrderan);

    $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
    // var_dump($totalHarga);
    if ($totalHarga > $totalLimit) {
        header("Location: index.php");
        exit;
    }

    // $query = "UPDATE tbl_users U, tbl_order O SET O.statusOrder = 1, saldoUser = 
    //     CASE 
    //         WHEN idUser = $idPenjual THEN saldoUser + $totalHarga
    //         WHEN idUser = $idUser THEN saldoUser - $totalHarga
    //         ELSE saldoUser
    //     END WHERE U.idUser IN ($idPenjual, $idUser) AND idOrder = $idOrder;";
    // mysqli_query($koneksi, $query);


    // START OLD METHOD

    // $query = "UPDATE tbl_users U, tbl_penjual P SET saldo = saldo + $totalHarga WHERE U.idDetailUser = P.idDetailUser AND idUser = $idPenjual";
    // mysqli_query($koneksi, $query);
    // $query = "UPDATE tbl_users U, tbl_siswa S SET saldo = saldo - $totalHarga WHERE U.idDetailUser = S.idDetailUser AND idUser = $idUser";
    // mysqli_query($koneksi, $query);
    // $query = "UPDATE tbl_order SET statusOrder = 1, idPembeli = $idUser WHERE idOrder = $idOrder;";
    // mysqli_query($koneksi, $query);

    // END OLD METHOD

    //memulai transaction
    mysqli_autocommit($koneksi, false);

    try {
        //menambah saldo pengguna penerima
        $sql = "UPDATE tbl_users U, tbl_penjual P SET saldo = saldo + $totalHarga WHERE U.idDetailUser = P.idDetailUser AND idUser = $idPenjual";
        mysqli_query($koneksi, $sql);

        //mengurangi saldo pengguna pengirim
        $sql = "UPDATE tbl_users U, tbl_siswa S SET saldo = saldo - $totalHarga WHERE U.idDetailUser = S.idDetailUser AND idUser = $idUser";
        mysqli_query($koneksi, $sql);

        //menyelesaikan orderan
        $sql = "UPDATE tbl_order SET statusOrder = 1, idPembeli = $idUser WHERE idOrder = $idOrder";
        mysqli_query($koneksi, $sql);

        //commit transaction jika operasi transfer berhasil
        mysqli_commit($koneksi);

        // echo "Transfer saldo berhasil!";
    } catch (Exception $e) {
        //rollback transaction jika terjadi kesalahan pada operasi transfer
        mysqli_rollback($koneksi);
        // echo "Transfer saldo gagal: " . $e->getMessage();
    }

    //aktifkan kembali mode autocommit
    mysqli_autocommit($koneksi, true);

    $_SESSION["idPenjual"] = '';
    header("Location: index.php");
    exit;
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
        <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar" class="object-cover rounded-full h-24 w-24">
        <h3 class="text-xl font-poppins font-bold text-white">
            <?= $realName; ?>
        </h3>
        <h3 class="font-poppins font-bold text-white">
            <?="Rp " . number_format($saldo, 0, ",", ".") ?>
        </h3>
        <!-- <div class=" w-full grid grid-cols-1 justify-items-center">
            <button
                class="px-4 py-2 mt-2 text-sm font-medium text-center text-primary bg-white rounded-lg hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300">
                <div class="grid grid-cols-2 h-10 items-center justify-items-center">
                    <img src="assets/icons/topUp.png" alt="" class="h-6">
                    <h3 class="text-md font-poppins font-bold px-1">
                        Top Up
                    </h3>
                </div>
            </button>
        </div> -->
    </div>


    <div class="grid grid-cols-1 justify-items-center w-full gap-3 p-5" id="allContent">

        <h3 id="result" class="font-poppins font-bold">
            <?= $errorMessage; ?>
        </h3>



        <a href="index.php" class="px-7 py-3 rounded-lg bg-primary hover:bg-opacity-80">


            <span class="text-sm font-poppins font-bold text-white">Back</span>
        </a>
    </div>



    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>