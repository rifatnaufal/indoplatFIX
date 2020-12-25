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
            // echo '<br>';
            // echo ("SELECT kode_mesin FROM `mps` where proses_terlibat='$a[$i]' and tgl_pengerjaan='$cekhari' and status_pengerjaan='on process' and shift=$shift  and not(kode_mesin)='-' group by kode_mesin");
            // echo '<br>';
            // echo 'banyak mesin di proses: ' . $banyak_mesin_di_proses;
            // echo '<br>';
            // echo 'shift ke: ' . ($j + 1);
            // echo "<br>";
            // echo 'proses ke: ' . $a[$i];
            // echo "<br>";
            // echo 'di hari: ' . $cekhari;
            // echo '<br>';
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
              // echo $mesin_masuk_mps[0];
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

      //fetch kode proses dan stok 
   function fetch_kode_proses_dan_stok($a){
    require 'db.php';
    if (!empty($a)) {
      for ($i = 0; $i < count($a); $i++) {
        $t = $a[$i];
        $sql_cabang = "SELECT * from proses where kode_proses='$t'";
        $result = mysqli_query($conn, $sql_cabang);
        while ($r = mysqli_fetch_array($result)) {
           echo $r['nama_proses'];
           echo '<br>';
          array_push($GLOBALS['stok_wip'], $r['stok_wip']);
        }
      }
    }
  }

  //persiapan array load produksi
  function persiapan_array_load_produksi($jumlahpart,$stok_wip,$banyak_produksi){
    
    $produksi_segar = (intval($jumlahpart) - array_sum($stok_wip)) + ((intval($jumlahpart) - array_sum($stok_wip)) * 20 / 100);
    // echo 'produksi awal: ';
    // echo $produksi_segar;  
    array_push($GLOBALS['load_proses'], $produksi_segar);
    array_push($GLOBALS['array_awal_produksi'], $produksi_segar);
    for ($i = 0; $i < $banyak_produksi - 1; $i++) {
      array_push($GLOBALS['load_proses'], $stok_wip[$i]);
      array_push($GLOBALS['array_awal_produksi'], $stok_wip[$i]);
    }
  }



//proses semuanya
  function process_semuanya($tanggal_pengiriman,$a,$status_tanggal_maju){
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
        $counter_pending = 0;
        masukinSHift($masuk_hari_ke_sekian, $a, $i, $ui);
        if ($status_tanggal_maju == "maju") {
          for ($l = $ui; $l < count($tanggal_pengiriman); $l++) {
            tambah_hari_pending($l, $counter_pending);
          }
        }
      }
  
      $tambah_hari = date_create($masuk_hari_ke_sekian);
      date_add($tambah_hari, date_interval_create_from_date_string("1 days"));
  
      if ((date_format($tambah_hari, "l") == "Sunday")) {
        date_sub($tambah_hari, date_interval_create_from_date_string("-1 days"));
        $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
      } else {
        $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
      }
      array_push($GLOBALS['shift_ke_fix'], $GLOBALS['shift_ke']);
      array_push($GLOBALS['hari_masuk_fix'], $GLOBALS['hari_masuk'][0]);
      array_push($GLOBALS['isi_fix'], $GLOBALS['isi']);
      array_push($GLOBALS['mesin_masuk_fix'], $GLOBALS['mesin_masuk']);
      $GLOBALS['isi'] = [];
      $GLOBALS['mesin_masuk'] = [];
      $GLOBALS['shift_ke'] = [];
      $GLOBALS['hari_masuk'] = [];
    }
  }

  //input data ke tabel pesanan   
  function input_data_ke_tabel_pesanan($namapemesan,$namapart,$jumlahpart,$banyakpengiriman){
    require 'db.php';
    $sql_pesanan = "SELECT * FROM pesanan";
    $result = mysqli_query($conn, $sql_pesanan);
    $rowcount = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
  
    if (!$row) {
      //"kosong gan"
      $GLOBALS['kodepesanan'] = 'pes-0001';
    } else {
      $GLOBALS['kodepesanan'] = 'pes-'.sprintf('%04s', (intval($rowcount) + 1));
    }
    $kodepesanan = $GLOBALS['kodepesanan'];
    $sql_inputPesanan = "INSERT INTO pesanan (kode_pesanan, nama_pemesan, nama_pesanan, jumlah_pesanan, banyak_pengiriman, status) VALUES ('$kodepesanan','$namapemesan','$namapart','$jumlahpart','$banyakpengiriman','on process')";
    $result = mysqli_query($conn, $sql_inputPesanan);
    }

    //input data ke tabel proses_pesanan
    function input_data_ke_tabel_proses_pesanan ($kodepesanan,$a){
      require 'db.php';
      for ($i = 0; $i < count($a); $i++) {
        $kodeproses = $a[$i];
        $array_awal_produksi=$GLOBALS['array_awal_produksi'][$i];
    $sql_inputprosesPesanan = "INSERT INTO proses_pesanan (kode_pesanan, kode_proses, load_aslinya) VALUES ('$kodepesanan','$kodeproses','$array_awal_produksi')";
    $result = mysqli_query($conn, $sql_inputprosesPesanan);
      }
      '<br>';
    }

    //input data ke table tgl_kirim_pesanan
  function input_data_ke_tabel_tgl_kirim_pesanan($kodepesanan,$tanggal_pengiriman){
    require 'db.php';
    for ($i = 0; $i < count($tanggal_pengiriman); $i++) {
      $tgl_kirim = $tanggal_pengiriman[$i];
      $sql_inputtglkirim = "INSERT INTO tgl_kirim_pesanan (kode_pesanan, tgl_kirim) VALUES ('$kodepesanan','$tgl_kirim')";
      $result = mysqli_query($conn, $sql_inputtglkirim);
    }
  }
  
  //input ke table MPS baru
  function input_ke_table_MPS_baru($banyak_produksi,$hari_masuk_fix,$isi_fix,$mesin_masuk_fix,$a,$shift_ke_fix,$kodepesanan){
    require 'db.php';
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
}



      ?>

