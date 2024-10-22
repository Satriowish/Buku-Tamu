<?php 
session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
include('../database/konekdb.php'); 

$admin_id = $_SESSION['adn_global']->admin_id;

$query = "SELECT t.tamu_id, t.tamu_name, t.keterangan, t.tamu_address, t.waktu_kedatangan
FROM tb_tamu t
WHERE t.admin_id = ?";

$params = array($admin_id); 
$tamu_query = sqlsrv_query($conn, $query, $params);

// cek apakah berhasil
if (!$tamu_query) {
    die("Error pada query SQL: " . print_r(sqlsrv_errors(), true));
}

if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];
    $delete_query = "DELETE FROM tb_tamu WHERE tamu_id = ?";
    $params_delete = array($hapus_id);
    $delete_result = sqlsrv_query($conn, $delete_query, $params_delete);

    if ($delete_result) {
        echo '<script>window.location="history.php";</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan saat menghapus tamu.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | History</title>
    <link rel="icon" type="image/png/jpg" href="../img/icon.png" sizes="32x32">
    <link rel="stylesheet" href="../css/history.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Riwayat Daftar Tamu</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php"><img style="width: 15px" 
                src="https://img.icons8.com/external-kmg-design-detailed-outline-kmg-design/64/ffffff/external-logout-real-estate-kmg-design-detailed-outline-kmg-design.png" /></a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>Daftar Tamu</h3>
            
            <!-- data Tamu -->
            <div class="box">
                <table border="1" cellspacing="0" cellpadding="10">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Waktu Kedatangan</th>
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>

                    
                    <?php
                    // logika anjay 

                    if (sqlsrv_has_rows($tamu_query)) {
                        while ($row = sqlsrv_fetch_array($tamu_query, SQLSRV_FETCH_ASSOC)) {

                        echo '<tr>';
                        // mengubah link nama tamu menjadi link ke halaman data tamu yang bersangkutan
                        echo '<td><a href="tamu/data-tamu.php?tamu_id=' . $row['tamu_id'] . '">' 
                        . htmlspecialchars($row['tamu_name']) . '</a></td>';

                        echo '<td>' . htmlspecialchars($row['tamu_address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['keterangan']) . '</td>';
                        echo '<td>' . $row['waktu_kedatangan']->format('Y-m-d H:i:s') . '</td>';
                        echo '<td>';
                        echo '<div class="action-buttons">';

                        // edit tamu
                        echo '<a href="tamu/edit-tamu.php?tamu_id=' . $row['tamu_id'] . '" class="edit-btn">Edit</a>';
                        // hapus tamu
                        echo '<a href="?hapus_id=' . $row['tamu_id'] . 
                        '" class="delete-btn" onclick="return confirm(\'Apakah Anda yakin ingin menghapus tamu ini?\')">Hapus</a>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                      }
                    } else {
                        echo '<tr><td colspan="5">Tidak ada data tamu yang ditemukan.</td></tr>';
                    }
                    ?>
                    
                    </tbody>
                    </tbody>
                </table>
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
