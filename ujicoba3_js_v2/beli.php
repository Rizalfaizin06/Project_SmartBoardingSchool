<?php
session_start();
require 'fungsiAdmin.php';
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];
$saldoUser = $_SESSION["saldoUser"];
// $menu = query("SELECT * FROM tbl_menu");

// if (isset($_POST['buttonPesan'])) {
//     $idMenu = $_POST['idMenu'];
//     // $jumlahPesan = $_POST['jumlahPesan'];
//     // query("INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);");
//     $query = "INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);";

//     mysqli_query($koneksi, $query);

// }




// if (isset($_POST['buttonHapus'])) {
//     $idMenu = $_POST['idMenu'];
//     $query = "DELETE FROM tbl_pesan WHERE idMenu = '$idMenu'";

//     mysqli_query($koneksi, $query);

// }




// if (isset($_POST['buttonOrder'])) {
//     // $idPembeli = $_POST['idPembeli'];
//     $waktuOrder = date("Y-m-d H:i:s");

//     $query = "INSERT INTO tbl_order (idOrder, waktuOrder, statusOrder) VALUES (NULL, '$waktuOrder', 'belum')";
//     mysqli_query($koneksi, $query);

//     $querydOrder = query("SELECT idOrder FROM tbl_order ORDER BY idOrder DESC LIMIT 1");
//     $idOrder = $querydOrder[0]["idOrder"];
//     var_dump($idOrder);



//     $dataPesanan = query("SELECT * FROM tbl_pesan WHERE idOrder = 0");

//     foreach($dataPesanan as $oneView) {
//     $idMenu = $oneView['idMenu'];
//     $jumlahPesan = $_POST['jumlahPesan'.$idMenu];
//     $queryUbahJumlah = "UPDATE tbl_pesan SET jumlahPesan = $jumlahPesan, idOrder = $idOrder WHERE idOrder = 0 AND idMenu = $idMenu";
//     mysqli_query($koneksi, $queryUbahJumlah);
//     }
//     // SELECT hargaMenu, jumlahPesan, hargaMenu * jumlahPesan AS total FROM tbl_pesan INNER JOIN tbl_menu ON tbl_pesan.idMenu = tbl_menu.idMenu;
//     header("Location: anotherDirectory/anotherFile.php");

// }





// $dataPesanan = query("SELECT * FROM tbl_pesan WHERE idOrder = 0");


// $pesanan = array();
// // $dataPesananSingle = "SELECT * FROM tbl_pesan WHERE idOrder = 0";
// // $queryDataPesananSingle = mysqli_query($koneksi, $dataPesananSingle);
// // while($readData = mysqli_fetch_array($queryDataPesananSingle)){
// //   array_push($pesanan, $readData['idMenu']);
// // }
// foreach($dataPesanan as $oneView) {
//     array_push($pesanan, $oneView['idMenu']);
// }



// Scann ID Penjual
$idPenjual = 1;





$querydOrder = query("SELECT idOrder FROM tbl_order WHERE statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
if (!empty($querydOrder)) {
    $idOrder = $querydOrder[0]["idOrder"];
    var_dump($idOrder);

    $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
    var_dump($dataOrderan);

    $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
    var_dump($totalHarga);
}

$pembayaran = $querydOrder;

// if (isset($_POST['buttonVerification'])) {


// }
// if (isset($_POST['buttonBayar'])) {

//     $query = "UPDATE tbl_users U, tbl_order O SET O.statusOrder = 1, saldoUser = 
//     CASE 
//         WHEN idUser = $idPenjual THEN saldoUser + $totalHarga
//         WHEN idUser = $idUser THEN saldoUser - $totalHarga
//         ELSE saldoUser
//     END WHERE U.idUser IN ($idPenjual, $idUser) AND idOrder = $idOrder;";
//     mysqli_query($koneksi, $query);
//     header("Location: index.php");
//     exit;
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/icon/bootstrap-icons.css">

</head>

<body>
    <div class="grid grid-cols-1 items-center justify-items-center h-full w-full">
        <?php if (empty($pembayaran)): ?>
            <div class="container">
                <h3>Pembayaran Berhasil</h3>
                <script>
                    setTimeout(function () {
                        window.location.href = "index.php";
                    }, 2000); 
                </script>
            </div>

        <?php else: ?>
            <!-- <div class="container">
                    <?php
                    foreach ($menu as $oneView):
                        ?>
                                <div class="card shadow p-3 mt-3 mb-3 w-4">
                                    <form action="" method="post">
                                    <h3><?= $oneView["namaMenu"]; ?></h3>
                                    <h3><?= $oneView["hargaMenu"]; ?></h3>
                                            <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
                                    <?php

                                    if (in_array($oneView["idMenu"], $pesanan)): ?>
                                                    <button class="btn btn-secondary w-25" type="submit" disabled>Sudah dipesan</button>
                                        <?php else: ?>
                                                    <button class="btn btn-outline-dark w-25" type="submit" id="button-pesan" name="buttonPesan">Pesan</button>

                                        <?php endif; ?>
                                        </form>
            
                                </div>
                    <?php endforeach;
                    if (!empty($idOrder)):
                        ?> -->

                <form action="" method="post">
                    <div class="card shadow p-3 mt-3 mb-3 w-4">
                        <table class="table" id="tableLogData">
                            <thead class="table-light">
                                <tr>
                                    <!-- <th>No.</th> -->
                                    <th>Menu</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php foreach ($dataOrderan as $oneView):
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $oneView["namaMenu"]; ?>
                                            <!-- <input id="<?='harga' . $oneView['idMenu']; ?>" class="span8" type="hidden" value="50000"/> -->
                                        </td>
                                        <td>
                                            <?= $oneView["hargaMenu"]; ?>
                                        </td>
                                        <td>
                                            <?= $oneView["jumlahPesan"]; ?>
                                        </td>
                                        <td>
                                            <?= $oneView["total"]; ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                ?>
                            </tbody>
                        </table>
                        <div class="container">
                            <h3>Total Harga : Rp. <span id="spanTotalHarga">
                                    <?= $totalHarga ?>
                                </span></h3>

                            <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />
                        </div>
                        <input type="hidden" name="idUser" value="<?= $idUser; ?>">
                        <h3>ID PENJUAL :
                            <?= $idUser ?>
                        </h3>
                        <button class="btn btn-outline-dark w-25" type="submit" id="buttonVerification"
                            name="buttonVerification">Verification</button>
                    </div>
                </form>
            <?php endif;
                    ?>
        </div>

    <?php endif; ?>
    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- <script type="text/javascript">
    function operasi(){
        var pesan = new Array();
        var jumlah = new Array();
        var total = 0;
        for(var a = 0; a < 1000; a++){
        pesan[a] = $("#harga"+a).val();
        jumlah[a] = $("#jumlahPesan"+a).val();
        } 
        for(var a = 0; a < 1000; a++){
        if(pesan[a] == null || pesan[a] == ""){
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
    </script> -->
</body>

</html>