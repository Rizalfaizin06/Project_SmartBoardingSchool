<?php
if (!session_id()) {
    session_start();
    require '../function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}




$category = query("SELECT DISTINCT namaCategory, tbl_category.idCategory FROM tbl_menu, tbl_category WHERE tbl_menu.idCategory = tbl_category.idCategory");
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];
$saldoUser = $_SESSION["saldoUser"];
$roleUser = $_SESSION["roleUser"];
// var_dump($category);

// if ($roleUser == 3) {
//     header("location: buyer.php");
//     exit;
// }
$pembayaran = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idUser' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
if (!empty($pembayaran)) {
    return false;
} else {
    echo '<div>
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