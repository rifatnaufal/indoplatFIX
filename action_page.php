<?php
require 'db.php'; 

function masukinSHift($masukHariHitung, $a, $i, $ui)
{
  require 'db.php';
  $counter = 0;
  $cekhari = $masukHariHitung;
  $selesai = 0;
  $tambah = 0;
  $shift_selesai = 0;
  $shift_keisi = 0;
  $maju=$GLOBALS['maju'];
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
        if ($GLOBALS['status_tanggal_maju']=="maju") {          
          $maju="hehe";
          $tambah_hari = date_create($cekhari);
          date_add($tambah_hari, date_interval_create_from_date_string("-1 days"));
    
          if ((date_format($tambah_hari, "l") == "Sunday")) {
            date_sub($tambah_hari, date_interval_create_from_date_string("1 days"));
            $cekhari = date_format($tambah_hari, "Y-m-d");
            $counter -= 1;
          } else {
            $cekhari = date_format($tambah_hari, "Y-m-d");
          }
          $GLOBALS['masuk_hari_ke_sekian'] = $cekhari;



          break;
        }
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
        if (($ui == 0) && ($i==0)) {
          array_push($GLOBALS['isi'], $GLOBALS['array_aktual'][$i]);
          $GLOBALS['array_aktual'][$i] = 0;
        } else {
            if ($i == 0) {
              $GLOBALS['isi'][$i] = $GLOBALS['array_aktual'][$i];
            } else {
              $huhue=($GLOBALS['array_aktual'][$i]) + ($GLOBALS['isi_fix'][($ui - 1)][($i - 1)]);
              
              array_push($GLOBALS['isi'],$huhue);
              $GLOBALS['array_aktual'][$i]=$GLOBALS['array_aktual'][$i-1];
            }
          
        }
        echo '<br>';
        print_r($GLOBALS['isi'][$i]);
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
      if ($maju=="hehe") {
        $GLOBALS['maju']="hehe";
        $selesai+=1;
      }else{
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
    }
    } else {
      $GLOBALS['hasil_isi'] = 'keisi';
      array_push($GLOBALS['hari_masuk'],$cekhari);      
      $shift_keisi -= 1;
      $selesai += 1;
    }
    
  }
}
  
  function tambah_hari_pending($l,$banyak_nambah){
    
    $date_maju_pengiriman = date_create($GLOBALS['tanggal_pengiriman'][$l]);  
            
            date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-".$banyak_nambah." days"));
            if ((date_format($date_maju_pengiriman, "l") == "Sunday")) {
              date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-1 days"));
              $GLOBALS['tanggal_pengiriman'][$l] = date_format($date_maju_pengiriman, "Y-m-d");
            } else {
              $GLOBALS['tanggal_pengiriman'][$l] = date_format($date_maju_pengiriman, "Y-m-d");
            }
  }
 //inisialisasi semuanya (kecuali yang dalam perulangan karena biasanya digunakan untuk me-reset)

 $tanggal_pengiriman = [];  
 $tanggal_paling_awal = [];
 $isi=[];
     $mesin_masuk=[];
 $shift_ke=[];
 $shift_ke_fix=[];
 $hari_masuk=[];
 $hari_masuk_fix=[];
 $status_tanggal_maju="";
 $counter_pending=0;
 $b=$_POST['proses_terlibat'];
 $a=[];
 $hari_minimal=$_POST['hari_minimal']; 
 $isi_fix=[];
 $pengiriman_ada=$_POST['pengiriman'];
 $mesin_masuk_fix=[];
 $maju="";
$array_aslinya=[];
$array_aktual=[];
$kode_pesanan=$_POST['pesanan'];

$masuk_hari_ke_sekian1=$_POST['hari_bersangkutan'];
$masuk_hari_ke_sekian="";
$cek=$b[0];
$sql_load_buat_proses="SELECT kode_proses FROM `proses_pesanan` where kode_pesanan='$kode_pesanan' and kode_proses>='$cek'";
$result_proses=mysqli_query($conn,$sql_load_buat_proses);
while ($row_res = mysqli_fetch_assoc($result_proses)){
    array_push($a,$row_res['kode_proses']);
}
print_r($a);
echo '<br>';

