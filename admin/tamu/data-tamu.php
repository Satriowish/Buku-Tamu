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

// mengecek apakah tamu ditemukan
if (sqlsrv_has_rows($tamu_query)) {
    $row = sqlsrv_fetch_array($tamu_query, SQLSRV_FETCH_ASSOC);
} else {
    echo '<script>alert("Tamu tidak ditemukan!"); window.location="../history.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tamu</title>
    <link rel="icon" type="image/png/jpg" href="../../img/icon.png" sizes="32x32">
    <link rel="stylesheet" href="../../css/data-tamu.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="../dashboard.php">Detail Tamu</a></h1>
            <ul>
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="../profil.php">Profil</a></li>
                <li><a href="../history.php">History</a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>Detail Data Tamu</h3>

            <!-- display data tamu -->
            <div class="box">
                <div class="detail-item">
                    <label for="tamu_name">Nama Tamu:</label>
                    <input type="text" name="tamu_name" value="<?php echo htmlspecialchars($row['tamu_name']); ?>" readonly>
                </div>

                <div class="detail-item">
                    <label for="tamu_address">Alamat:</label>
                    <input type="text" name="tamu_address" value="<?php echo htmlspecialchars($row['tamu_address']); ?>" readonly>
                </div>

                <div class="detail-item">
                    <label for="keterangan">Keterangan:</label>
                    <textarea name="keterangan" readonly><?php echo htmlspecialchars($row['keterangan']); ?></textarea>
                </div>

                <div class="detail-item">
                    <label for="tamu_telp">No. Telp:</label>
                    <input type="text" name="tamu_telp" value="<?php echo htmlspecialchars($row['tamu_telp']); ?>" readonly>
                </div>

                <div class="detail-item">
                    <label for="tamu_email">Email:</label>
                    <input type="email" name="tamu_email" value="<?php echo htmlspecialchars($row['tamu_email']); ?>" readonly>
                </div>

                <div class="detail-item">
                    <label for="kategori_id">Kategori Tamu:</label>
                    <input type="text" value="<?php 
                        // mengambil kategori dari database
                        $kategori_query = sqlsrv_query($conn, "SELECT kategori_name FROM tb_kategori WHERE kategori_id = " . $row['kategori_id']);
                        $kategori = sqlsrv_fetch_array($kategori_query, SQLSRV_FETCH_ASSOC);
                        echo htmlspecialchars($kategori['kategori_name']); 
                    ?>" readonly>
                </div>

                <!-- Kembali -->
                <div class="input-control">
                    <button type="button" class="login-btn" onclick="window.location.href='../history.php'">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer">
            <small>Copyright &copy; 2024 - Satrio Wisnu Adi Pratama</small>
        </div>
    </footer>
</body>
</html>
