<?php
if (!session_id()) {
    session_start();
    require 'function.php';
}

$sql = "UPDATE tbl_siswa SET additionalLimit = 0";
mysqli_query($koneksi, $sql);