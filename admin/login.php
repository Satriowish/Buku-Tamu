<?php 
  if (isset($_POST['submit'])) {
    session_start();
    include '../database/konekdb.php'; // Koneksi ke database

    // Amankan input dengan htmlspecialchars untuk mencegah XSS
    $user = htmlspecialchars($_POST['user']);
    $pass = htmlspecialchars($_POST['pass']);
    $hashed_pass = md5($pass); // Simpan password menggunakan MD5 (lebih baik menggunakan algoritma lebih aman seperti bcrypt)

    // Query untuk mengecek user di database
    $sql = "SELECT * FROM tb_admin WHERE username = ? AND password = ?";
    $params = array($user, $hashed_pass);

    // Menjalankan query dengan prepared statement
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Mengecek apakah query berhasil dan ada user yang ditemukan
    if (sqlsrv_has_rows($stmt)) {
      $c = sqlsrv_fetch_object($stmt);
      $_SESSION['status_login'] = true;
      $_SESSION['adn_global'] = $c;
      $_SESSION['id'] = $c->admin_id;

      // Langsung redirect ke dashboard
      header('Location: dashboard.php');
      exit;
    } else {
      // Redirect ke halaman login dengan error jika login gagal
      header('Location: login.php?error=invalid_user');
      exit;
    }
  }
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bullworth Academy</title>

  <link rel="icon" type="image/png/jpg" href="../img/icon.png" sizes="32x32">
  
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/form-login.css">
</head>
<body>
  <div class="box-login">
    <h2>Login</h2>
    <form action="" method="POST">
      <input type="text" name="user" placeholder="Username" class="input-control">
      <input type="password" name="pass" placeholder="Password" class="input-control">
      <input type="submit" name="submit" value="Login" class="login-btn">
    </form>
  </div>
</body>
</html>