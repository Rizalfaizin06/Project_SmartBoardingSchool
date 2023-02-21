<?php
// hanya ini sebenernya cukup, tapi di beberapa kasus session masih belum hilang
// session_start();
// session_destroy();

session_start();
$_SESSION = [];
session_unset();
session_destroy();
setcookie('uuid', '', time() - (3600 * 24 * 9));
setcookie('key', '', time() - (3600 * 24 * 9));
header("location: login.php");
exit;
?>