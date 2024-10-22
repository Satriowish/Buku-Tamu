<?php 
  // Informasi koneksi
$serverName = "SATRIOWISNU\SQLEXPRESS"; // Nama server saya
$connectionOptions = array(
  "Database" => "db_buku_tamu",  // Nama database diserver saya
  "Uid" => "",             
  "PWD" => ""              
);

// Membuat koneksi ke SQL Server
$conn = sqlsrv_connect($serverName, $connectionOptions);

// cek koneksi berhasil atau gagal
if ($conn === false) {
  die(print_r(sqlsrv_errors(), true)); // error
} else {
  // echo "Koneksi berhasil ke SQL Server!";
}
?>
