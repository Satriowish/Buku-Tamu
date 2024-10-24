<?php 
session_start();
include '../database/konekdb.php'; 
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header('Location: login.php');
    exit();
}
$query = sqlsrv_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '" . $_SESSION['id'] . "'");
$d = sqlsrv_fetch_object($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title style="padding: 10px 0px;">Profil | Guest Bullworth</title>
  <link rel="icon" type="image/png/jpg" href="../img/icon.png" sizes="32x32">
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/page-profil.css">
</head>
<body>
  <header>
    <div class="container">
      <h1><a href="dashboard.php">Guest Bullworth</a></h1>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="history.php">Riwayat</a></li>
        <li><a href="logout.php">logout</a></li>
      </ul>
    </div>
  </header>
  <div class="section">
    <div class="container">
        <h3>Profil</h3>
        <div class="box">
            <form method="POST">
                <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d->admin_name; ?>" required>
                <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d->username; ?>" required>
                <input type="text" name="hp" placeholder="No Hp" class="input-control" value="<?php echo $d->admin_telp; ?>" required>
                <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $d->admin_email; ?>" required>
                <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo $d->admin_address; ?>" required>
                <input type="submit" name="submit" value="Ubah Profil" class="login-btn">
            </form>

            <?php 
            if (isset($_POST['submit'])) {
                $nama = ucwords($_POST['nama']);
                $user = $_POST['user'];
                $hp = $_POST['hp']; 
                $email = ucwords($_POST['email']);
                $alamat = $_POST['alamat'];

                $update = sqlsrv_query($conn, "UPDATE tb_admin SET
                    admin_name = '$nama', 
                    username = '$user', 
                    admin_telp = '$hp', 
                    admin_email = '$email', 
                    admin_address = '$alamat' 
                    WHERE admin_id = '".$d->admin_id."'");

                if ($update) {
                    echo '<script>window.location="dashboard.php"</script>';
                } else {
                    echo 'gagal: ' . print_r(sqlsrv_errors(), true);
                }
            }
            ?>
        </div>

        <h3>Ubah Password</h3>
        <div class="box">
            <form method="POST">
                <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
                <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
                <input type="submit" name="ubah_password" value="Ubah Password" class="login-btn">
            </form>

            <?php 
            if (isset($_POST['ubah_password'])) {
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];

                if ($pass2 != $pass1) {
                    echo '<script>alert("Password Tidak Sesuai")</script>';
                } else {
                    $update_pass = sqlsrv_query($conn, "UPDATE tb_admin SET
                        password = '".md5($pass1)."' 
                        WHERE admin_id = '".$d->admin_id."'");

                    if ($update_pass) {
                        echo '<script>window.location="dashboard.php"</script>';
                    } else {
                        echo 'gagal: ' . print_r(sqlsrv_errors(), true);
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<footer style="padding: 25px 0px;">
    <div class="container">
        <small>Copyright &copy; 2024 - Satrio Wisnu Adi Pratama</small>
    </div>
</footer>
