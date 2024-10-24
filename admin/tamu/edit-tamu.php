<?php 
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login.php");
    exit();
}

include('../../database/konekdb.php'); 

$tamu_id = $_GET['tamu_id'] ?? '';
$query = "SELECT t.tamu_id, t.tamu_name, t.tamu_address, t.keterangan, t.waktu_kedatangan, t.tamu_telp, t.tamu_email, t.kategori_id
FROM tb_tamu t
WHERE t.tamu_id = ? AND t.admin_id = ?";
$params = array($tamu_id, $_SESSION['adn_global']->admin_id);
$tamu_query = sqlsrv_query($conn, $query, $params);

if (!sqlsrv_has_rows($tamu_query)) {
    header("Location: ../history.php");
    exit();
}

$row = sqlsrv_fetch_array($tamu_query, SQLSRV_FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tamu_name = $_POST['tamu_name'];
    $tamu_address = $_POST['tamu_address'];
    $keterangan = $_POST['keterangan'];
    $tamu_telp = $_POST['tamu_telp'];
    $tamu_email = $_POST['tamu_email'];
    $kategori_id = $_POST['kategori_id'];

    $update_query = "UPDATE tb_tamu 
                     SET tamu_name = ?, tamu_address = ?, keterangan = ?, tamu_telp = ?, tamu_email = ?, kategori_id = ? 
                     WHERE tamu_id = ?";
    
    $params_update = array($tamu_name, $tamu_address, $keterangan, $tamu_telp, $tamu_email, $kategori_id, $tamu_id);
    $update_result = sqlsrv_query($conn, $update_query, $params_update);

    if ($update_result) {
        header("Location: ../history.php");
        exit();
    } else {
        die(print_r(sqlsrv_errors(), true)); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Tamu</title>
    <link rel="icon" type="image/png/jpg" href="../../img/icon.png" sizes="32x32">
    <link rel="stylesheet" href="../../css/page-edit-tamu.css">
</head>
<body>
    <header>
        <h1>Edit Tamu Bullworth</h1>
        <ul>
            <li><a href="../dashboard.php">Dashboard</a></li>
            <li><a href="../profil.php">Profil</a></li>
            <li><a href="../history.php">Riwayat</a></li>
        </ul>
    </header>

    <div class="section">
        <h3>Edit Data Tamu</h3>
        <div class="box">
            <form method="POST">
                <label>Nama Tamu:</label>
                <input type="text" name="tamu_name" value="<?php echo $row['tamu_name']; ?>" required>

                <label>Alamat:</label>
                <input type="text" name="tamu_address" value="<?php echo $row['tamu_address']; ?>" required>

                <label>Keterangan:</label>
                <textarea name="keterangan" required><?php echo $row['keterangan']; ?></textarea>

                <label>No. Telp:</label>
                <input type="text" name="tamu_telp" value="<?php echo $row['tamu_telp']; ?>" required>

                <label>Email:</label>
                <input type="email" name="tamu_email" value="<?php echo $row['tamu_email']; ?>" required>

                <label>Kategori Tamu:</label>
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

                <input type="submit" value="Simpan Perubahan">
            </form>
        </div>
    </div>

    <footer>
        <small>Copyright &copy; 2024 - Satrio Wisnu Adi Pratama</small>
    </footer>
</body>
</html>
