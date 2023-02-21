<?php

//koneksi kedatabase
// $koneksi = mysqli_connect("localhost", "id18952921_rizal", ">R(xFzvAW#ln~1YB", "id18952921_krenova");
// $koneksi = mysqli_connect("localhost", "ninb9915_rizal", ">R(xFzvAW#ln~1YB", "ninb9915_Krenova");
// $koneksi = mysqli_connect("localhost", "fira3489_rizal", "tY%=Cz+#jPUi", "fira3489_rizal_database");
// $koneksi = mysqli_connect("127.0.0.1", "rizal", "rizal", "db_smartboardingschool");
$koneksi = mysqli_connect("127.0.0.1", "rizal", "rizal", "db_ssm");

date_default_timezone_set('Asia/Jakarta');
$tanggal = date("Y-m-d");
$jam = date("H:i:s");
$jamTanggal = date("Y-m-d H:i:s");



//query
function createUUID($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function tambah($data)
{
    global $koneksi;
    $username = $data['username'];
    $password = $data['password'];
    $realName = $data['realName'];
    $tempatLahir = $data['tempatLahir'];
    $tanggalLahir = $data['tanggalLahir'];
    $alamat = $data['alamat'];
    $nomorTelfon = $data['nomorTelfon'];
    $email = $data['email'];
    $role = $data['role'];

    if ($role == "3") {
        $fotoProfilSiswa = upload('fotoProfilSiswa', 'assets/images/avatar/');
        $fotoProfilOrangTua = upload('fotoProfilOrangTua', 'assets/images/avatar/');
        $uuidSiswa = createUUID();
        $uuidOrangTua = createUUID();

        $idDetail = query("SELECT COUNT(*) jumlahBaris FROM tbl_users")[0]['jumlahBaris'];
        $idDetailSiswa = $idDetail + 1;
        $idDetailOrangTua = $idDetail + 2;
        if (!$fotoProfilOrangTua || !$fotoProfilSiswa) {
            return false;
            // defaultProfile.jpg
        }

        $query = "INSERT INTO tbl_users (idUser, uuidUser, username, password, realName, tempatLahir, tanggalLahir, alamat, nomorTelfon, email, profileImage, role, status, idDetailUser) VALUES (NULL, '$uuidSiswa', '$username', '$password', '$realName', '$tempatLahir', '$tanggalLahir', '$alamat', '$nomorTelfon', '$email', '$fotoProfilSiswa', '3', '0', '9');";

        mysqli_query($koneksi, $query);
    }

    // if ($jenisGambar == "paket") {
    //     $letakPaket = $data['letakPaket'];
    //     $paketImage = upload('paketImage');

    //     if (!$paketImage) {
    //         return false;
    //     }
    //     $query = "INSERT INTO paket VALUES ('', '$letakPaket', '$paketImage')";

    //     mysqli_query($koneksi, $query);
    // }

    // if ($jenisGambar == "promo") {
    //     $judul = $data['judul'];
    //     $text1 = $data['text1'];
    //     $text2 = $data['text2'];
    //     $text3 = $data['text3'];
    //     $harga = $data['harga'];
    //     $text5 = $data['text5'];
    //     $text6 = $data['text6'];
    //     $text7 = $data['text7'];

    //     $query = "INSERT INTO promo VALUES ('', '$judul', '$text1', '$text2', '$text3', '$harga', '$text5', '$text6', '$text7')";

    //     mysqli_query($koneksi, $query);
    // }

    return mysqli_affected_rows($koneksi);
}


function hapus($data)
{
    global $koneksi;
    $jenisGambar = $data['jenisGambar'];
    $id = $data['id'];
    $dataImageName = query("SELECT * FROM $jenisGambar WHERE id = $id")[0];
    if (empty($dataImageName)) {
        return false;
    }

    if ($jenisGambar == "banner") {
        $fotoProfilSiswa = $dataImageName['fotoProfilSiswa'];
        $fotoProfilOrangTua = $dataImageName['fotoProfilOrangTua'];

        unlink("../images/$fotoProfilSiswa");
        unlink("../images/$fotoProfilOrangTua");
    }

    if ($jenisGambar == "paket") {
        $paketImage = $dataImageName['paketImage'];

        unlink("../images/$paketImage");
    }

    mysqli_query($koneksi, "DELETE FROM $jenisGambar WHERE id = $id");

    return mysqli_affected_rows($koneksi);
}

function upload($namaGambar, $tempatPenyimpanan)
{
    $namaFile = $_FILES[$namaGambar]['name'];
    $ukuranFile = $_FILES[$namaGambar]['size'];
    $error = $_FILES[$namaGambar]['error'];
    $tnpName = $_FILES[$namaGambar]['tmp_name'];

    if ($error === 4) {
        echo "
			<script>
				alert('pilih gambar terlebih dahulu');
			</script>";
        return false;
    }

    //cek apakah yang diupload adalah gambar
    // $extensiGambarValid = ['jpg','jpeg','png'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));

    // if (!in_array($extensiGambar, $extensiGambarValid)) {
    //     echo "
    // 		<script>
    // 			alert('file yang diupload bukan gambar');
    // 		</script>";
    //     return false;
    // }

    //membatasi ukuran gambar
    // if ($ukuranFile > 2000000) {
    //     echo "
    // 		<script>
    // 			alert('ukuran gambar terlalu besar');
    // 		</script>";
    //     return false;
    // }

    //generate nama file baru, karena ada kemungkinan user memasukkan file dengan nama yang sama, dan akan direplace

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensiGambar;

    //gambar siap diupload

    move_uploaded_file($tnpName, $tempatPenyimpanan . $namaFileBaru);
    return $namaFileBaru;
}


function query($query)
{
    global $koneksi;
    $baris = [];
    $result = mysqli_query($koneksi, $query);
    while ($bar = mysqli_fetch_assoc($result)) {
        $baris[] = $bar;
    }
    return $baris;
}

function registrasi($data)
{
    global $koneksi;
    $role = $data['role'];

    if ($role == "3") {

        $usernameSiswa = strtolower(stripcslashes($data["usernameSiswa"]));
        $passwordSiswa = mysqli_real_escape_string($koneksi, $data["passwordSiswa"]);
        $konfirmasiPasswordSiswa = mysqli_real_escape_string($koneksi, $data["konfirmasiPasswordSiswa"]);
        $realNameSiswa = $data['realNameSiswa'];
        $tempatLahirSiswa = $data['tempatLahirSiswa'];
        $tanggalLahirSiswa = $data['tanggalLahirSiswa'];
        $nomorTelfonSiswa = $data['nomorTelfonSiswa'];
        $emailSiswa = $data['emailSiswa'];
        $alamatSiswa = $data['alamatSiswa'];


        $usernameOrangTua = strtolower(stripcslashes($data["usernameOrangTua"]));
        $passwordOrangTua = mysqli_real_escape_string($koneksi, $data["passwordOrangTua"]);
        $konfirmasiPasswordOrangTua = mysqli_real_escape_string($koneksi, $data["konfirmasiPasswordOrangTua"]);
        $realNameOrangTua = $data['realNameOrangTua'];
        $tempatLahirOrangTua = $data['tempatLahirOrangTua'];
        $tanggalLahirOrangTua = $data['tanggalLahirOrangTua'];
        $nomorTelfonOrangTua = $data['nomorTelfonOrangTua'];
        $emailOrangTua = $data['emailOrangTua'];
        $alamatOrangTua = $data['alamatOrangTua'];


        // $username = 
        // $password = 
        // $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

        $result = mysqli_query($koneksi, "SELECT username FROM tbl_users WHERE username = '$usernameSiswa' ");

        if (mysqli_fetch_assoc($result)) {
            echo "<script>
    			alert('username sudah ada');
    		</script>";
            return false;
        }

        $result = mysqli_query($koneksi, "SELECT username FROM tbl_users WHERE username = '$usernameOrangTua' ");

        if (mysqli_fetch_assoc($result)) {
            echo "<script>
    			alert('username sudah ada');
    		</script>";
            return false;
        }

        if ($passwordOrangTua !== $konfirmasiPasswordOrangTua) {
            echo "<script>
				alert('konfirmasi password tidak sesuai');
			</script>";
            return false;
        }

        if ($passwordSiswa !== $konfirmasiPasswordSiswa) {
            echo "<script>
				alert('konfirmasi password tidak sesuai');
			</script>";
            return false;
        }
        $passwordSiswa = password_hash($passwordSiswa, PASSWORD_DEFAULT);
        $passwordOrangTua = password_hash($passwordOrangTua, PASSWORD_DEFAULT);
        $fotoProfilSiswa = upload('fotoProfilSiswa', 'assets/images/avatar/');
        $fotoProfilOrangTua = upload('fotoProfilOrangTua', 'assets/images/avatar/');
        $uuidSiswa = createUUID();
        $uuidOrangTua = createUUID();

        $idDetail = query("SELECT COUNT(*) jumlahBaris FROM tbl_users")[0]['jumlahBaris'];
        $idDetailSiswa = $idDetail + 1;
        $idDetailOrangTua = $idDetail + 2;
        if (!$fotoProfilSiswa) {
            $fotoProfilSiswa = "defaultProfile.jpg";
        }

        if (!$fotoProfilOrangTua) {
            $fotoProfilOrangTua = "defaultProfile.jpg";
        }

        $query = "INSERT INTO tbl_users (idUser, uuidUser, username, password, realName, tempatLahir, tanggalLahir, alamat, nomorTelfon, email, profileImage, role, status, idDetailUser) VALUES (NULL, '$uuidSiswa', '$usernameSiswa', '$passwordSiswa', '$realNameSiswa', '$tempatLahirSiswa', '$tanggalLahirSiswa', '$alamatSiswa', '$nomorTelfonSiswa', '$emailSiswa', '$fotoProfilSiswa', '3', '0', '$idDetailSiswa');";
        mysqli_query($koneksi, $query);

        $query = "INSERT INTO tbl_users (idUser, uuidUser, username, password, realName, tempatLahir, tanggalLahir, alamat, nomorTelfon, email, profileImage, role, status, idDetailUser) VALUES (NULL, '$uuidOrangTua', '$usernameOrangTua', '$passwordOrangTua', '$realNameOrangTua', '$tempatLahirOrangTua', '$tanggalLahirOrangTua', '$alamatOrangTua', '$nomorTelfonOrangTua', '$emailOrangTua', '$fotoProfilOrangTua', '4', '0', '$idDetailOrangTua');";
        mysqli_query($koneksi, $query);

        $idOrangTua = query("SELECT idUser FROM tbl_users WHERE uuidUser = '$uuidOrangTua'")[0]['idUser'];

        $idAnak = query("SELECT idUser FROM tbl_users WHERE uuidUser = '$uuidSiswa'")[0]['idUser'];

        $query = "INSERT INTO tbl_siswa (idDetailUser, idOrangTua, saldo, spendingLimit, additionalLimit) VALUES ('$idDetailSiswa', '$idOrangTua', '0', '0', '0')";
        mysqli_query($koneksi, $query);

        $query = "INSERT INTO tbl_orangtua (idDetailUser, idAnak) VALUES ('$idDetailOrangTua', '$idAnak')";
        mysqli_query($koneksi, $query);
    }

    // $password = password_hash($password, PASSWORD_DEFAULT);

    // mysqli_query($koneksi, "INSERT INTO tbl_users VALUES (NULL, '$username', '$password', 'Penjualll', '2', '20000', '1')");

    return mysqli_affected_rows($koneksi);
}