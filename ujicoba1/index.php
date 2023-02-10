<?php
session_start();

// Users data
$users = [
  [
    'username' => 'user1',
    'password' => 'password1',
    'nama' => 'User 1',
    'email' => 'user1@example.com',
    'saldo' => 100000
  ],
  [
    'username' => 'user2',
    'password' => 'password2',
    'nama' => 'User 2',
    'email' => 'user2@example.com',
    'saldo' => 200000
  ],
];

// Login form submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if username and password match
  $logged_in_user = null;
  foreach ($users as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
      $logged_in_user = $user;
      break;
    }
  }

  if ($logged_in_user) {
    // Login success, store user data in session
    $_SESSION['user'] = $logged_in_user;
  } else {
    // Login failed
    echo "Username atau password salah.";
    echo "<br>";
  }
}

// Logout request
if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
}

// Check if user is already logged in
if (isset($_SESSION['user'])) {
  $logged_in_user = $_SESSION['user'];

  // Buy form submitted
  if (isset($_GET['buy_from']) && isset($_POST['harga']) && isset($_POST['jumlah'])) {
    $buy_from_username = $_GET['buy_from'];
    $harga = intval($_POST['harga']);
    $jumlah = intval($_POST['jumlah']);

    // Find the seller user
    $seller = null;
    foreach ($users as &$user) {
      if ($user['username'] === $buy_from_username) {
        $seller = &$user;
        break;
      }
    }

    if ($seller) {
      $total_harga = $harga * $jumlah;

      if ($logged_in_user['saldo'] >= $total_harga) {
        // Buy success, update the buyer and seller balances
        $logged_in_user['saldo'] -= $total_harga;
        $seller['saldo'] += $total_harga;

        echo "Anda berhasil membeli $jumlah barang seharga $total_harga dari $buy_from_username.";
        echo "<br>";
      } else {
        // Buy failed, not enough balance
        echo "Saldo Anda tidak cukup untkan membeli $jumlah barang seharga $total_harga dari $buy_from_username.";
        echo "<br>";
        }
        } else {
        // Buy failed, seller not found
        echo "Penjual tidak ditemukan.";
        echo "<br>";
        }
        }
        
        // Show dashboard
        echo "Selamat datang, " . $logged_in_user['nama'] . "!";
        echo "<br>";
        echo "Saldo Anda: " . $logged_in_user['saldo'];
        echo "<br>";
        echo "Email Anda: " . $logged_in_user['email'];
        echo "<br>";
        echo "<a href='?logout'>Logout</a>";
        echo "<br>";
        echo "<br>";
        echo "Penjual:";
        echo "<br>";
        
        // Show available sellers
        foreach ($users as $user) {
        if ($user['username'] !== $logged_in_user['username']) {
        echo $user['nama'] . " (" . $user['username'] . ")";
        echo "<br>";
        echo "Saldo: " . $user['saldo'];
        echo "<br>";
        echo "Email: " . $user['email'];
        echo "<br>";
        echo "<a href='?buy_from=" . $user['username'] . "'>Beli</a>";
        echo "<br>";
        echo "<br>";
        }
        }
        
        // Show buy form
        if (isset($_GET['buy_from'])) {
        $buy_from_username = $_GET['buy_from'];
        echo "Form beli dari $buy_from_username:";
        echo "<br>";
        echo "<form action='?buy_from=$buy_from_username' method='post'>";
        echo "Harga: <input type='text' name='harga'><br>";
        echo "Jumlah: <input type='text' name='jumlah'><br>";
        echo "<input type='submit' value='Beli'>";
        echo "</form>";
        }
        } else {
        // Show login form
        echo "Form login:";
        echo "<br>";
        echo "<form action='' method='post'>";
        echo "Username: <input type='text' name='username'><br>";
        echo "Password: <input type='password' name='password'><br>";
        echo "<input type='submit' value='Login'>";
        echo "</form>";
        }
        ?>
