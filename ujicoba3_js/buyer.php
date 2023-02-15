<?php
session_start();
require 'fungsiAdmin.php';
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];
$saldoUser = $_SESSION["saldoUser"];
$result = mysqli_query($koneksi, "SELECT * FROM tbl_users WHERE idUser = '$idUser'");
    //cek username
    // var_dump($result);
if (mysqli_num_rows($result) === 1) {
    //cek password
    $row = mysqli_fetch_assoc($result);
    $_SESSION["saldoUser"] = $row['saldoUser'];

        
}
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
$idPenjual = "";



    
    $pembayaran = "";
    // if (!empty($querydOrder)) {
    //     $idOrder = $querydOrder[0]["idOrder"];
    //     var_dump($idOrder);
        
    //     $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
    //     var_dump($dataOrderan);

    //     $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
    //     var_dump($totalHarga);
    // }

    


    
 


    $error = "";
    if (isset($_POST['buttonScan'])) {
        $_SESSION["idPenjual"] = $_POST["idPenjual"];
        $idPenjual = $_SESSION["idPenjual"];
        var_dump("masuk");  
        
        $pembayaran = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idPenjual' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
        if (empty($pembayaran)) {
            $error = "Belum ada pembayaran yang harus dilakukan";
        } else {
            $idOrder = $pembayaran[0]["idOrder"];
            var_dump($idOrder);
            
            $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
            var_dump($dataOrderan);

            $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
            var_dump($totalHarga);
        }
    }
    
    if (isset($_POST['buttonBayar'])) {
        $idPenjual = $_SESSION["idPenjual"];
        $pembayaran = query("SELECT idOrder FROM tbl_order WHERE idPenjual = '$idPenjual' AND statusOrder = 0 ORDER BY idOrder DESC LIMIT 1");
        $idOrder = $pembayaran[0]["idOrder"];
        var_dump($idOrder);
        
        $dataOrderan = query("SELECT P.idMenu, namaMenu, hargaMenu, jumlahPesan, hargaMenu * jumlahPesan total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder");
        var_dump($dataOrderan);

        $totalHarga = query("SELECT SUM(hargaMenu * jumlahPesan) total FROM tbl_pesan P, tbl_order O, tbl_menu M WHERE (P.idOrder = O.idOrder AND P.idMenu = M.idMenu) AND P.idOrder = $idOrder")[0]["total"];
        var_dump($totalHarga);

        $query = "UPDATE tbl_users U, tbl_order O SET O.statusOrder = 1, saldoUser = 
        CASE 
            WHEN idUser = $idPenjual THEN saldoUser + $totalHarga
            WHEN idUser = $idUser THEN saldoUser - $totalHarga
            ELSE saldoUser
        END WHERE U.idUser IN ($idPenjual, $idUser) AND idOrder = $idOrder;";
        mysqli_query($koneksi, $query);
        $_SESSION["idPenjual"] = '';
        header("Location: index.php");
        exit;
    }
    
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
    <a href="logout.php">logout</a>
    <?php
    echo '<pre>'. var_dump($_SESSION) .'</pre>';
    ?>
    <!-- <div class="container">
        
    <?php
    echo '<pre>'. var_dump($_SESSION) .'</pre>';
    foreach ($menu as $oneView) :
    ?>
    <div class="card shadow p-3 mt-3 mb-3 w-4">
        <form action="" method="post">
        <h3><?= $oneView["namaMenu"]; ?></h3>
        <h3><?= $oneView["hargaMenu"]; ?></h3>
                <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
        <?php
        
        if(in_array($oneView["idMenu"], $pesanan)):?>
            <button class="btn btn-secondary w-25" type="submit" disabled>Sudah dipesan</button>
            <?php else:?>
            <button class="btn btn-outline-dark w-25" type="submit" id="button-pesan" name="buttonPesan">Pesan</button>

            <?php endif;?>
            </form>
        
    </div>
    <?php endforeach;


         ?> -->

    <?php 
    if (empty($pembayaran)) :?>
        <form action="" method="post">
        <div class="card shadow p-3 mt-3 mb-3 w-4 flex align-items-center">
            
            <!-- <div class="container align-self-center">
            
            </div> -->
            <h3><?php if (!empty($error)) {
                echo $error;
            }
            ?> </h3>
            <!-- <input id="idPenjual" name="idPenjual" type="text" value="" placeholder="" /> -->
            <!-- <input type="hidden" name="idUser" value="<?= $idUser; ?>"> -->
            <input type="text" name="idPenjual" id="idPenjual">
            <!-- <button class="btn btn-outline-dark w-25" type="submit" id="buttonScan" name="buttonScan">Scan</button> -->
            <button type="submit" name="buttonScan">Tes</button>
        </div>
    </form>
    <?php else : ?>
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
                <?php
                
                    
                    foreach ($dataOrderan as $oneView):
                        ?>
                        <tr>
                            <td><?=$oneView["namaMenu"];?>
                            <!-- <input id="<?= 'harga'.$oneView['idMenu']; ?>" class="span8" type="hidden" value="50000"/> -->
                            </td>
                            <td><?=$oneView["hargaMenu"];?>
                            </td> 
                            <td>
                            <?=$oneView["jumlahPesan"];?>
                            </td>
                            <td>
                            <?=$oneView["total"];?>
                            </td>
                        </tr>
                    <?php endforeach; 
                    ?>
                </tbody>
            </table>
            <div class="container">
                <h3>Total Harga : Rp. <span id="spanTotalHarga"><?= $totalHarga ?></span></h3>
                
                <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />
            </div>
            <input type="hidden" name="idUser" value="<?= $idUser; ?>">
            <button class="btn btn-outline-dark w-25" type="submit" id="buttonBayar" name="buttonBayar">Bayar</button>
        </div>
    </form>
    <?php endif; ?>
    
    





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