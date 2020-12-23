<html><?php require 'db.php';


      function masukinSHift($masukHariHitung, $a, $i, $ui)
      {
        require 'db.php';
        $counter = 0;
        $cekhari = $masukHariHitung;
        $selesai = 0;
        $tambah = 0;
        $shift_selesai = 0;
        $shift_keisi = 0;
        while ($selesai == 0) {
          $j = 0;
          while ($shift_selesai == 0) {
            $shift = $j + 1;
            $banyak_mesin_di_proses = mysqli_num_rows(mysqli_query($conn, "SELECT kode_mesin FROM `mps` where proses_terlibat='$a[$i]' and tgl_pengerjaan='$cekhari' and status_pengerjaan='on process' and shift=$shift  and not(kode_mesin)='-' group by kode_mesin"));
            $banyak_mesin_untuk_proses = mysqli_num_rows(mysqli_query($conn, "SELECT kode_mesin FROM `mesin` where proses_mesin= '$a[$i]'"));
            echo '<br>';
            echo ("SELECT kode_mesin FROM `mps` where proses_terlibat='$a[$i]' and tgl_pengerjaan='$cekhari' and status_pengerjaan='on process' and shift=$shift  and not(kode_mesin)='-' group by kode_mesin");
            echo '<br>';
            echo 'banyak mesin di proses: ' . $banyak_mesin_di_proses;
            echo '<br>';
            echo 'shift ke: ' . ($j + 1);
            echo "<br>";
            echo 'proses ke: ' . $a[$i];
            echo "<br>";
            echo 'di hari: ' . $cekhari;
            echo '<br>';
            if ($banyak_mesin_di_proses < $banyak_mesin_untuk_proses) {
              $yow = mysqli_query($conn, "SELECT kode_mesin FROM `mps` where proses_terlibat='$a[$i]' and tgl_pengerjaan='$cekhari' and status_pengerjaan='on process' and shift=$shift  and not(kode_mesin)='-' GROUP BY kode_mesin");
              $mesin_di_jadwal=[];
              
              while($result=mysqli_fetch_assoc($yow)){
                array_push($mesin_di_jadwal,$result['kode_mesin']);
              }             

              
              $not_mesin="";
              $hehe=count($mesin_di_jadwal);
              for ($we=0; $we < count($mesin_di_jadwal); $we++) { 
                  if ($we!=$hehe-1) {
                      $not_mesin=$not_mesin."'".$mesin_di_jadwal[$we]."',";
                  }else{
                      $not_mesin=$not_mesin."'".$mesin_di_jadwal[$we]."'";
                  }
              }

              if($mesin_di_jadwal==null){
                $mesin_masuk_mps = mysqli_fetch_array(mysqli_query($conn, "SELECT kode_mesin FROM `mesin` where proses_mesin = '$a[$i]'"));
              }else{
                $mesin_masuk_mps = mysqli_fetch_array(mysqli_query($conn, "SELECT kode_mesin FROM `mesin` where proses_mesin = '$a[$i]' and not(kode_mesin) in"." (".$not_mesin.")"));
                
              }
              array_push($GLOBALS['mesin_masuk'], $mesin_masuk_mps[0]);
               print_r($mesin_di_jadwal);
               echo '<br>';
               print_r($GLOBALS['array_awal_produksi']);
               echo '<br>';
              echo $mesin_masuk_mps[0];
              
              array_push($GLOBALS['shift_ke'], $shift);
              if ($ui == 0) {
                array_push($GLOBALS['isi'], $GLOBALS['array_awal_produksi'][$i]);
                $GLOBALS['array_awal_produksi'][$i] = 0;
              } else {
                if ($i == 0) {
                  $GLOBALS['isi'][$i] = $GLOBALS['array_awal_produksi'][$i];
                } else {
                  $GLOBALS['isi'][$i] = ($GLOBALS['array_awal_produksi'][$i]) + ($GLOBALS['isi_fix'][($ui - 1)][($i - 1)]);
                  $GLOBALS['array_awal_produksi'][$i]=$GLOBALS['array_awal_produksi'][$i-1];
                }
                
              }
              echo '<br>';
              print_r($GLOBALS['isi_fix'][$i]);
              echo '<br>';

              $shift_selesai += 1;
              $shift_keisi += 1;
            } else if (($j == 2) and ($shift_keisi == 0)) {
             
              $shift_selesai += 1;
            } else {
             
              $j += 1;
            }
          }
          if ($shift_keisi == 0) {
            $tambah_hari = date_create($cekhari);
            date_add($tambah_hari, date_interval_create_from_date_string("1 days"));

            if ((date_format($tambah_hari, "l") == "Sunday")) {
              date_sub($tambah_hari, date_interval_create_from_date_string("-1 days"));
              $cekhari = date_format($tambah_hari, "Y-m-d");
              $counter += 1;
            } else {
              $cekhari = date_format($tambah_hari, "Y-m-d");
            }
            $GLOBALS['masuk_hari_ke_sekian'] = $cekhari;
            $GLOBALS['status_tanggal_maju'] = "maju";
            $counter += 1;
            $GLOBALS['counter_pending'] = $counter;
            $shift_selesai -= 1;
          } else {
            $GLOBALS['hasil_isi'] = 'keisi';
            $GLOBALS['hari_masuk'][0] = $cekhari;
            
            $shift_keisi -= 1;
          }
          $selesai += 1;
        }
      }


      function tambah_hari_pending($l, $banyak_nambah)
      {

        $date_maju_pengiriman = date_create($GLOBALS['tanggal_pengiriman'][$l]);

        date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-" . $banyak_nambah . " days"));
        if ((date_format($date_maju_pengiriman, "l") == "Sunday")) {
          date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-1 days"));
          $GLOBALS['tanggal_pengiriman'][$l] = date_format($date_maju_pengiriman, "Y-m-d");
        } else {
          $GLOBALS['tanggal_pengiriman'][$l] = date_format($date_maju_pengiriman, "Y-m-d");
        }
      }



      ?>

