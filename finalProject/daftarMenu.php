<?php
if (!session_id()) {
    session_start();
    require 'dist/function/function.php';
}



if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

$_SESSION["currentPage"] = "daftarMenu";

$idUser = $_SESSION["idUser"];

$queryUser = query("SELECT * FROM tbl_users WHERE idUser = '$idUser'")[0];
$role = $queryUser["role"];


if ($role == 1) {


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
} else {

}
if (isset($_POST['buttonTambahCategory'])) {
    $namaCategory = $_POST['namaCategory'];

    $query = "INSERT INTO tbl_category (idCategory, namaCategory, idUserCat) VALUES (NULL, '$namaCategory', '$idUser')";
    mysqli_query($koneksi, $query);

}
if (isset($_POST['buttonTambahMenu'])) {
    if (addMenu($_POST) > 0) {

    } else {
        echo mysqli_error($koneksi);
        $error = true;
    }
}


if (isset($_POST['buttonHapusMenu'])) {
    $idMenu = $_POST['idMenu'];
    $query = "DELETE FROM tbl_menu WHERE idMenu = '$idMenu'";
    mysqli_query($koneksi, $query);

    header("Location: i.php");
    exit;

}

$menu = query("SELECT * FROM tbl_menu M, tbl_category C WHERE M.idCategory = C.idCategory AND idPenjual = '$idUser' ORDER BY namaCategory DESC, namaMenu");

$category = query("SELECT namaCategory, idCategory, idUserCat FROM tbl_category WHERE idUserCat = '$idUser'");
// var_dump($menu);







?>



