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



//query


function tambah($data)
{
    global $koneksi;
    $jenisGambar = $data['jenisGambar'];

    if ($jenisGambar == "banner") {
        $desktopImage = upload('desktopImage');
        $mobileImage = upload('mobileImage');

        if (!$mobileImage || !$desktopImage) {
            return false;
        }
        $query = "INSERT INTO banner VALUES ('', '$desktopImage', '$mobileImage')";

        mysqli_query($koneksi, $query);
    }

    if ($jenisGambar == "paket") {
        $letakPaket = $data['letakPaket'];
        $paketImage = upload('paketImage');

        if (!$paketImage) {
            return false;
        }
        $query = "INSERT INTO paket VALUES ('', '$letakPaket', '$paketImage')";

        mysqli_query($koneksi, $query);
    }

    if ($jenisGambar == "promo") {
        $judul = $data['judul'];
        $text1 = $data['text1'];
        $text2 = $data['text2'];
        $text3 = $data['text3'];
        $harga = $data['harga'];
        $text5 = $data['text5'];
        $text6 = $data['text6'];
        $text7 = $data['text7'];

        $query = "INSERT INTO promo VALUES ('', '$judul', '$text1', '$text2', '$text3', '$harga', '$text5', '$text6', '$text7')";

        mysqli_query($koneksi, $query);
    }

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
        $desktopImage = $dataImageName['desktopImage'];
        $mobileImage = $dataImageName['mobileImage'];

        unlink("../images/$desktopImage");
        unlink("../images/$mobileImage");
    }

    if ($jenisGambar == "paket") {
        $paketImage = $dataImageName['paketImage'];

        unlink("../images/$paketImage");
    }

    mysqli_query($koneksi, "DELETE FROM $jenisGambar WHERE id = $id");

    return mysqli_affected_rows($koneksi);
}

function upload($namaGambar)
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

    move_uploaded_file($tnpName, '../images/' . $namaFileBaru);
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

function tambahAnggotaArduino($data)
{
    global $koneksi;
    $RFIDP = $data["Data1"];

    $query = "INSERT INTO anggota VALUES ('$RFIDP', '', '', '')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahAnggota($data)
{
    global $koneksi;
    $RFIDP = $data["RFIDP"];
    $namaAnggota = $data["namaAnggota"];
    $kelas = $data["kelas"];
    $email = $data["email"];

    $query = "INSERT INTO anggota VALUES ('$RFIDP', '$namaAnggota', '$kelas', '$email')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function ubahAnggota($data)
{
    global $koneksi;
    $RFIDP = $data["RFIDP"];
    $RFIDPBaru = $data["RFIDPBaru"];
    $namaAnggota = $data["namaAnggota"];
    $kelas = $data["kelas"];
    $email = $data["email"];

    $query = "UPDATE anggota SET RFIDP = '$RFIDPBaru', namaAnggota = '$namaAnggota', kelas = '$kelas', email = '$email' WHERE RFIDP = '$RFIDP'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapusAnggota($data)
{
    global $koneksi;

    $query = "DELETE FROM anggota WHERE RFIDP = '$data'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahMapel($data)
{
    global $koneksi;
    $idBuku = $data["idBuku"];
    $namaBuku = $data["namaBuku"];

    $query = "INSERT INTO mapel VALUES ('$idBuku', '$namaBuku')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function ubahMapel($data)
{
    global $koneksi;
    $idBuku = $data["idBuku"];
    $idBukuBaru = $data["idBukuBaru"];
    $namaBuku = $data["namaBuku"];
    // //$query = "UPDATE `mapel` SET `namaBuku`='MTK' WHERE idBuku = 'B001'";
    // var_dump($data);
    // die;
    $query = "UPDATE mapel SET namaBuku = '$namaBuku', idBuku = '$idBukuBaru' WHERE idBuku = '$idBuku'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapusMapel($data)
{
    global $koneksi;

    $query = "DELETE FROM mapel WHERE idBuku = '$data'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahBuku($data)
{
    global $koneksi;
    $RFIDB = $data["RFIDB"];
    $idBuku = $data["idBuku"];
    $status = $data["status"];

    $query = "INSERT INTO buku VALUES ('$RFIDB', '$idBuku', '$status')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahBukuArduino($data)
{
    global $koneksi;
    $RFIDB = $data["Data1"];
    if (empty($RFIDB)) {
        return 0;
    }
    $query = "INSERT INTO buku VALUES ('$RFIDB', NULL, 1)";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function ubahBuku($data)
{
    global $koneksi;
    $RFIDB = $data["RFIDB"];
    $RFIDBBaru = $data["RFIDBBaru"];
    $idBuku = $data["idBuku"];
    $status = $data["status"];

    $query = "UPDATE buku SET idBuku = '$idBuku', RFIDB = '$RFIDBBaru', status = '$status' WHERE RFIDB = '$RFIDB'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapusBuku($data)
{
    global $koneksi;

    $query = "DELETE FROM buku WHERE RFIDB = '$data'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function pinjam($data)
{
    global $koneksi;
    global $tanggal;
    global $jam;
    $rfidP = $data['Data1'];
    $rfidB = $data['Data2'];
    $Da4 = $data['Data3'];
    $mode = $data['sendMode'];

    mysqli_query($koneksi, "INSERT INTO peminjaman VALUES (NULL, '$rfidP', '$rfidB', '2022-05-02','0000-00-00', 0)");

    mysqli_query($koneksi, "UPDATE buku SET status = 0 WHERE RFIDB = '$rfidB'");
    return mysqli_affected_rows($koneksi);
}

function kembali($data)
{
    global $koneksi;
    global $tanggal;
    global $jam;
    $rfidP = $data['Data1'];
    $rfidB = $data['Data2'];
    $Da4 = $data['Data3'];
    $mode = $data['sendMode'];

    mysqli_query($koneksi, "UPDATE peminjaman, buku SET tanggalKembali='$tanggal', status=1 WHERE peminjaman.RFIDB=buku.RFIDB AND RFIDP='$rfidP' AND buku.RFIDB='$rfidB' AND tanggalKembali='0000-00-00'");
    return mysqli_affected_rows($koneksi);
}

function absen($data)
{
    global $koneksi;
    global $tanggal;
    global $jam;
    $rfidP = $data['Data1'];
    $temp = $data['Data2'];
    $Da4 = $data['Data3'];
    $mode = $data['sendMode'];

    mysqli_query($koneksi, "INSERT INTO absensi VALUES (NULL, '$rfidP', '$tanggal', '$jam','$temp')");

    $nama = query("SELECT namaAnggota FROM anggota WHERE RFIDP = '$rfidP'")[0];
    echo "nama:" . $nama['namaAnggota'] . "|";

    return mysqli_affected_rows($koneksi);
}

function registrasi($data)
{
    global $koneksi;
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    $result = mysqli_query($koneksi, "SELECT username FROM tbl_users WHERE username = '$username' ");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
				alert('username sudah ada');
			</script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>
				alert('konfirmasi password tidak sesuai');
			</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO tbl_users VALUES (NULL, '$username', '$password', 'Penjualll', '2', '20000', '1')");

    return mysqli_affected_rows($koneksi);
}
