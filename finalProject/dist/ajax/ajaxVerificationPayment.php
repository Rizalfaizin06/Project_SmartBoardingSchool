<?php
if (!session_id()) {
    session_start();
    require '../function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}






$idUser = $_SESSION["idUser"];

$queryUser = query("SELECT * FROM tbl_users WHERE idUser = '$idUser'")[0];
$role = $queryUser["role"];


if ($role == 1) {


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
} else {

}

$category = query("SELECT DISTINCT namaCategory, C.idCategory FROM tbl_menu M, tbl_category C WHERE idPenjual = '$idUser' AND M.idCategory = C.idCategory");
// var_dump($category);

// if ($roleUser == 3) {
//     header("location: buyer.php");
//     exit;
// }
$pembayaran = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idUser' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
if (!empty($pembayaran)) {
    return false;
} else {
    echo '<div class="mt-10">
    <h2 class="text-2xl font-poppins font-bold underline mb-2 text-center">Pembayaran Berhasil
    </h2>
</div>
<a href="index.php"
    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300" id="buttonUlang" name="buttonUlang">Back</a>';
    return false;
}

// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldoUser);


if (is_numeric($idPenjual) == false) {
    echo $idPenjual;
    echo '<div>
    <h2 class="text-2xl font-poppins font-bold underline mb-2 text-center">Pembayaran Berhasil
    </h2>
</div>
<button onClick="window.location.reload();"
    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300" id="buttonUlang" name="buttonUlang">Ulangi</button>';
    return false;
}