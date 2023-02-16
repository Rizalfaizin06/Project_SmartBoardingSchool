<?php
session_start();
require '../function/function.php';




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


$dataPesanan = query("SELECT * FROM tbl_pesan P, tbl_menu M WHERE (P.idMenu = M.idMenu) AND idOrder = 0 AND idPenjual = $idUser");


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


<div>
    <div class="grid gap-2 justify-items-center">

        <?php foreach ($category as $categorySingle):
            $idCategory = $categorySingle['idCategory'];
            $menu = query("SELECT * FROM tbl_menu WHERE idPenjual = '$idUser' AND idCategory = $idCategory"); ?>

            <div class="grid grid-cols-2 gap-5">


                <div class="justify-self-start col-span-2">
                    <h2 class="text-2xl font-poppins font-bold">
                        <?= $categorySingle["namaCategory"]; ?>
                    </h2>
                </div>

                <?php foreach ($menu as $oneView):

                    ?>

                    <div class="block w-40 md:w-full h-full bg-white border border-gray-200 rounded-xl shadow overflow-hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 h-full">
                            <img src="assets/images/<?= $oneView["gambarMenu"]; ?>" alt="esdgtsdf"
                                class="object-cover w-full h-36">
                            <div class="grid grid-cols-1 gap-0 p-2 h-full">

                                <h3 class="font-poppins font-bold">
                                    <?= $oneView["namaMenu"]; ?>
                                </h3>
                                <h3 class="font-poppins font-extrabold text-primary">
                                    <?="Rp " . number_format($oneView["hargaMenu"], 0, ",", ".") ?>
                                </h3>
                                <?php

                                if (in_array($oneView["idMenu"], $pesanan)): ?>
                                    <div class="h-fit grid grid-cols-1">

                                        <button
                                            class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg bg-opacity-50 focus:ring-4 focus:outline-none focus:ring-stone-303 align-bottom"
                                            disabled>Sudah dipesan</button>

                                    </div>
                                <?php else: ?>
                                    <div class="h-fit grid grid-cols-1">
                                        <button
                                            class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300 justify-self-end"
                                            onclick="insertDataPesan(<?= $oneView['idMenu']; ?>)">Pesan</button>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class=" border-t-2 border-gray-400 border-dashed w-full">
            </div>

        <?php endforeach; ?>

    </div>

</div>

<div>
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
                                Hapus
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">
                                <div class="border-t-2 border-gray-400 w-full"></div>
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
                                    <input id="<?='jumlahPesan' . $oneView['idMenu']; ?>" type="number"
                                        class="border border-gray-300 borderad rounded-lg w-16"
                                        name="<?='jumlahPesan' . $oneView['idMenu']; ?>" value="1"
                                        onchange="return operasi()">
                                </td>
                                <td class="px-2 py-4">
                                    <div class="px-1 py-1 w-8 text-sm font-medium text-center text-primary bg-primary rounded-lg hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300"
                                        id="buttonHapus" name="buttonHapus"
                                        onclick="deleteDataPesan(<?= $oneView['idMenu']; ?>)">
                                        <img src="assets/icon/trash.png" alt="" class="w-6">
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach;
                        if ((empty($dataPesanan))) {
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
                <h2 class="text-xl font-poppins font-bold text-right mr-2 md:mr-8 mt-2">Total :
                    Rp.
                    <span id="spanTotalHarga">0</span>
                </h2>
                <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />

                <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
                <?php if (empty($dataPesanan)): ?>
                    <button
                        class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg bg-opacity-50 focus:ring-4 focus:outline-none focus:ring-stone-300"
                        type="submit" id="buttonOrder" name="buttonOrder" disabled>Order</button>
                <?php else: ?>
                    <button
                        class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300"
                        type="submit" id="buttonOrder" name="buttonOrder">Order</button>
                <?php endif; ?>

            </div>
        </form>
    </div>

</div>