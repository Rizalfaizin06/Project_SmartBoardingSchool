<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}


if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "pay";

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





    <div class="grid grid-cols-1 items-center justify-items-center bg-primary h-64 w-full rounded-b-3xl shadow-xl p-5">
        <img src="assets/images/gb.jpg" alt="avatar" class="object-cover rounded-full h-24 w-2h-24">
        <h3 class="text-xl font-poppins font-bold text-white">
            <?= $namaUser; ?>
        </h3>
        <h3 class="font-poppins font-bold text-white">
            <?="Rp " . number_format($saldoUser, 0, ",", ".") ?>
        </h3>
        <div class=" w-full grid grid-cols-1 justify-items-center">
            <button
                class="px-4 py-2 mt-2 text-sm font-medium text-center text-primary bg-white rounded-lg hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300">
                <div class="grid grid-cols-2 h-10 items-center justify-items-center">
                    <img src="assets/icon/topUp.png" alt="" class="h-6">
                    <h3 class="text-md font-poppins font-bold px-1">
                        Top Up
                    </h3>
                </div>
            </button>
        </div>
    </div>


    <div class="grid grid-cols-1 justify-items-center w-full gap-3 p-5" id="allContent">

        <h3 id="result" class="font-poppins font-bold">Scan QR untuk membayar</h3>

        <div class="grid grid-cols-1 justify-items-center bg-white h-64 w-64 rounded-2xl overflow-hidden ">
            <div class="h-64 w-64 overflow-hidden">
                <video id="video" class="object-fill"></video>
            </div>
            <div class="relative w-64 h-[50px] -top-64 bg-black bg-opacity-60 justify-self-start"></div>
            <div class="grid gap-2 grid-cols-2 relative w-64 h-[155px]">
                <div class="relative w-[46px] h-[155px] -top-64 bg-black bg-opacity-60 justify-self-start"></div>
                <div class="relative w-[46px] h-[155px] -top-64 bg-black bg-opacity-60 justify-self-end"></div>
            </div>
            <div class="relative w-64 h-[50px] -top-64 bg-black bg-opacity-60 justify-self-start"></div>
            <img src="assets/icon/camScan.png" alt="avatar" class="relative h-48 -top-[480px]">
        </div>

        <a href="index.php" class="px-7 py-3 rounded-lg bg-primary hover:bg-opacity-80">


            <span class="text-sm font-poppins font-bold text-white">Back</span>
        </a>
    </div>




    <script src="dist/js/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="dist/js/zxing.min.js"></script>



    <script type="text/javascript">
        window.addEventListener('load', function () {
            let selectedDeviceId;
            const codeReader = new ZXing.BrowserMultiFormatReader()
            console.log('ZXing code reader initialized')
            codeReader.listVideoInputDevices()
                .then((videoInputDevices) => {
                    const sourceSelect = document.getElementById('sourceSelect')
                    selectedDeviceId = videoInputDevices[0].deviceId

                    if (videoInputDevices.length > 1) {
                        selectedDeviceId = videoInputDevices[1].deviceId
                    }

                    // if (videoInputDevices.length >= 1) {
                    //   videoInputDevices.forEach((element) => {
                    //     const sourceOption = document.createElement('option')
                    //     sourceOption.text = element.label
                    //     sourceOption.value = element.deviceId
                    //     sourceSelect.appendChild(sourceOption)
                    //   })

                    //   sourceSelect.onchange = () => {
                    //     selectedDeviceId = sourceSelect.value;
                    //   };

                    //   const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                    //   sourceSelectPanel.style.display = 'block'
                    // }
                    codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                        if (result) {
                            console.log(result);
                            document.getElementById('result').textContent = result.text;
                            codeReader.reset();
                            $.ajax({
                                url: "dist/ajax/ajaxConfirmPayment.php",
                                type: "post",
                                data: { idPenjual: result.text },
                                success: function (response) {
                                    console.log(response);
                                    $("#allContent").html(response);
                                }
                            });


                        }
                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            console.error(err)
                            document.getElementById('result').textContent = err
                        }
                    })
                    console.log(`Started continous decode from camera with id ${selectedDeviceId}`)

                    // document.getElementById('startButton').addEventListener('click', () => {
                    //   codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                    //     if (result) {
                    //       console.log(result)
                    //       document.getElementById('result').textContent = result.text
                    //     }
                    //     if (err && !(err instanceof ZXing.NotFoundException)) {
                    //       console.error(err)
                    //       document.getElementById('result').textContent = err
                    //     }
                    //   })
                    //   console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
                    // })

                    document.getElementById('resetButton').addEventListener('click', () => {
                        codeReader.reset()
                        document.getElementById('result').textContent = '';
                        console.log('Reset.')
                    })

                })
                .catch((err) => {
                    console.error(err)
                })
        })
    </script>




    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>