<body> 
  <!--  Nama pemesan: <?php echo $_POST["nama"];
                      ?> <br>
  Part yang dipesan: <?php echo $_POST["namapart"];
                      ?> <br>
  Jumlah part: <?php echo $_POST["JumlahPart"];
                ?> <br>
  Proses:<br> -->

  <?php



  //inisialisasi semuanya (kecuali yang dalam perulangan karena biasanya digunakan untuk me-reset)
  $namapemesan = $_POST["nama"];
  $namapart = $_POST["namapart"];
  $jumlahpart = $_POST["JumlahPart"];
  $banyakpengiriman = $_POST["banyakTanggal"];
  $tanggal_pengiriman = [];
  $tanggal_paling_awal = [];
  $isi = [];
  $mesin_masuk = [];
  $shift_ke = [];
  $shift_ke_fix = [];
  $hari_masuk = [];
  $hari_masuk_fix = [];
  $status_tanggal_maju = "";
  $counter_pending = 0;

  $isi_fix = [];
  $mesin_masuk_fix = [];
  //isinya stok wip
  $stok_wip = [];
  // $a isinya proses yang terlibat
  $a = $_POST['checkboxvar'];



  //fetch kode proses dan stok  
  if (!empty($a)) {
    for ($i = 0; $i < count($a); $i++) {
      $t = $a[$i];
      $sql_cabang = "SELECT * from proses where kode_proses='$t'";
      $result = mysqli_query($conn, $sql_cabang);
      while ($r = mysqli_fetch_array($result)) {
        echo $r['nama_proses'];
        echo '<br>';
        array_push($stok_wip, $r['stok_wip']);
      }
    }
  }



  //persiapan array load produksi
  $produksi_segar = ($jumlahpart - array_sum($stok_wip)) + (($jumlahpart - array_sum($stok_wip)) * 20 / 100);
  echo 'produksi awal: ';
  echo $produksi_segar;
  $banyak_produksi = count($a);
  $load_proses = [];
  $array_awal_produksi = [];
  array_push($load_proses, $produksi_segar);
  array_push($array_awal_produksi, $produksi_segar);
  for ($i = 0; $i < $banyak_produksi - 1; $i++) {
    array_push($load_proses, $stok_wip[$i]);
    array_push($array_awal_produksi, $stok_wip[$i]);
  }
  echo '<br>';
  print_r($array_awal_produksi);
  echo '<br>';

  //validate the date before everything

  for ($i = 0; $i < $banyakpengiriman; $i++) {
    $hehe = 'tanggalkirim' . $i;
    echo ($_POST[$hehe]);
    echo '<br>';
    array_push($tanggal_pengiriman, $_POST[$hehe]);
  }




  //ngurangin 7 hari untuk injeksi dan buat memperkirakan hari
  echo '<br>';
  $date = date_create(min($tanggal_pengiriman));
  date_sub($date, date_interval_create_from_date_string("7 days"));
  if ((date_format($date, "l") == "Sunday")) {
    date_sub($date, date_interval_create_from_date_string("1 days"));
    $hari_min7 = date_format($date, "Y-m-d");
  } else {
    $hari_min7 = date_format($date, "Y-m-d");
  }
  $masuk_hari_ke_sekian = $hari_min7;
  for ($ui = 0; $ui < count($a); $ui++) {

    for ($i = 0; $i < count($a); $i++) {
      echo '<br>';
      echo '<br>';

      $counter_pending = 0;


      /*  
      if ($ui!=0) {
        $tambah_hari=date_create($hari_min7);
      date_add($tambah_hari,date_interval_create_from_date_string("1 days"));
      
      if ((date_format($tambah_hari, "l") == "Sunday")) {
        date_sub($tambah_hari, date_interval_create_from_date_string("-1 days"));
        $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
       
      } else {
        $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
        
      }
      } */

      masukinSHift($masuk_hari_ke_sekian, $a, $i, $ui);
      echo "<br>";
      if ($status_tanggal_maju == "maju") {
        echo "majuin tanggal pengiriman";
        for ($l = $ui; $l < count($tanggal_pengiriman); $l++) {
          tambah_hari_pending($l, $counter_pending);
        }
      }
      echo '<br>';
      echo "<br>";

      echo 'counter pending: ' . $counter_pending;
      echo "<br>";

      echo 'mesin yang masuk: ' . $mesin_masuk[$i];
      echo '<br>';
      echo 'masuk di shift: ';
      print_r($shift_ke);
      echo '<br>';
      echo $shift_ke[0];
      echo "<br>";
  
      
    }
    array_push($shift_ke_fix, $shift_ke);
    array_push($hari_masuk_fix, $hari_masuk[0]);
    array_push($isi_fix, $isi);
    array_push($mesin_masuk_fix, $mesin_masuk);
    $isi = [];
    $mesin_masuk = [];
    $shift_ke = [];
    $hari_masuk = [];
    echo 'masuk di hari: ';
    echo '<br>';
    print_r($hari_masuk);
    echo '<br>';
    print_r($hari_masuk_fix);
    echo "<br>";
    echo 'apakah keisi? ' . $hasil_isi;
    echo "<br>";
    echo 'dikirim tanggal: ';
    print_r($tanggal_pengiriman);
    echo '<br>';
    $tambah_hari = date_create($masuk_hari_ke_sekian);
    date_add($tambah_hari, date_interval_create_from_date_string("1 days"));

    if ((date_format($tambah_hari, "l") == "Sunday")) {
      date_sub($tambah_hari, date_interval_create_from_date_string("-1 days"));
      $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
    } else {
      $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
    }
    
  }
  print_r($tanggal_pengiriman);
  echo "<BR>";
  print_r($hari_masuk_fix);
  echo "<BR>";









  //input data ke tabel pesanan   
  $sql_pesanan = "SELECT * FROM pesanan";
  $result = mysqli_query($conn, $sql_pesanan);
  $rowcount = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);

  if (!$row) {
    //"kosong gan"
    $kodepesanan = 'pes-0001';
  } else {
    $kodepesanan = 'pes-'.sprintf('%04s', (intval($rowcount) + 1));

    echo '<br>';
  }
  echo $kodepesanan;
  $sql_inputPesanan = "INSERT INTO pesanan (kode_pesanan, nama_pemesan, nama_pesanan, jumlah_pesanan, banyak_pengiriman, status) VALUES ('$kodepesanan','$namapemesan','$namapart','$jumlahpart','$banyakpengiriman','on process')";
  $result = mysqli_query($conn, $sql_inputPesanan);


  //input data ke tabel proses_pesanan

  for ($i = 0; $i < count($a); $i++) {
    $kodeproses = $a[$i];
    $sql_inputprosesPesanan = "INSERT INTO proses_pesanan (kode_pesanan, kode_proses) VALUES ('$kodepesanan','$kodeproses')";
    $result = mysqli_query($conn, $sql_inputprosesPesanan);
  }
  '<br>';

  //input data ke table tgl_kirim_pesanan
  for ($i = 0; $i < count($tanggal_pengiriman); $i++) {
    $tgl_kirim = $tanggal_pengiriman[$i];
    $sql_inputtglkirim = "INSERT INTO tgl_kirim_pesanan (kode_pesanan, tgl_kirim) VALUES ('$kodepesanan','$tgl_kirim')";
    $result = mysqli_query($conn, $sql_inputtglkirim);
  }

  //nampilkan kode proses dan stok

  echo 'kode proses: ';
  print_r($a);
  echo '<br>';
  echo 'stok wip:';
  print_r($stok_wip);
  echo '<br>';
  echo 'mesin terlibat:';
  print_r($mesin_masuk_fix);
  echo '<br>';
  echo 'array awal persiapan produksi: ';
  print_r($array_awal_produksi);
  echo '<br>';
  echo 'isi: ';
  print_r($isi_fix);
  echo '<br>';
  echo '<br>';
  //input ke table MPS baru
  for ($i = 0; $i < $banyak_produksi; $i++) {
    $input_tgl_mps = $hari_masuk_fix[$i];
    for ($j = 0; $j < $banyak_produksi; $j++) {
      $input_load_mps = $isi_fix[$i][$j];
      if ($input_load_mps == 0) {
        $input_mesin = "-";
      } else {
        $input_mesin = $mesin_masuk_fix[$i][$j];
      }
      $input_proses_terlibat = $a[$j];
      $input_shift = $shift_ke_fix[$i][$j];
      $sql_inputmps = "INSERT INTO `mps` (kode_pesanan, proses_terlibat, load_proses, tgl_pengerjaan, kode_mesin, status_pengerjaan, shift) VALUES ('$kodepesanan','$input_proses_terlibat','$input_load_mps','$input_tgl_mps','$input_mesin','on process','$input_shift')";
      $result = mysqli_query($conn, $sql_inputmps);
    }
  }
  /*
   //input ke table MPS

  for ($i = 0; $i < $banyak_produksi; $i++) {
    if ($i == 0) {
      $input_tgl_mps = $hari_masuk[0];
      echo $input_tgl_mps;
      echo '<br>';
      for ($k = 0; $k < $banyak_produksi; $k++) {
        $input_load_mps = $load_proses[$k];

        if ($input_load_mps==0) {
          $input_mesin="-";
        }else{
          $input_mesin=$mesin_masuk[$k];
        }
          
        $input_proses_terlibat = $a[$k];
        
        $input_shift=$shift_ke[$k];
        echo $a[$k];
        echo '<br>';
        echo ($input_load_mps);
        echo '<br>';
        $sql_inputmps = "INSERT INTO `mps` (kode_pesanan, proses_terlibat, load_proses, tgl_pengerjaan, kode_mesin, status_pengerjaan, shift) VALUES ('$kodepesanan','$input_proses_terlibat','$input_load_mps','$input_tgl_mps','$input_mesin','on process','$input_shift')";
        $result = mysqli_query($conn, $sql_inputmps);
      }
    } else {
      $input_tgl_mps = $hari_masuk[0];
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
        
        $input_shift=$shift_ke[$ke];
        echo $a[$ke];
        echo '<br>';
        $input_load_mps = $load_proses[$ke];
        echo ($input_load_mps);
        if ($input_load_mps==0) {
          $input_mesin="-";
        }else{
          $input_mesin=$mesin_masuk[$ke];
        }
          
        
        // echo '<br>';
        $sql_inputmps = "INSERT INTO `mps` (kode_pesanan, proses_terlibat, load_proses, tgl_pengerjaan, kode_mesin, status_pengerjaan, shift) VALUES ('$kodepesanan','$input_proses_terlibat','$input_load_mps','$input_tgl_mps','$input_mesin','on process','$input_shift')";
        $result = mysqli_query($conn, $sql_inputmps);
      }
    }
  }
  */
  /* header("location: muncul.html");
  die();  */
  ?>
  <br>
  <!--   <script>
  function hehe(){
    location.assign("form_test.php");
  }
  hehe();  -->
  </script>
</body>

</html>