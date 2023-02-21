<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}




if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "daftarMenu";

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




if (isset($_POST['buttonOrder'])) {
    // foreach ($_POST as $key => $value) {
    //     echo "Field " . htmlspecialchars($key) . " is " . htmlspecialchars($value) . "<br>";
    // }
    // die;
    // $idPembeli = $_POST['idPembeli'];
    $waktuOrder = date("Y-m-d H:i:s");

    $query = "INSERT INTO tbl_order (idOrder, idPenjual, idPembeli, waktuOrder, statusOrder) VALUES (NULL, '$idUser', 0, '$waktuOrder', 0)";
    mysqli_query($koneksi, $query);

    $querydOrder = query("SELECT idOrder FROM tbl_order WHERE statusOrder = 0 AND idPenjual = '$idUser' ORDER BY idOrder DESC LIMIT 1");
    $idOrder = $querydOrder[0]["idOrder"];
    var_dump($idOrder);



    $dataPesanan = query("SELECT * FROM tbl_pesan P, tbl_menu M WHERE P.idMenu = M.idMenu AND idOrder = 0 AND M.idPenjual = '$idUser'");
    // var_dump($dataPesanan);
    // die;
    foreach ($dataPesanan as $oneView) {
        $idMenu = $oneView['idMenu'];
        $jumlahPesan = $_POST['jumlahPesan' . $idMenu];
        $queryUbahJumlah = "UPDATE tbl_pesan SET jumlahPesan = $jumlahPesan, idOrder = $idOrder WHERE idOrder = 0 AND idMenu = $idMenu";
        mysqli_query($koneksi, $queryUbahJumlah);
    }
    // SELECT hargaMenu, jumlahPesan, hargaMenu * jumlahPesan AS total FROM tbl_pesan INNER JOIN tbl_menu ON tbl_pesan.idMenu = tbl_menu.idMenu;
    header("Location: waitingPayment.php");
    exit;

}





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
    <div class="p-3 grid grid-cols-1 md:grid-cols-2 md:gap-5" id="allContent">
        <div>
            <div class="grid gap-2 justify-items-center">

                <?php foreach ($category as $categorySingle):
                    $idCategory = $categorySingle['idCategory'];
                    $menu = query("SELECT * FROM tbl_menu WHERE idPenjual = '$idUser' AND idCategory = $idCategory"); ?>

                    <div class="grid grid-cols-2 gap-5 w-full">


                        <div class="justify-self-start col-span-2">
                            <h2 class="text-2xl font-poppins font-bold">
                                <?= $categorySingle["namaCategory"]; ?>
                            </h2>
                        </div>

                        <?php foreach ($menu as $oneView):

                            ?>

                            <div
                                class="block w-40 md:w-full md:max-w-xs h-full bg-white border border-gray-200 rounded-xl shadow overflow-hidden">
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

        <!-- <div>
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
                                                    <img src="assets/icons/trash.png" alt="" class="w-6">
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

        </div> -->

    </div>
    <!-- <div class="h-32">
sfs
  </div> -->


    <script src="dist/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">

        function insertDataPesan(idMenu) {
            $.ajax({
                url: "dist/function/insertDataPesan.php",
                type: "post",
                data: { insertDataPesan: idMenu },
                success: function (response) {
                    console.log(response);

                    $.ajax({
                        type: "GET",
                        url: "dist/ajax/ajaxEntry.php",
                        data: "",
                        success: function (data) {
                            $("#allContent").html(data);
                            operasi();
                        }
                    });
                }
            });
        }

        function deleteDataPesan(idMenu) {
            $.ajax({
                url: "dist/function/deleteDataPesan.php",
                type: "post",
                data: { deleteDataPesan: idMenu },
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: "GET",
                        url: "dist/ajax/ajaxEntry.php",
                        data: "",
                        success: function (data) {
                            $("#allContent").html(data);
                            operasi();
                        }
                    });

                }
            });
        }


        function operasi() {
            var pesan = new Array();
            var jumlah = new Array();

            var total = 0;
            for (var a = 0; a < 1000; a++) {
                pesan[a] = $("#harga" + a).val();
                jumlah[a] = $("#jumlahPesan" + a).val();

            }
            for (var a = 0; a < 1000; a++) {
                if (pesan[a] == null || pesan[a] == "") {
                    pesan[a] = 0;
                    jumlah[a] = 0;
                }
                total += Number(pesan[a] * jumlah[a]);
            }

            //alert(total);
            $("#spanTotalHarga").text(total);
            $("#tot").val(total);
        }

        operasi();
    </script>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>