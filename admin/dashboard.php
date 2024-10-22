<?php 
  session_start();
  if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
  }
  include('../database/konekdb.php'); 

  // mengambil data dari form
  if (isset($_POST['submit'])) {
      $tamu_name = $_POST['tamu_name'];
      $keterangan = $_POST['keterangan'];  
      $tamu_telp = $_POST['tamu_telp'];
      $tamu_email = $_POST['tamu_email'];
      $tamu_address = $_POST['tamu_address'];
      $kategori_id = $_POST['kategori_id'];

      // menambahkan data tamu ke database
      $query = "INSERT INTO tb_tamu (tamu_name, keterangan, tamu_telp, tamu_email, tamu_address, kategori_id, admin_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
      $params = array($tamu_name, $keterangan, $tamu_telp, $tamu_email, $tamu_address, $kategori_id, $_SESSION['adn_global']->admin_id);
      
      $tamu_query = sqlsrv_query($conn, $query, $params);

      if ($tamu_query) {
          echo "<script>window.location='dashboard.php';</script>";  
      } else {
          echo "<script>window.location='dashboard.php';</script>";  
      }
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
</head>
<body>
  <header>
    <div class="container">
      <h1><a href="dashboard.php">Bullworth Academy Guest</a></h1>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="history.php">History</a></li>
        <li><a href="logout.php"><img style="width: 15px" src="https://img.icons8.com/external-kmg-design-detailed-outline-kmg-design/64/ffffff/external-logout-real-estate-kmg-design-detailed-outline-kmg-design.png" /></a></li>
      </ul>
    </div>
  </header>

  <div class="section">
    <div class="container">
      <h3>Dashboard</h3>
      <div class="box">
        <h4>Selamat Datang <?php echo $_SESSION['adn_global']->admin_name; ?> di Bullworth Academy Guest</h4>
      </div>

      <!-- form menambah tamu -->
      <div class="box">
        <h4>Tambah Tamu Baru</h4>
        <form action="" method="POST">
          <label for="tamu_name">Nama Tamu:</label>
          <input type="text" name="tamu_name" required><br>

          <label for="keterangan">Keterangan:</label> 
          <input type="text" name="keterangan" required><br>

          <label for="tamu_telp">No. Telp:</label>
          <input type="text" name="tamu_telp" required><br>

          <label for="tamu_email">Email:</label>
          <input type="email" name="tamu_email"><br>

          <label for="tamu_address">Alamat:</label>
          <textarea name="tamu_address" name="tamu_address"></textarea><br>

          <label for="kategori_id">Kategori Tamu:</label>
          <select name="kategori_id" required>
            <option value="" disabled selected>Pilih Kategori</option>
            <?php
              // mengambil kategori dari database
              $kategori_query = sqlsrv_query($conn, "SELECT * FROM tb_kategori");
              while ($kategori = sqlsrv_fetch_array($kategori_query, SQLSRV_FETCH_ASSOC)) {
                echo "<option value='".$kategori['kategori_id']."'>".$kategori['kategori_name']."</option>";
              }
            ?>
          </select><br>
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
