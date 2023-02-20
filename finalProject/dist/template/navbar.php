<?php
if (!session_id()) {
   session_start();
   require '../function/function.php';
}


$idUser = $_SESSION["idUser"];

$queryUser = query("SELECT * FROM tbl_users WHERE idUser = '$idUser'")[0];
$role = $queryUser["role"];



if ($role == 1) {
   $queryUser = query("SELECT * FROM tbl_users U, tbl_admin A WHERE U.idDetailUser = A.idDetailUser AND idUser = '$idUser'")[0];
   // var_dump($queryUser);
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




?>

<div class="flex gap-3 items-center justify-items-center p-3 sticky top-0 shadow-md bg-white z-30">
   <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
      type="button"
      class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
      <span class="sr-only">Open sidebar</span>
      <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
         xmlns="http://www.w3.org/2000/svg">
         <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
         </path>
      </svg>
   </button>
   <div class="flex items-center">
      <h3 class="font-poppins font-bold">Student Spending Managemet
      </h3>
   </div>
</div>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full"
   aria-label="Sidebar">
   <div class="bg-white">
      <div class="grid grid-cols-3 items-center h-28 w-full bg-primary rounded-br-2xl">
         <img src="assets/images/avatar/<?= $profileImage; ?>" alt="avatar"
            class="object-cover rounded-full h-16 w-16 ml-3">
         <div class="col-span-2">
            <h3 class="font-poppins font-bold text-white">
               <?= $realName; ?>
            </h3>
            <h3 class="font-poppins font-bold text-white">
               <?="Rp " . number_format($saldo, 0, ",", ".") ?>
            </h3>
         </div>
      </div>
   </div>
   <div class="h-full px-3 py-4 overflow-y-auto bg-white">

      <ul class="space-y-2">
         <?php if ($_SESSION["currentPage"] == "dashboard"): ?>
            <li>
               <a href="index.php" data-drawer-toggle="default-sidebar"
                  class="flex items-center p-2 text-base font-normal rounded-lg bg-primary hover:bg-opacity-80 ">

                  <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-white transition duration-75"
                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                        d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                        clip-rule="evenodd"></path>
                  </svg>
                  <span class="ml-3 font-poppins text-white">Dashboard</span>
               </a>
            </li>
         <?php else: ?>
            <li>
               <a href="index.php" data-drawer-toggle="default-sidebar"
                  class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">

                  <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                        d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                        clip-rule="evenodd"></path>
                  </svg>
                  <span class="ml-3 font-poppins">Dashboard</span>
               </a>
            </li>
         <?php endif; ?>






         <?php if ($role != 1): ?>
            <?php if ($_SESSION["currentPage"] == "profile"): ?>
               <li>
                  <a href="profile.php" data-drawer-toggle="default-sidebar"
                     class="flex items-center p-2 text-base font-normal rounded-lg bg-primary hover:bg-opacity-80">
                     <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-white transition duration-75"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                        </path>
                     </svg>
                     <span class="ml-3 font-poppins text-white whitespace-nowrap">Profil</span>
                  </a>
               </li>
            <?php else: ?>
               <li>
                  <a href="profile.php" data-drawer-toggle="default-sidebar"
                     class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
                     <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                        </path>
                     </svg>
                     <span class="flex-1 ml-3 whitespace-nowrap">Profil</span>
                  </a>
               </li>

            <?php endif; ?>
         <?php endif; ?>
         <?php if ($role == 2): ?>
            <?php if ($_SESSION["currentPage"] == "entryMenu"): ?>
               <li>
                  <a href="entryMenu.php" data-drawer-toggle="default-sidebar"
                     class="flex items-center p-2 text-base font-normal rounded-lg bg-primary hover:bg-opacity-80">
                     <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-white transition duration-75"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                           d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                           clip-rule="evenodd"></path>
                     </svg>
                     <span class="ml-3 font-poppins text-white whitespace-nowrap">Buat Pesanan</span>
                  </a>
               </li>
            <?php else: ?>
               <li>
                  <a href="entryMenu.php" data-drawer-toggle="default-sidebar"
                     class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
                     <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                           d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                           clip-rule="evenodd"></path>
                     </svg>
                     <span class="ml-3 whitespace-nowrap">Buat Pesanan</span>
                  </a>
               </li>
            <?php endif; ?>
         <?php elseif ($role == 3): ?>
            <?php if ($_SESSION["currentPage"] == "pay"): ?>
               <li>
                  <a href="pay.php" data-drawer-toggle="default-sidebar"
                     class="flex items-center p-2 text-base font-normal rounded-lg bg-primary hover:bg-opacity-80">
                     <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-white transition duration-75"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                           d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                           clip-rule="evenodd"></path>
                     </svg>
                     <span class="ml-3 font-poppins text-white whitespace-nowrap">Bayar Pesanan</span>
                  </a>
               </li>
            <?php else: ?>
               <li>
                  <a href="pay.php" data-drawer-toggle="default-sidebar"
                     class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
                     <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                           d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                           clip-rule="evenodd"></path>
                     </svg>
                     <span class="ml-3 whitespace-nowrap">Bayar Pesanan</span>
                  </a>
               </li>
            <?php endif; ?>
         <?php endif; ?>
         <!-- <li>
           <a href="#" data-drawer-toggle="default-sidebar" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
              <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
              <span class="flex-1 ml-3 whitespace-nowrap">Kanban</span>
              <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
           </a>
        </li>
        
        <li>
           <a href="#" data-drawer-toggle="default-sidebar" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
              <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
              <span class="flex-1 ml-3 whitespace-nowrap">Inbox</span>
              <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
           </a>
        </li> -->

         <?php if ($_SESSION["currentPage"] == "transaction"): ?>
            <li>
               <a href="transactionHistory.php" data-drawer-toggle="default-sidebar"
                  class="flex items-center p-2 text-base font-normal rounded-lg bg-primary hover:bg-opacity-80">
                  <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75" fill="currentColor"
                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                     <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                  </svg>
                  <span class="ml-3 font-poppins text-white whitespace-nowrap">Transaksi</span>
               </a>
            </li>
         <?php else: ?>
            <li>
               <a href="transactionHistory.php" data-drawer-toggle="default-sidebar"
                  class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
                  <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75" fill="currentColor"
                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                     <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                  </svg>
                  <span class="flex-1 ml-3 whitespace-nowrap">Transaksi</span>
               </a>
            </li>
         <?php endif; ?>
         <li>
            <a href="logout.php" data-drawer-toggle="default-sidebar"
               class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg">
               <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
                  fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                     clip-rule="evenodd"></path>
               </svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Log Out</span>
            </a>
         </li>

      </ul>
   </div>
</aside>