for ($hehehe=0; $hehehe < count($a); $hehehe++) { 
  if (!isset($_POST['email'][$hehehe])) {
    $array_awal_produksi[$hehehe]=0;
  }else{
    $array_awal_produksi[$hehehe]=$_POST['email'][$hehehe];
  }
}
$date_maju_pengiriman = date_create($masuk_hari_ke_sekian1);  
            
            date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-1 days"));
            if ((date_format($date_maju_pengiriman, "l") == "Sunday")) {
              date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-1 days"));
              $masuk_hari_ke_sekian = date_format($date_maju_pengiriman, "Y-m-d");
            } else {
              $masuk_hari_ke_sekian = date_format($date_maju_pengiriman, "Y-m-d");
            }



    // print_r($array_awal_produksi);
    // echo '<br>';
    // echo ($kode_pesanan);
    // echo '<br>';
    // print_r($a);
    // echo '<br>';
    // echo ($masuk_hari_ke_sekian);
    // echo '<br>';
    // echo $hari_minimal;
    // echo '<br>';
    // print_r($pengiriman_ada);
    // echo '<br>';
    $proses_pesanan_tersebut=[];
    for ($i=0; $i<count($a);$i++){
        $sql_load_aslinya="SELECT load_proses from `mps` where kode_pesanan='$kode_pesanan' and tgl_pengerjaan='$masuk_hari_ke_sekian1' and proses_terlibat='$a[$i]'";
        $result=mysqli_fetch_array(mysqli_query($conn,$sql_load_aslinya));

        $sql_load_aslinya1="SELECT load_aslinya from `proses_pesanan` where kode_pesanan='$kode_pesanan' and kode_proses='$a[$i]'";
        $result1=mysqli_fetch_assoc(mysqli_query($conn,$sql_load_aslinya1));
        
        if ($i==0) {
          array_push($array_aslinya,$result[0]);
        } else{
          array_push($array_aslinya,$result1['load_aslinya']);
        }
    }

    $sql_load_aslinya2="SELECT kode_proses from `proses_pesanan` where kode_pesanan='$kode_pesanan'";
    $result2=mysqli_query($conn,$sql_load_aslinya2);

    while($row2=mysqli_fetch_assoc($result2)){
      array_push($proses_pesanan_tersebut,$row2['kode_proses']);
    }

    

    echo '<br>';
    print_r ($array_aslinya);
    echo '<br>';



    // print_r($array_aslinya);
    $counter_selisih=0;
    for ($i=0; $i<count($array_aslinya);$i++){
        $temp=$array_aslinya[$i]-$array_awal_produksi[$i];
        if ($temp!=0) {
          $counter_selisih+=1;
        }
        if ($i==0) {
          $array_aktual[$i]=$temp;
          
        }else{
          $array_aktual[$i]=$array_awal_produksi[$i-1]+$temp;
        }
    }

      if ($counter_selisih!=0) {
        mysqli_query($conn,"DELETE from `mps` where kode_pesanan='$kode_pesanan'");
        // echo 'data dihapus';
      } else{
        header("location: muncul.html");
        die();
      }
      echo '<br>';
      print_r($array_aktual);
      echo '<br>';

  
        for ($i=0; $i < count($a); $i++) { 
          mysqli_query($conn, "UPDATE `proses_pesanan` set load_aslinya='$array_aktual[$i]' where kode_pesanan='$kode_pesanan' and kode_proses='$a[$i]'");
          echo "UPDATE `proses_pesanan` set load_aslinya='$array_aktual[$i]' where kode_pesanan='$kode_pesanan' and kode_proses=$a[$i]";
          echo '<br>';
        } 
      
 
    print_r($array_aslinya);
    echo '<br>';
     print_r($array_awal_produksi);
     echo '<br>';
     print_r($array_aktual);
     



    $tanggal1 = new DateTime($masuk_hari_ke_sekian);
    $tanggal2 = new DateTime($hari_minimal);
    
    $perbedaan = $tanggal2->diff($tanggal1)->format("%D");
    
    // echo $perbedaan;
    for ($l=0; $l < count($pengiriman_ada);$l++){
        $date_maju_pengiriman = date_create($pengiriman_ada[$l]);  
            
            date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-".$perbedaan." days"));
            if ((date_format($date_maju_pengiriman, "l") == "Sunday")) {
              date_sub($date_maju_pengiriman, date_interval_create_from_date_string("-1 days"));
              $GLOBALS['tanggal_pengiriman'][$l] = date_format($date_maju_pengiriman, "Y-m-d");
            } else {
              $GLOBALS['tanggal_pengiriman'][$l] = date_format($date_maju_pengiriman, "Y-m-d");
            }
    }
    // print_r($tanggal_pengiriman);









    for ($ui=0; $ui < count($a) ; $ui++) { 

        for ($i=0; $i < count($a) ; $i++) { 
            // echo '<br>';
            // echo '<br>';
            
              $counter_pending=0;
            
            
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
            
            masukinSHift($masuk_hari_ke_sekian,$a,$i,$ui);
            echo "<br>";
      if ($status_tanggal_maju == "maju") {
        echo "majuin tanggal pengiriman";
        for ($l = $ui; $l < count($tanggal_pengiriman); $l++) {
          tambah_hari_pending($l, $counter_pending);
        }
        $status_tanggal_maju="";
      }
      if ($maju=="maju") {
        break;
      }
            // echo '<br>';
            // echo "<br>";
      
            // echo 'counter pending: '.$counter_pending;
            // echo "<br>";
            
            // echo 'mesin yang masuk: '.$mesin_masuk[$i];
            // echo '<br>';
            // echo 'masuk di shift: ';// print_r($shift_ke);
            // echo '<br>';
            // echo $shift_ke[0];
            // echo "<br>";
            // echo 'masuk di hari: ';// echo '<br>';
            // print_r ($hari_masuk);// echo '<br>';
            // print_r($hari_masuk_fix);
            // echo "<br>";
            // echo 'apakah keisi? '.$hasil_isi;
            // echo "<br>";
            // echo 'dikirim tanggal: ';
            // print_r($tanggal_pengiriman);
            // echo '<br>';
          
        }
        array_push($shift_ke_fix,$shift_ke);
        array_push($hari_masuk_fix,$hari_masuk);
  array_push($isi_fix,$isi);
  array_push($mesin_masuk_fix,$mesin_masuk);
  $isi=[];
        $mesin_masuk=[];
        $shift_ke=[];
        $hari_masuk=[];
        $tambah_hari=date_create($masuk_hari_ke_sekian);
            date_add($tambah_hari,date_interval_create_from_date_string("1 days"));
            
            if ((date_format($tambah_hari, "l") == "Sunday")) {
              date_sub($tambah_hari, date_interval_create_from_date_string("-1 days"));
              $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
            } else {
              $masuk_hari_ke_sekian = date_format($tambah_hari, "Y-m-d");
            } 
           
      
      }
        // print_r( $tanggal_pengiriman);
        // echo "<BR>";
        // print_r($hari_masuk_fix);
        // echo "<BR>";


        // echo 'kode proses: ';
        // print_r($a);
        // echo '<br>';
        // echo '<br>';
        // echo 'mesin terlibat:';
        // print_r($mesin_masuk_fix);
        // echo '<br>';
        // echo 'array awal persiapan produksi: ';
        // print_r($array_awal_produksi);
        // echo '<br>';
        // echo 'isi: ';
        // print_r($isi_fix);
        // echo '<br>';
        echo '<br>';
        print_r($shift_ke_fix);
        echo '<br>';
        echo '<br>';
        print_r($mesin_masuk_fix);
        echo '<br>';