<body>

  <?php 



      if (isset($_POST['upload'])) {
        require('PHPtoExcel/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
        require('PHPtoExcel/spreadsheet-reader-master/SpreadsheetReader.php');
        //upload data excel kedalam folder uploads
        $target_dir = "PHPtoExcel/uploads/" . basename($_FILES['filemhsw']['name']);
        move_uploaded_file($_FILES['filemhsw']['tmp_name'], $target_dir);
        $Reader = new SpreadsheetReader($target_dir);

        $tgl_kirim_besar=[];
        $tgl_kirim_kecil=[];
        $nama_pemesan_besar=[];
        $nama_pemesan_kecil=[];
        $part_besar=[];
        $part_kecil=[];
        $qty_besar=[];
        $qty_kecil=[];
        $i=0;
        $banyakKey=0;
        foreach ($Reader as $Key => $Row) {$banyakKey+=1;}
        foreach ($Reader as $Key => $Row) {         
          if ($Row[0]!='no') {
            if ($Row[0]=='tgl kirim') {
              if ($i!=0) {
                $nama_pemesan_besar[$i-1]=$nama_pemesan_kecil;
                $part_besar[$i-1]=$part_kecil;
                $qty_besar[$i-1]=$qty_kecil;
                $nama_pemesan_kecil=[];
                $part_kecil=[];
                $qty_kecil=[];
                $tgl_kirim_kecil=[];
              }
              array_push($tgl_kirim_kecil,$Row[1]);
              $tgl_kirim_besar[$i]=$tgl_kirim_kecil;
              $i+=1;				
            }else{
              array_push($nama_pemesan_kecil,$Row[1]);
              array_push($part_kecil,$Row[2]);
              array_push($qty_kecil,$Row[3]);
              if ($Key==$banyakKey-1) {
                $nama_pemesan_besar[$i-1]=$nama_pemesan_kecil;
                $part_besar[$i-1]=$part_kecil;
                $qty_besar[$i-1]=$qty_kecil;
                $nama_pemesan_kecil=[];
                $part_kecil=[];
                $qty_kecil=[];						
                $tgl_kirim_kecil=[];
              }
            }
          }
        }
      
        echo '<pre>';
            print_r($tgl_kirim_besar);			 
        echo '</pre>';
        echo '<pre>';
            print_r($nama_pemesan_besar);			 
        echo '</pre>';
        echo '<pre>';
            print_r($part_besar);			 
        echo '</pre>';
        echo '<pre>';
            print_r($qty_besar);			 
        echo '</pre>'; 
        echo '<pre>';
        echo ($qty_besar[0][0]);
        echo '</pre>';
      }
      


        
        for ($banyakExcel=0; $banyakExcel < count($tgl_kirim_besar); $banyakExcel++) { 

          $tanggal_pengiriman = $tgl_kirim_besar[$banyakExcel];
          for ($banyakRow=0; $banyakRow < count($nama_pemesan_besar[$banyakExcel]); $banyakRow++) { 
            $namapemesan = $nama_pemesan_besar[$banyakExcel][$banyakRow];
            $namapart = $part_besar[$banyakExcel][$banyakRow];
            $jumlahpart = $qty_besar[$banyakExcel][$banyakRow];
            $banyakpengiriman = count($tgl_kirim_besar[$banyakExcel]);             
            $isi = [];
            $mesin_masuk = [];
            $shift_ke = [];
            $shift_ke_fix = [];
            $hari_masuk = [];
            $hari_masuk_fix = [];
            $status_tanggal_maju = "";
            $counter_pending = 0;
            $kodepesanan="";
            $isi_fix = [];
            $mesin_masuk_fix = [];
            //isinya stok wip
            $stok_wip = [];
            $a = [];
            // $a isinya proses yang terlibat
            $sql_cabang = "SELECT kode_proses from paket_proses where nama_paket='$namapart'";
            $result = mysqli_query($conn, $sql_cabang);
            while ($huhu = mysqli_fetch_array($result)) {
              array_push($a, $huhu['kode_proses']);
            }

            //fetch kode proses dan stok 
            fetch_kode_proses_dan_stok($a);
            $banyak_produksi = count($a);
            $load_proses = [];
            $array_awal_produksi = [];
            
            //persiapan array load produksi
            persiapan_array_load_produksi($jumlahpart,$stok_wip,$banyak_produksi);


            //input data ke tabel pesanan
            input_data_ke_tabel_pesanan($namapemesan,$namapart,$jumlahpart,$banyakpengiriman);
                        
            //input data ke tabel proses_pesanan
            input_data_ke_tabel_proses_pesanan ($kodepesanan,$a);

            print_r($stok_wip);
            //ngurangin 7 hari untuk injeksi dan buat memperkirakan hari
            process_semuanya($tanggal_pengiriman,$a,$status_tanggal_maju);

            
            //input data ke table tgl_kirim_pesanan
            input_data_ke_tabel_tgl_kirim_pesanan($kodepesanan,$tanggal_pengiriman);
            //input ke table MPS baru
            input_ke_table_MPS_baru($banyak_produksi,$hari_masuk_fix,$isi_fix,$mesin_masuk_fix,$a,$shift_ke_fix,$kodepesanan);

          }

        }

         //inisialisasi semuanya (kecuali yang dalam perulangan karena biasanya digunakan untuk me-reset)
     
       
   header("location: muncul.html");
  die();  
  ?>
  <br>
  </script>
</body>

</html>