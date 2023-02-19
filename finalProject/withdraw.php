<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}


if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$idUser = $_SESSION["idUser"];

$queryUser = query("SELECT * FROM tbl_users WHERE idUser = '$idUser'")[0];
$role = $queryUser["role"];


if ($role == 1) {
    $queryUser = query("SELECT * FROM tbl_users U, tbl_admin P WHERE U.idDetailUser = P.idDetailUser AND idUser = '$idUser'")[0];
    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    // $PemasukanHariIni = 128000;

} elseif ($role == 2) {
    $queryUser = query("SELECT * FROM tbl_users U, tbl_penjual P WHERE U.idDetailUser = P.idDetailUser AND idUser = '$idUser'")[0];
    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    $saldo = $queryUser["saldo"];
    $namaToko = $queryUser["namaToko"];
    $logoToko = $queryUser["logoToko"];
    $PemasukanHariIni = 128000;
} elseif ($role == 3) {
    $queryUser = query("SELECT * FROM tbl_users U, tbl_siswa S WHERE U.idDetailUser = S.idDetailUser AND idUser = '$idUser'")[0];

    $realName = $queryUser["realName"];
    $tempatLahir = $queryUser["tempatLahir"];
    $tanggalLahir = $queryUser["tanggalLahir"];
    $alamat = $queryUser["alamat"];
    $nomorTelfon = $queryUser["nomorTelfon"];
    $email = $queryUser["email"];
    $profileImage = $queryUser["profileImage"];
    $role = $queryUser["role"];
    $idDetailUser = $queryUser["idDetailUser"];

    $idOrangTua = $queryUser["idOrangTua"];
    $saldo = $queryUser["saldo"];
    $spendingLimit = $queryUser["spendingLimit"];
    $additionalLimit = $queryUser["additionalLimit"];
    $totalLimit = $spendingLimit + $additionalLimit;
    $PengeluaranHariIni = 17000;
} else {

}


// if ($roleUser == 3) {
//     header("location: buyer.php");
//     exit;
// }


// var_dump($idUser);
// var_dump($namaUser);
// var_dump($saldoUser);


if (isset($_POST['buttonBayar'])) {
    $jumlahBayar = $_POST['jumlahBayar'];
    $idPenerima = $_POST['idPenerima'];


    //memulai transaction
    mysqli_autocommit($koneksi, false);

    try {
        //menambah saldo pengguna penerima
        $sql = "UPDATE tbl_users U, tbl_penjual P SET saldo = saldo - $jumlahBayar WHERE U.idDetailUser = P.idDetailUser AND idUser = $idUser";
        mysqli_query($koneksi, $sql);

        //mengurangi saldo pengguna pengirim
        $sql = "UPDATE tbl_users U, tbl_admin A SET saldo = saldo + $jumlahBayar WHERE U.idDetailUser = A.idDetailUser AND idUser = $idPenerima";
        mysqli_query($koneksi, $sql);

        //commit transaction jika operasi transfer berhasil
        mysqli_commit($koneksi);

        // echo "Transfer saldo berhasil!";
    } catch (Exception $e) {
        //rollback transaction jika terjadi kesalahan pada operasi transfer
        mysqli_rollback($koneksi);
        // echo "Transfer saldo gagal: " . $e->getMessage();
    }

    //aktifkan kembali mode autocommit
    mysqli_autocommit($koneksi, true);

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
        <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar"
            class="object-cover rounded-full h-24 w-2h-24">
        <h3 class="text-xl font-poppins font-bold text-white">
            <?= $realName; ?>
        </h3>
        <h3 class="font-poppins font-bold text-white">
            <?="Rp " . number_format($saldo, 0, ",", ".") ?>
        </h3>
    </div>


    <div class="grid grid-cols-1 justify-items-center w-full gap-3 p-5" id="allContent">
        <div id="scanQR">
            <h3 class="font-poppins font-bold">Scan QR untuk membayar</h3>

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
        </div>
        <div id="bayarTopUp">
            <form class="grid grid-cols-1 gap-5 items-center" action="" method="POST">
                <input type="hidden" id="idPenerima" name="idPenerima" value="">

                <span class="text-sm text-center font-poppins font-bold">Withdraw kepada <span
                        id="spanNama"></span></span>
                <div>
                    <label for="jumlahBayar" class="ml-2 block text-sm text-gray-900 text-center">
                        Masukkan jumlah
                    </label>
                    <input id="jumlahBayar" name="jumlahBayar"
                        class=" w-full text-base py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                        type="text" placeholder="" value="">
                </div>
                <button type="submit" name="buttonBayar" class="px-7 py-3 rounded-lg bg-primary hover:bg-opacity-80">
                    <span class="text-sm font-poppins font-bold text-white">Transfer</span>
                </button>
            </form>
        </div>
        <a href="index.php" class="px-7 py-3 rounded-lg bg-primary hover:bg-opacity-80">


            <span class="text-sm font-poppins font-bold text-white">Back</span>
        </a>

    </div>

    <div id="wrongQR" class="grid grid-cols-1 justify-items-center w-full gap-3 p-5">
        <div>
            <h2 class="text-2xl font-poppins font-bold underline mb-2 text-center">QR Code Salah
            </h2>
        </div>
        <button onClick="window.location.reload();"
            class="px-4 py-2 mt-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-stone-300"
            id="buttonUlang" name="buttonUlang">Ulangi</button>
    </div>


    <script src="dist/js/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="dist/js/zxing.min.js"></script>



    <script type="text/javascript">
        window.addEventListener('load', function () {
            $("#bayarTopUp").hide();
            $("#wrongQR").hide();
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
                            // document.getElementById('result').textContent = result.text;
                            codeReader.reset();

                            $.ajax({
                                url: "dist/ajax/ajaxTopUp.php",
                                type: "post",
                                data: { idPenerima: result.text },
                                success: function (response) {
                                    console.log(response);
                                    if (response) {
                                        $('#spanNama').text(response);
                                        $('#idPenerima').val(result);
                                        $("#scanQR").hide();
                                        $("#bayarTopUp").show();
                                    } else {
                                        $("#allContent").hide();
                                        $("#wrongQR").show();
                                    }

                                }
                            });
                            // echo $idPenerima;


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