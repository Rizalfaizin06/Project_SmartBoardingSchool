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


// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldoUser);


$idPenjual = $_POST['idPenjual'];
$_SESSION['idPenjual'] = $idPenjual;


if (is_numeric($idPenjual) == false) {
    // echo $idPenjual;
    echo '<div>
    <h2 class="text-2xl font-poppins font-bold underline mb-2 text-center">QR Code Salah
    </h2>
</div>
<button onClick="window.location.reload();"
    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300" id="buttonUlang" name="buttonUlang">Ulangi</button>';
    return false;
}

$querydOrder = query("SELECT idOrder FROM tbl_order WHERE idPenjual = $idPenjual AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");

if (!empty($querydOrder)) {
    $idOrder = $querydOrder[0]["idOrder"];
    // var_dump($idOrder);

    $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
    // var_dump($dataOrderan);

    $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
    // var_dump($totalHarga);
} else {
    // echo $idPenjual;
    echo '<div>
    <h2 class="text-2xl font-poppins font-bold underline mb-2 text-center">Belum ada pembayaran
    </h2>
</div>
<button onClick="window.location.reload();"
    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300" id="buttonUlang" name="buttonUlang">Ulangi</button>';
    return false;
}

$pembayaran = $querydOrder;





$dataPesanan = query("SELECT * FROM tbl_pesan P, tbl_menu M WHERE (P.idMenu = M.idMenu) AND idOrder = 0");


$pesanan = array();
// $dataPesananSingle = "SELECT * FROM tbl_pesan WHERE idOrder = 0";
// $queryDataPesananSingle = mysqli_query($koneksi, $dataPesananSingle);
// while($readData = mysqli_fetch_array($queryDataPesananSingle)){
//   array_push($pesanan, $readData['idMenu']);
// }
foreach ($dataPesanan as $oneView) {
    array_push($pesanan, $oneView['idMenu']);
}
?>


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
<div class="grid grid-cols-1">


    <div
        class="static md:sticky md:top-32 block m-3 p-3 bg-white border border-gray-200 rounded-xl shadow overflow-hidden">
        <form action="" method="post">

            <div>
                <h2 class="text-2xl font-poppins font-bold underline mb-2 text-center">Total Tagihan
                </h2>
            </div>

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase   dark:bg-gray-700 dark:text-gray-400">
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
                        </tr>
                        <tr>
                            <th colspan="4">
                                <div class="border-t-2 border-gray-400 w-full"></div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($dataOrderan as $oneView):
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
                                        name="<?='jumlahPesan' . $oneView['idMenu']; ?>"
                                        value="<?= $oneView["jumlahPesan"]; ?>" disabled>
                                </td>
                                <td class="px-2 py-4">
                                    <?= $oneView["total"]; ?>
                                </td>
                            </tr>

                        <?php endforeach;
                        if ((empty($dataOrderan))) {
                            echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th colspan="4" scope="row"
                                            class="px-2 py-4 font-medium text-center text-red-500 whitespace-nowrap dark:text-white">
                                            Belum ada pesanan
                                        </th>
                                    </tr>';
                        }
                        ?>


                    </tbody>
                </table>
            </div>



            <div>
                <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">Bayar Sebesar
                </h2>
                <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">
                    Rp.
                    <span id="spanTotalHarga">
                        <?= number_format($totalHarga, 0, ",", ".") ?>
                    </span>
                </h2>
                <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />

                <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">

                <button
                    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300"
                    type="submit" id="buttonBayar" name="buttonBayar">Bayar</button>
                <a href="index.php"
                    class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300"
                    type="submit" id="buttonCancel" name="buttonCancel">Back</a>



            </div>
        </form>
    </div>