//input data ke table tgl_kirim_pesanan
 for ($i = 0; $i < count($tanggal_pengiriman); $i++) {
    $tgl_kirim = $tanggal_pengiriman[$i];
    $sql_inputtglkirim = "UPDATE tgl_kirim_pesanan set kode_pesanan='$kode_pesanan', tgl_kirim='$tgl_kirim') where kode_pesanan='$kode_pesanan' and tgl_kirim='$pengiriman_ada[$i]'";
    $result = mysqli_query($conn, $sql_inputtglkirim);
  }

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
  print_r($array_aktual);
  echo '<br>';
  echo 'isi: ';
  print_r($isi_fix);
  echo '<br>';
  echo '<br>';
         //input ke table MPS baru
  for ($i = 0; $i < count($a); $i++) {
    for ($j=0; $j<count($a); $j++){
      $input_tgl_mps = $hari_masuk_fix[$i][$j];
      $input_load_mps = $isi_fix[$i][$j];  
      if ($input_load_mps==0) {
        $input_mesin="-";
      }else{
        $input_mesin=$mesin_masuk_fix[$i][$j];
      }
      $input_proses_terlibat = $a[$j];
      if (isset($shift_ke_fix[$i][$j])) {
        $input_shift=$shift_ke_fix[$i][$j];
      }
      $sql_inputmps = "INSERT INTO `mps` (kode_pesanan, proses_terlibat, load_proses, tgl_pengerjaan, kode_mesin, status_pengerjaan, shift) VALUES ('$kode_pesanan','$input_proses_terlibat','$input_load_mps','$input_tgl_mps','$input_mesin','on process','$input_shift')";
      $result = mysqli_query($conn, $sql_inputmps);
    }
  } 

  header("location: muncul.html");
  die();  
?>