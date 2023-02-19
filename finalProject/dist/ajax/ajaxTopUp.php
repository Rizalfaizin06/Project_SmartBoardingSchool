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
    $queryUser = query("SELECT * FROM tbl_users U, tbl_admin P WHERE U.idDetailUser = P.idDetailUser AND idUser = '$idUser'")[0];
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
} else {

}



$idPenerima = $_POST['idPenerima'];
$_SESSION['idPenerima'] = $idPenerima;

if (is_numeric($idPenerima) == false) {
    return false;
}

$queryCheckUser = query("SELECT * FROM tbl_users WHERE idUser = $idPenerima");

if (!empty($queryCheckUser)) {
    $realName = $queryCheckUser[0]["realName"];
    // var_dump($idOrder);

    echo $realName;
} else {

    return false;
}