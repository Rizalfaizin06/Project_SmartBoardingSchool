<?php
if (!session_id()) {
    session_start();
    require 'function.php';
}

if (isset($_POST['insertDataPesan'])) {
    echo "Masukk";
    $idMenu = $_POST['insertDataPesan'];
    var_dump($idMenu);
    // $jumlahPesan = $_POST['jumlahPesan'];
    // query("INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);");
    $query = "INSERT INTO tbl_pesan (idPesan, idOrder, idMenu, jumlahPesan) VALUES (NULL, 0, $idMenu, 0);";
    echo $query;
    var_dump(mysqli_query($koneksi, $query))
    ;

}