<?php 
session_start();
require 'fungsiAdmin.php';




if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}


$menu = query("SELECT * FROM tbl_menu");
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];
$saldoUser = $_SESSION["saldoUser"];
$roleUser = $_SESSION["roleUser"];


if ($roleUser == 3) {
    header("location: buyer.php");
    exit;
}


var_dump($idUser);
var_dump($namaUser);
var_dump($saldoUser);





if (isset($_POST['buttonPesan'])) {
    $idMenu = $_POST['idMenu'];
    // $jumlahPesan = $_POST['jumlahPesan'];
    // query("INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);");
    $query = "INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);";

    mysqli_query($koneksi, $query);

}




if (isset($_POST['buttonHapus'])) {
    $idMenu = $_POST['idMenu'];
    $query = "DELETE FROM tbl_pesan WHERE idMenu = '$idMenu'";

    mysqli_query($koneksi, $query);

}




if (isset($_POST['buttonOrder'])) {
    // $idPembeli = $_POST['idPembeli'];
    $waktuOrder = date("Y-m-d H:i:s");

    $query = "INSERT INTO tbl_order (idOrder, idPenjual, waktuOrder, statusOrder) VALUES (NULL, '$idUser', '$waktuOrder', 'belum')";
    mysqli_query($koneksi, $query);

    $querydOrder = query("SELECT idOrder FROM tbl_order ORDER BY idOrder DESC LIMIT 1");
    $idOrder = $querydOrder[0]["idOrder"];
    var_dump($idOrder);



    $dataPesanan = query("SELECT * FROM tbl_pesan WHERE idOrder = 0");

    foreach($dataPesanan as $oneView) {
    $idMenu = $oneView['idMenu'];
    $jumlahPesan = $_POST['jumlahPesan'.$idMenu];
    $queryUbahJumlah = "UPDATE tbl_pesan SET jumlahPesan = $jumlahPesan, idOrder = $idOrder WHERE idOrder = 0 AND idMenu = $idMenu";
    mysqli_query($koneksi, $queryUbahJumlah);
    }
    // SELECT hargaMenu, jumlahPesan, hargaMenu * jumlahPesan AS total FROM tbl_pesan INNER JOIN tbl_menu ON tbl_pesan.idMenu = tbl_menu.idMenu;
    header("Location: beli.php");
    exit;

}





$dataPesanan = query("SELECT * FROM tbl_pesan P, tbl_menu M WHERE P.idMenu = M.idMenu AND idOrder = 0");


$pesanan = array();
// $dataPesananSingle = "SELECT * FROM tbl_pesan WHERE idOrder = 0";
// $queryDataPesananSingle = mysqli_query($koneksi, $dataPesananSingle);
// while($readData = mysqli_fetch_array($queryDataPesananSingle)){
//   array_push($pesanan, $readData['idMenu']);
// }
foreach($dataPesanan as $oneView) {
    array_push($pesanan, $oneView['idMenu']);
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
    <a href="beli.php">beli</a>
    <a href="logout.php">logout</a>
    <div class="container">
    <?php
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
    <?php endforeach; ?>
    <form action="" method="post">
        <div class="card shadow p-3 mt-3 mb-3 w-4">
        <table class="table" id="tableLogData">
            <thead class="table-light">
            <tr>
                <!-- <th>No.</th> -->
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
                foreach ($dataPesanan as $oneView):
                    ?>
                    <tr>
                    <td><?=$oneView["namaMenu"];?>
                    </td>
                    <td><?=$oneView["hargaMenu"];?>
                    <input id="<?= 'harga'.$oneView['idMenu']; ?>" class="span8" type="hidden" value="<?=$oneView["hargaMenu"];?>"/>
                    </td>
                    <td><input id="<?= 'jumlahPesan'.$oneView['idMenu']; ?>" type="number" name="<?= 'jumlahPesan'.$oneView['idMenu']; ?>" value="1" onchange="return operasi()">
                    </td> 
                    <td>
                    <form action="" method="post">
                        <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
                        <button class="btn btn-outline-dark w-3" type="submit" id="buttonHapus" name="buttonHapus">Hapus</button>
                    </form>
                    </td>
                    </tr>
                <?php endforeach; 
                if ((empty($dataPesanan))) {
                    echo "<tr><td class='text-center' colspan='5' style='color: red; font-style: italic; font-size: 20px;'>Belum Ada Pesanan</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="container">
            <h3>Total Harga : Rp. <span id="spanTotalHarga">0</span></h3>
            
            <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />
        </div>
        <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
        <?php if(empty($dataPesanan)):?>
            <button class="btn btn-secondary w-25" type="submit" disabled>Order</button>
            <?php else:?>
            <button class="btn btn-outline-dark w-25" type="submit" id="buttonOrder" name="buttonOrder">Order</button>

            <?php endif;?>
        <!-- <button class="btn btn-outline-dark w-25" type="submit" id="buttonOrder" name="buttonOrder">Order</button> -->
        </div>
    </form>
    </div>




    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
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
    </script>
</body>
</html>