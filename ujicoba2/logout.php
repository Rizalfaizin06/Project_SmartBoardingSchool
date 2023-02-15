<?php 
// hanya ini sebenernya cukup, tapi di beberapa kasus session masih belum hilang
// session_start();
// session_destroy();

session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("location: login.php");
exit;
 ?>