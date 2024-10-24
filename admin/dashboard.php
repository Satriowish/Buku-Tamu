<?php 
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login.php");
    exit();
}

include('../database/konekdb.php'); 

// Cek apakah form disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $tamu_name = $_POST['tamu_name'];
    $keterangan = $_POST['keterangan'];  
    $tamu_telp = $_POST['tamu_telp'];
    $tamu_email = $_POST['tamu_email'];
    $tamu_address = $_POST['tamu_address'];
    $kategori_id = $_POST['kategori_id'];

    // Query untuk menambahkan data tamu
    $query = "INSERT INTO tb_tamu (tamu_name, keterangan, tamu_telp, tamu_email, tamu_address, kategori_id, admin_id) 
              VALUES ('$tamu_name', '$keterangan', '$tamu_telp', '$tamu_email', '$tamu_address', '$kategori_id', '".$_SESSION['adn_global']->admin_id."')";

    // Eksekusi query
    $tamu_query = sqlsrv_query($conn, $query);

    // Redirect ke dashboard
    if ($tamu_query) {
        header("Location: dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Bullworth Academy</title>
    <link rel="icon" type="image/png/jpg" href="../img/icon.png" sizes="32x32">
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/page-dashboard.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Bullworth Academy Guest</a></h1>
            <ul>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="history.php">Riwayat</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>Dashboard</h3>
            <div class="box">
                <h4>Selamat Datang <?php echo $_SESSION['adn_global']->admin_name; ?> di Bullworth Academy Guest</h4>
            </div>

            <div class="box">
                <h4>Tambah Tamu Baru</h4>
                <form action="" method="POST">
                    <label for="tamu_name">Nama Tamu:</label>
                    <input type="text" name="tamu_name" required>

                    <label for="keterangan">Keterangan:</label>
                    <input type="text" name="keterangan" required>

                    <label for="tamu_telp">No. Telp:</label>
                    <input type="text" name="tamu_telp" required>

                    <label for="tamu_email">Email:</label>
                    <input type="email" name="tamu_email">

                    <label for="tamu_address">Alamat:</label>
                    <textarea name="tamu_address" required></textarea>

                    <label for="kategori_id">Kategori Tamu:</label>
                    <select name="kategori_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php
                        $kategori_query = sqlsrv_query($conn, "SELECT * FROM tb_kategori");
                        while ($kategori = sqlsrv_fetch_array($kategori_query, SQLSRV_FETCH_ASSOC)) {
                            echo "<option value='{$kategori['kategori_id']}'>{$kategori['kategori_name']}</option>";
                        }
                        ?>
                    </select>
                    
                    <input type="submit" name="submit" value="Tambah Tamu">
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

