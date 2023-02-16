<?php
if (!session_id()) {
    session_start();
    require 'function.php';
}

if (isset($_POST['deleteDataPesan'])) {
    var_dump($_POST);
    $idMenu = $_POST['deleteDataPesan'];
    $query = "DELETE FROM tbl_pesan WHERE idMenu = '$idMenu'";

    mysqli_query($koneksi, $query);

}