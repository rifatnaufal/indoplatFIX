<html>
<?php require 'db.php'; ?>

<body>



  Nama pemesan: <?php echo $_POST["nama"]; ?> <br>
  Part yang dipesan: <?php echo $_POST["namapart"]; ?> <br>
  Jumlah part: <?php echo $_POST["JumlahPart"]; ?> <br>
  Proses:<br>

  <?php
  //input data ke tabel pesanan 
  $namapemesan = $_POST["nama"];
  $namapart = $_POST["namapart"];
  $jumlahpart = $_POST["JumlahPart"];
  $banyakpengiriman = $_POST["banyakTanggal"];
  $sql_pesanan = "SELECT * FROM pesanan";
  $result = mysqli_query($conn, $sql_pesanan);
  $rowcount = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);
  if (!$row) {
    //"kosong gan"
    $kodepesanan = 'pes-1';
  } else {
    $kodepesanan = 'pes-' . (intval($rowcount) + 1);
    echo $kodepesanan;
    echo '<br>';
  }
  $sql_inputPesanan = "INSERT INTO pesanan (kode_pesanan, nama_pemesan, nama_pesanan, jumlah_pesanan, banyak_pengiriman) VALUES ('$kodepesanan','$namapemesan','$namapart','$jumlahpart','$banyakpengiriman')";
  $result = mysqli_query($conn, $sql_inputPesanan);

  $b = [];
  $a = $_POST['checkboxvar'];
  //fetch kode dan stok
  if (!empty($_POST['checkboxvar'])) {
    for ($i = 0; $i < count($_POST['checkboxvar']); $i++) {
      $t = $_POST['checkboxvar'][$i];
      $sql_cabang = "SELECT * from proses where kode_proses='$t'";
      $result = mysqli_query($conn, $sql_cabang);
      
      while ($r = mysqli_fetch_array($result)) {
        echo $r['nama_proses'];
        echo '<br>';
        array_push($b, $r['stok_wip']);
      }
    }
  }

  //input data ke tabel proses_pesanan

  for ($i = 0; $i < count($a); $i++) {
    $kodeproses = $a[$i];
    $sql_inputprosesPesanan = "INSERT INTO proses_pesanan (kode_pesanan, kode_proses) VALUES ('$kodepesanan','$kodeproses')";
    $result = mysqli_query($conn, $sql_inputprosesPesanan);
  }
  echo 'Tanggal pengiriman :';
  echo '<br>';

  echo 'banyak pengiriman: ' . $_POST['banyakTanggal'];
  echo '<br>';
  $tanggal_paling_awal = [];
  for ($i = 0; $i < $_POST['banyakTanggal']; $i++) {
    $hehe = 'tanggalkirim' . $i;
    echo ($_POST[$hehe]);
    echo '<br>';
    array_push($tanggal_paling_awal, $_POST[$hehe]);
  }

  //input data ke table tgl_kirim_pesanan
  for ($i = 0; $i < count($tanggal_paling_awal); $i++) {
    $tgl_kirim = $tanggal_paling_awal[$i];
    $sql_inputtglkirim = "INSERT INTO tgl_kirim_pesanan (kode_pesanan, tgl_kirim) VALUES ('$kodepesanan','$tgl_kirim')";
    $result = mysqli_query($conn, $sql_inputtglkirim);
  }


  //nampilkan kode proses dan stok

  echo 'kode proses: ';
  print_r($a);
  echo '<br>';
  echo 'stok wip:';
  print_r($b);
  echo '<br>';



  //ngurangin 7 hari untuk injeksi
  print_r($tanggal_paling_awal);
  echo '<br>';
  $date = date_create(min($tanggal_paling_awal));
  date_sub($date, date_interval_create_from_date_string("7 days"));
  if ((date_format($date, "l") == "Sunday")) {
    date_sub($date, date_interval_create_from_date_string("1 days"));
    $hari_min7 = date_format($date, "Y-m-d");
  } else {
    $hari_min7 = date_format($date, "Y-m-d");
  }


  //persiapan hari produksi
  $tgl_proses = [];
  array_push($tgl_proses, $hari_min7);
  $datekerja = date_create($hari_min7);
  echo $hari_min7;
  echo '<br>';

  for ($i = 0; $i < count($a) - 1; $i++) {
    
    date_sub($datekerja, date_interval_create_from_date_string("-1 days"));
    if ((date_format($datekerja, "l") == "Sunday")) {
      date_sub($datekerja, date_interval_create_from_date_string("-1 days"));
      $hari_pengerjaan = date_format($datekerja, "Y-m-d");
    } else {
      $hari_pengerjaan = date_format($datekerja, "Y-m-d");
    }
    $hari_min7 = $hari_pengerjaan;
    array_push($tgl_proses, $hari_pengerjaan);
  }

  echo '<br>';
  //persiapan array load produksi
  $produksi_segar = ($_POST['JumlahPart'] - array_sum($b)) + (($_POST['JumlahPart'] - array_sum($b)) * 20 / 100);
  echo 'produksi awal: ';
  echo $produksi_segar;
  $banyak_produksi = count($a);
  $load_proses = [];
  array_push($load_proses, $produksi_segar);
  for ($i = 0; $i < $banyak_produksi - 1; $i++) {
    if ($i == $banyak_produksi - 2) {
      array_push($load_proses, $b[$i] + $b[$i + 1]);
    } else {
      array_push($load_proses, $b[$i]);
    }
  }
  echo '<br>';
  var_dump($load_proses);
  //input ke table MPS

  for ($i = 0; $i < $banyak_produksi; $i++) {
    if ($i == 0) {
      $input_tgl_mps = $tgl_proses[$i];
      echo $input_tgl_mps;
      echo '<br>';
      for ($k = 0; $k < $banyak_produksi; $k++) {
        $input_load_mps = $load_proses[$k];
        $input_proses_terlibat = $a[$k];
        echo $a[$k];
        echo '<br>';
        echo ($input_load_mps);
        echo '<br>';
        $sql_inputmps = "INSERT INTO MPS (kode_pesanan, proses_terlibat, load_proses, tgl_pengerjaan) VALUES ('$kodepesanan','$input_proses_terlibat','$input_load_mps','$input_tgl_mps')";
        $result = mysqli_query($conn, $sql_inputmps);
      }
    } else {
      $input_tgl_mps = $tgl_proses[$i];
      echo $input_tgl_mps;
      echo '<br>';
      //aray load produksi
      for ($j = $banyak_produksi - 1; $j >= 0; $j--) {
        if ($j != 0) {
          $load_proses[$j] = $load_proses[$j - 1];
        }
      }
      $load_proses[0] = 0;
      for ($ke = 0; $ke < $banyak_produksi; $ke++) {
        $input_proses_terlibat = $a[$ke];
        echo $a[$ke];
        echo '<br>';
        $input_load_mps = $load_proses[$ke];
        echo ($input_load_mps);
        echo '<br>';
        $sql_inputmps = "INSERT INTO MPS (kode_pesanan, proses_terlibat, load_proses, tgl_pengerjaan) VALUES ('$kodepesanan','$input_proses_terlibat','$input_load_mps','$input_tgl_mps')";
        $result = mysqli_query($conn, $sql_inputmps);
      }
    }
  }








  /* for ($i=0; $i < $banyak_produksi; $i++) { 
    if ($i===0) {
      echo $produksi_segar;
      echo '<br>';
    } else if ($i== $banyak_produksi-1) {
      echo $produksi_segar=$produksi_segar+($b[$i-1]+$b[$i]);
      echo '<br>';
    } else{
      echo $produksi_segar+=$b[$i-1];
      echo '<br>';
    }

    $datekerja=date_create($hari_min7);
    date_sub($datekerja,date_interval_create_from_date_string("-1 days"));
    $hari_pengerjaan= date_format($datekerja,"Y-m-d");
    echo $hari_pengerjaan;


    $sql_tambah_mps = "INSERT INTO MPS (kode_pesanan, proses_terlibat,load_proses,tgl_pengerjaan) VALUES ('pes-1','$a[$i]','$produksi_segar','$hari_pengerjaan')";
    mysqli_query($conn,$sql_tambah_mps);
    $hari_min7=$hari_pengerjaan;
  } */
 //header("Location: muncul.html");

  ?> <br>

</body>

</html>