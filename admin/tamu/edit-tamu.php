<?php 
session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit();
}
include('../../database/konekdb.php'); 

// mengambil tamu_id dari URL
$tamu_id = isset($_GET['tamu_id']) ? $_GET['tamu_id'] : '';

// mengambil data tamu berdasarkan tamu_id
$query = "SELECT t.tamu_id, t.tamu_name, t.tamu_address, t.keterangan, t.waktu_kedatangan, t.tamu_telp, t.tamu_email, t.kategori_id
FROM tb_tamu t
WHERE t.tamu_id = ? AND t.admin_id = ?";

$params = array($tamu_id, $_SESSION['adn_global']->admin_id);
$tamu_query = sqlsrv_query($conn, $query, $params);

// mengecek tamu
if (sqlsrv_has_rows($tamu_query)) {
    $row = sqlsrv_fetch_array($tamu_query, SQLSRV_FETCH_ASSOC);
} else {
    echo '<script>window.location="../history.php";</script>';
    exit();
}

// update data tamu 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tamu_name = $_POST['tamu_name'];
    $tamu_address = $_POST['tamu_address'];
    $keterangan = $_POST['keterangan'];
    $tamu_telp = $_POST['tamu_telp'];
    $tamu_email = $_POST['tamu_email'];
    $kategori_id = $_POST['kategori_id'];

    $waktu_kedatangan = isset($_POST['waktu_kedatangan']) ? $_POST['waktu_kedatangan'] : null;

    $update_query = "UPDATE tb_tamu 
                     SET tamu_name = ?, tamu_address = ?, keterangan = ?, tamu_telp = ?, tamu_email = ?, kategori_id = ? 
                     WHERE tamu_id = ?";
    
    $params_update = array($tamu_name, $tamu_address, $keterangan, $tamu_telp, $tamu_email, $kategori_id, $tamu_id);
    $update_result = sqlsrv_query($conn, $update_query, $params_update);

    if ($update_result) {
        echo '<script>window.location="../history.php";</script>';
    } else {
        die(print_r(sqlsrv_errors(), true)); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Tamu</title>
    <link rel="icon" type="image/png/jpg" href="../../img/icon.png" sizes="32x32">
    <link rel="stylesheet" href="../../css/page-edit-tamu.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Edit Tamu Bullworth</a></h1>
            <ul>
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="../profil.php">Profil</a></li>
                <li><a href="../history.php">Riwayat</a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>Edit Data Tamu</h3>

            <!-- form edit tamu -->
            <div class="box">
                <form action="" method="POST">
                    <label for="tamu_name">Nama Tamu:</label>
                    <input type="text" name="tamu_name" value="<?php echo htmlspecialchars($row['tamu_name']); ?>" required>

                    <label for="tamu_address">Alamat:</label>
                    <input type="text" name="tamu_address" value="<?php echo htmlspecialchars($row['tamu_address']); ?>" required>

                    <label for="keterangan">Keterangan:</label>
                    <textarea name="keterangan" required><?php echo htmlspecialchars($row['keterangan']); ?></textarea>

                    <label for="tamu_telp">No. Telp:</label>
                    <input type="text" name="tamu_telp" value="<?php echo htmlspecialchars($row['tamu_telp']); ?>" required>

                    <label for="tamu_email">Email:</label>
                    <input type="email" name="tamu_email" value="<?php echo htmlspecialchars($row['tamu_email']); ?>" required>

                    <label for="kategori_id">Kategori Tamu:</label>
                    <select name="kategori_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php
                            $kategori_query = sqlsrv_query($conn, "SELECT * FROM tb_kategori");
                            while ($kategori = sqlsrv_fetch_array($kategori_query, SQLSRV_FETCH_ASSOC)) {
                                echo "<option value='".$kategori['kategori_id']."' "
                                 . ($kategori['kategori_id'] == $row['kategori_id'] ? 'selected' : '') 
                                 . ">".$kategori['kategori_name']."</option>";
                            }
                        ?>
                    </select>

                    <!-- submit -->
                    <input type="submit" value="Simpan Perubahan" class="login-btn">
                </form>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - Satrio Wisnu Adi Pratama</small>
        </div>
    </footer>
</body>
</html>
