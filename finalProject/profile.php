<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}


if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "profile";

$menu = query("SELECT * FROM tbl_menu");
$idUser = $_SESSION["idUser"];
$namaUser = $_SESSION["namaUser"];
$saldoUser = $_SESSION["saldoUser"];
$roleUser = $_SESSION["roleUser"];


// if ($roleUser == 3) {
//     header("location: buyer.php");
//     exit;
// }


// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldoUser);



?>


<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dist/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'dist/template/navbar.php'; ?>





    <div class="grid grid-cols-1 items-center justify-items-center bg-primary h-48 w-full rounded-b-3xl shadow-xl p-5">
        <img src="assets/images/gb.jpg" alt="avatar" class="object-cover rounded-full h-24 w-2h-24">
        <h3 class="text-xl font-poppins font-bold text-white">Rizal Faizin Firdaus </h3>
        <h3 class="font-poppins font-bold text-white">Rp. 15.000</h3>

    </div>

    <div class="grid grid-cols-1 w-full h-full items-center justify-items-center mt-5">
        <div class="overflow-x-auto w-full h-full max-w-xl overflow-hidden p-5">
            <table class="w-full text-sm text-start text-gray-500 dark:text-gray-400">
                <tbody>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Nama
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : Rizal Faizin Firdaus
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            TTL
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : Grobogan, 31 Desember 2002
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Alamat
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : Jalan Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam quia ipsum natus
                            accusamus eius, odio, placeat perferendis velit dicta asperiores suscipit labore iste
                            repudiandae sint ad? Ut id nihil beatae.
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            No. HP
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : 8999994655
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Email
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : rizalfaiz@gmail.com
                        </td>
                    </tr>
                    <tr class="bg-white align-top">
                        <th scope="row" class="font-poppins font-medium text-gray-900 text-start whitespace-nowrap">
                            Orang tua
                        </th>
                        <td class="font-poppins font-medium text-gray-900 text-start">
                            : RAB
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>




    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>