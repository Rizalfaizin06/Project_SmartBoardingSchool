<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}


if (isset($_SESSION["waitingPayment"]) && $_SESSION["waitingPayment"] == false) {
    header("location: entryMenu.php");
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


if (isset($_POST['buttonCancel'])) {
    // $idPembeli = $_POST['idPembeli'];
    $querydOrder = query("SELECT idOrder FROM tbl_order WHERE idPenjual = $idUser AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
    $idOrder = $querydOrder[0]["idOrder"];
    var_dump($idOrder);

    $queryDeleteOrder ="DELETE FROM tbl_order WHERE idOrder = $idOrder;";
    mysqli_query($koneksi, $queryDeleteOrder);


    $queryDeletePesan ="DELETE FROM tbl_pesan WHERE idOrder = $idOrder;";
    mysqli_query($koneksi, $queryDeletePesan);
    // SELECT hargaMenu, jumlahPesan, hargaMenu * jumlahPesan AS total FROM tbl_pesan INNER JOIN tbl_menu ON tbl_pesan.idMenu = tbl_menu.idMenu;
    $_SESSION["waitingPayment"] = false;
    header("Location: entryMenu.php");
    exit;

}

// $idPenjual = 1;





$querydOrder = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idUser' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");

if (!empty($querydOrder)) {
    $idOrder = $querydOrder[0]["idOrder"];
    // var_dump($idOrder);

    $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
    // var_dump($dataOrderan);

    $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
    // var_dump($totalHarga);
}

$pembayaran = $querydOrder;






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
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">Menunggu pembayaran Sebesar
                    </h2>
                    <h2 class="text-xl font-poppins font-bold text-center mr-2 md:mr-8 mt-2">
                        Rp.
                        <span id="spanTotalHarga"><?= number_format($totalHarga, 0, ",", ".") ?></span>
                    </h2>
                    <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />

                    <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
                    <div class="w-full grid grid-cols-1 items-center justify-items-center">
                        <div id="qrPane" class="grid grid-cols-1 justify-items-center gap-3 p-5 w-64 items-center"></div>
                    </div>

                    <button class="px-4 py-2 mt-2 w-full text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300" type="submit" id="buttonCancel" name="buttonCancel">Batalkan Pesanan</button>


                </div>
            </form>
        </div>


    </div>
    <!-- <div class="h-32">
sfs
  </div> -->


    <script src="dist/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">

        jQuery.ajax({
            type: "GET",
            url: "dist/ajax/ajaxGenerateQR.php",
            data: "",
            success: function (data) {
                console.log(data);
                if (data) {
                    $("#qrPane").html(data);
                }
            }
        });


        setInterval(function () {
            
            jQuery.ajax({
                type: "GET",
                url: "dist/ajax/ajaxVerificationPayment.php",
                data: "",
                success: function (data) {
                    console.log(data);
                    if (data) {
                        $("#allContent").html(data);
                    }
                }
            });
        }, 1000);

        function insertDataPesan(idMenu) {
            $.ajax({
                url: "dist/function/insertDataPesan.php",
                type: "post",
                data: { insertDataPesan: idMenu },
                success: function (response) {
                    console.log(response);

                    $.ajax({
                        type: "GET",
                        url: "assets/ajax/ajaxIndex.php",
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
                        url: "assets/ajax/ajaxIndex.php",
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

    </script>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>