<?php 
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
include('../database/konekdb.php'); 

$admin_id = $_SESSION['adn_global']->admin_id;

// Query untuk mengambil data tamu
$tamu_query = sqlsrv_query($conn, 
"SELECT t.tamu_id, t.tamu_name, 
        t.keterangan, t.tamu_address, 
        t.waktu_kedatangan FROM tb_tamu t 
        WHERE t.admin_id = '$admin_id'");

// Cek apakah berhasil
if (!$tamu_query) {
    die("Error pada query SQL: " . print_r(sqlsrv_errors(), true));
}

// Hapus tamu jika ada ID yang diterima
if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];
    $delete_result = sqlsrv_query($conn, "DELETE FROM tb_tamu WHERE tamu_id = '$hapus_id'");

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
    <title>Admin | Riwayat Tamu</title>
    <link rel="icon" type="image/png/jpg" href="../img/icon.png" sizes="32x32">
    <link rel="stylesheet" href="../css/page-riwayat.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Riwayat Daftar Tamu</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">logout</a></li>
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
                     if (sqlsrv_has_rows($tamu_query)) {
                       while ($row = sqlsrv_fetch_array($tamu_query, SQLSRV_FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td><a href="tamu/data-tamu.php?tamu_id=' . $row['tamu_id'] . '">' . $row['tamu_name'] . '</a></td>';
                        echo '<td>' . $row['tamu_address'] . '</td>';
                        echo '<td>' . $row['keterangan'] . '</td>';
                        echo '<td>' . $row['waktu_kedatangan']->format('Y-m-d H:i:s') . '</td>';
                        echo '<td>';
                        echo '<div class="action-buttons">';
                        echo '<a href="tamu/edit-tamu.php?tamu_id=' . $row['tamu_id'] . '" class="edit-btn">Edit</a>';
                        echo '<a href="?hapus_id=' . $row['tamu_id'] . '" class="delete-btn" onclick="return confirm(\'Hapus?\')">Hapus</a>';
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
