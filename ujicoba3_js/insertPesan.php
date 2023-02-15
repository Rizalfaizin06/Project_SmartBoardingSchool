<?php 
session_start();
require 'fungsiAdmin.php';


if (isset($_POST['insertData'])) {
    echo "Masukk";
    $idMenu = $_POST['insertData'];
    var_dump($idMenu);
    // $jumlahPesan = $_POST['jumlahPesan'];
    // query("INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);");
    $query = "INSERT INTO tbl_pesan (idPesan, idPembeli, idOrder, idMenu, jumlahPesan) VALUES (NULL, 1, 0, $idMenu, 0);";
    echo $query;
    var_dump(mysqli_query($koneksi, $query))
    ;

}

