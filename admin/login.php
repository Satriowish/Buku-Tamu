<?php 
if (isset($_POST['submit'])) {
    session_start();
    include '../database/konekdb.php'; 
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hashed_pass = md5($pass); 
    $sql = "SELECT * FROM tb_admin WHERE username = '$user' AND password = '$hashed_pass'";
    $stmt = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($stmt)) {
        $c = sqlsrv_fetch_object($stmt);
        $_SESSION['status_login'] = true;
        $_SESSION['adn_global'] = $c;
        $_SESSION['id'] = $c->admin_id;
        header('Location: dashboard.php');
        exit;
    } else {
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
  <title>Bullworth Guest</title>

  <link rel="icon" type="image/png/jpg" href="../img/icon.png" sizes="32x32">
  
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/page-login-user.css">
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