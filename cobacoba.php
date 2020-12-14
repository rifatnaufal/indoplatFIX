<?php

require("db.php");
$sql_pesanan = "SELECT * FROM pesanan";
$result = mysqli_query($conn, $sql_pesanan);
$rowcount = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if (!$row) {
  //"kosong gan"
  $kodepesanan = 'pes-1';
} else {
  $kodepesanan = 'pes-' . (intval($rowcount) + 1);

  echo '<br>';
}
echo $kodepesanan;
$sql_inputPesanan = "INSERT INTO pesanan (kode_pesanan, nama_pemesan, nama_pesanan, jumlah_pesanan, banyak_pengiriman, status) VALUES ('$kodepesanan','hehe','rtr','1000','1','on process')";
$result = mysqli_query($conn, $sql_inputPesanan);