<!doctype html>
<html lang="en">

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
    <div class="p-5"></div>

    <div class="w-full grid grid-cols-1 items-center justify-items-center p-5">
        <div class="border-2 border-gray-300 rounded-xl shadow-2xl p-5 w-full max-w-xl">
            <div>
                <h2 class="text-2xl font-poppins font-bold underline mb-3 text-center">Daftar Menu
                </h2>
            </div>
            <div class="pb-5 grid grid-cols-2 gap-1">
                <button id="buttonDaftarMenuPane"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                    Daftar Menu
                </button>
                <button id="buttonDaftarCatecoryPane"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                    Daftar Kategori
                </button>
                <button id="buttonTambahMenuPane"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                    Tambah Menu
                </button>
                <button id="buttonTambahCatecoryPane"
                    class="px-3 py-3 rounded-lg bg-slate-50 border-2 border-gray-300 shadow-md hover:bg-opacity-80 text-xs font-poppins font-bold text-center">


                    Tambah Kategori
                </button>
            </div>
            <div class="relative overflow-x-auto shadow-md rounded-lg w-full  border-2 border-gray-300 "
                id="daftarMenuPane">

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>

                            <th scope="col" class="px-6 py-3">
                                Menu
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Harga
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menu as $oneView):

                            ?>
                            <form action="" method="post">
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <input type="hidden" name="idMenu" value="<?= $oneView['idMenu']; ?>">
                                    <th scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" src="assets/images/avatar/gb.jpg"
                                            alt="Jese image">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">
                                                <?= $oneView['namaMenu']; ?>
                                            </div>

                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $oneView['namaCategory']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $oneView['hargaMenu']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="submit" name="buttonHapusMenu"
                                            class="px-3 py-2 rounded-lg bg-primary hover:bg-opacity-80">


                                            <span class="text-xs font-poppins font-bold text-white">Hapus</span>
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="hidden relative overflow-x-auto shadow-md rounded-lg w-full  border-2 border-gray-300 "
                id="tambahMenuPane">

                <div class="mt-5 p-5">
                    <div>
                        <form action="" method="post" enctype="multipart/form-data">








                            <div class="md:space-y-2 mb-3">
                                <!-- <label class="font-poppins text-xs font-semibold text-gray-600 py-2">Profil<abbr
                                        class="hidden" title="required">*</abbr></label> -->
                                <div class="flex flex-col sm:flex-row items-center">
                                    <h2 class="font-semibold font-poppins text-xl text-center">Menu</h2>
                                    <div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-20 h-20 mr-4 flex-none rounded-xl border overflow-hidden">
                                        <img class="w-20 h-20 mr-4 object-cover"
                                            src="assets/images/avatar/defaultProfile.jpg">
                                    </div>
                                    <label class="font-poppins cursor-pointer ">

                                        <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                            for="file_input">Foto Menu</span>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            id="file_input" type="file" name="fotoMenu" required>
                                    </label>
                                </div>
                            </div>

                            <div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-poppins font-semibold text-gray-600 py-2">Nama Menu</label>
                                    <input placeholder="Masukkan Nama Menu"
                                        class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                        type="text" name="namaMenu" id="namaMenu" required>
                                </div>
                            </div>

                            <div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-poppins font-semibold text-gray-600 py-2">Harga Menu</label>
                                    <input placeholder="Masukkan Harga Menu"
                                        class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                        required type="number" min="1" name="hargaMenu" id="hargaMenu">
                                    <p class="font-poppins text-sm text-red-500 hidden mt-3" id="error">Please fill
                                        out
                                        this field.
                                    </p>
                                </div>
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-poppins font-semibold text-gray-600 py-2">Kategori Menu</label>
                                    <select id="idCategory" name="idCategory"
                                        class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4">
                                        <?php foreach ($category as $oneView): ?>
                                            <option value="<?php echo $oneView['idCategory']; ?>"><?php echo $oneView['namaCategory']; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>

                            </div>

                            <!-- <p class="font-poppins text-xs text-red-500 text-right my-3">Required fields are marked with
                                an
                                asterisk <abbr title="Required field">*</abbr></p> -->
                            <div class="mt-5 text-center md:text-right md:space-x-3 md:block flex flex-col-reverse">
                                <input type="hidden" name="idUser" value="<?= $idUser; ?>">
                                <a href="login.php"
                                    class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                    <span class="">Cancel</span> </a>
                                <button type="submit"
                                    class="mb-2 md:mb-0 bg-primary px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-opacity-90"
                                    name="buttonTambahMenu">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hidden relative overflow-x-auto shadow-md rounded-lg w-full  border-2 border-gray-300 "
                id="daftarCategoryPane">

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>

                            <th scope="col" class="px-6 py-3">
                                namaCategory
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category as $oneView):

                            ?>
                            <form action="" method="post">
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <input type="hidden" name="idCategory" value="<?= $oneView['idCategory']; ?>">
                                    <th scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">

                                        <div class="pl-3">
                                            <div class="text-base font-semibold">
                                                <?= $oneView['namaCategory']; ?>
                                            </div>

                                        </div>
                                    </th>

                                    <td class="px-6 py-4">
                                        <button type="submit" name="buttonHapusCategory"
                                            class="px-3 py-2 rounded-lg bg-primary hover:bg-opacity-80">


                                            <span class="text-xs font-poppins font-bold text-white">Hapus</span>
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <div class="p-2"></div>
            <div class="hidden relative overflow-x-auto shadow-md rounded-lg w-full  border-2 border-gray-300"
                id="tambahCategoryPane">

                <div class="mt-5 p-5">
                    <div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="md:space-y-2 mb-3">
                                <!-- <label class="font-poppins text-xs font-semibold text-gray-600 py-2">Profil<abbr
                                        class="hidden" title="required">*</abbr></label> -->
                                <div class="flex flex-col sm:flex-row items-center">
                                    <h2 class="font-semibold font-poppins text-xl text-center">Tambah Kategori</h2>
                                    <div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
                                </div>

                            </div>

                            <div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
                                <div class="w-full flex flex-col mb-3">
                                    <label class="font-poppins font-semibold text-gray-600 py-2">Nama
                                        Kategori</label>
                                    <input placeholder="Masukkan Nama Kategori"
                                        class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                        type="text" name="namaCategory" id="namaCategory" required>
                                </div>
                            </div>


                            <div class="mt-5 text-center md:text-right md:space-x-3 md:block flex flex-col-reverse">

                                <a href="login.php"
                                    class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                    <span class="">Cancel</span> </a>
                                <button type="submit"
                                    class="mb-2 md:mb-0 bg-primary px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-opacity-90"
                                    name="buttonTambahCategory">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="dist/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $("#buttonDaftarMenuPane").click(function () {
            $("#daftarCategoryPane").hide();
            $("#tambahCategoryPane").hide();
            $("#tambahMenuPane").hide();
            $("#daftarMenuPane").show();
        });
        $("#buttonDaftarCatecoryPane").click(function () {
            $("#tambahCategoryPane").hide();
            $("#tambahMenuPane").hide();
            $("#daftarMenuPane").hide();
            $("#daftarCategoryPane").show();
        });
        $("#buttonTambahMenuPane").click(function () {
            $("#tambahCategoryPane").hide();
            $("#daftarMenuPane").hide();
            $("#daftarCategoryPane").hide();
            $("#tambahMenuPane").show();
        });
        $("#buttonTambahCatecoryPane").click(function () {
            $("#daftarMenuPane").hide();
            $("#daftarCategoryPane").hide();
            $("#tambahMenuPane").hide();
            $("#tambahCategoryPane").show();
        });


    </script>
</body>

</html>