<?php 
session_start();
require '../../fungsiAdmin.php';





$menu = query("SELECT * FROM tbl_menu");
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];
$saldoUser = $_SESSION["saldoUser"];
$roleUser = $_SESSION["roleUser"];



var_dump($idUser);
var_dump($namaUser);
var_dump($saldoUser);





// if (isset($_POST['buttonPesan'])) {
//     $idMenu = $_POST['idMenu'];
//     // $jumlahPesan = $_POST['jumlahPesan'];
//     // query("INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);");
//     $query = "INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);";

//     mysqli_query($koneksi, $query);

// }




// if (isset($_POST['buttonHapus'])) {
//     var_dump($_POST);
//     $idMenu = $_POST['idMenu'];
//     $query = "DELETE FROM tbl_pesan WHERE idMenu = '$idMenu'";

//     mysqli_query($koneksi, $query);
//     unset($_POST['buttonHapus']);
//     unset($_POST['idMenu']);

// }




$dataPesanan = query("SELECT * FROM tbl_pesan P, tbl_menu M WHERE (P.idMenu = M.idMenu) AND idOrder = 0");


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

<?php
        foreach ($menu as $oneView) :
        ?>
        <div class="card shadow p-3 mt-3 mb-3 w-4">
            
        <h3><?= $oneView["idMenu"]; ?></h3>
            <h3><?= $oneView["namaMenu"]; ?></h3>
            <h3><?= $oneView["hargaMenu"]; ?></h3>
                    <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>">
            <?php
            
            if(in_array($oneView["idMenu"], $pesanan)):?>
                <button class="btn btn-secondary w-25" disabled>Sudah dipesan</button>
                <?php else:?>
                <button class="btn btn-outline-dark w-25" id="button-pesan" name="buttonPesan" onclick="insertDataPesan(<?= $oneView['idMenu']; ?>)">Pesan</button>

                <?php endif;?>
            
        </div>
        <?php endforeach; ?>
        <div class="card shadow p-3 mt-3 mb-3 w-4">
            <form action="" method="post">
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
                            <!-- <form action="" method="post"> -->
                                <!-- <input type="hidden" name="idMenu" value="<?= $oneView["idMenu"]; ?>"> -->
                                <div class="btn btn-outline-dark w-3" id="buttonHapus" name="buttonHapus" onclick="deleteDataPesan(<?= $oneView['idMenu']; ?>)">Hapus</div>
                            <!-- </form> -->
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
                <button class="btn btn-outline-dark w-25" type="submit" id="buttonOrder" name="buttonOrder" >Order</button>

                <?php endif;?>
            </form>
            <!-- <button class="btn btn-outline-dark w-25" type="submit" id="buttonOrder" name="buttonOrder">Order</button> -->
        </div>