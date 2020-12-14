<?php
require ('db.php');
$mesin_di_jadwal=[];
$not_mesin="";

$pesanan=$_POST['pesanan'];
$hari=$_POST['hari_bersangkutan'];

$row=mysqli_query($conn,"SELECT kode_mesin FROM `mps` where tgl_pengerjaan='$hari' and status_pengerjaan='on process' and proses_terlibat='proc-01' and not(kode_mesin)='-'");

while($result=mysqli_fetch_assoc($row)){
    array_push($mesin_di_jadwal,$result['kode_mesin']);
}
print_r($mesin_di_jadwal);
$hehe=count($mesin_di_jadwal);
for ($i=0; $i < count($mesin_di_jadwal); $i++) { 
    if ($i!=$hehe-1) {
        $not_mesin=$not_mesin."'".$mesin_di_jadwal[$i]."',";
    }else{
        $not_mesin=$not_mesin."'".$mesin_di_jadwal[$i]."'";
    }
}


$mesin_masuk=mysqli_fetch_array(mysqli_query($conn, "SELECT kode_mesin from mesin where not(kode_mesin) in"." (".$not_mesin.")"),MYSQLI_NUM);
echo '<br>';
echo  $mesin_masuk[0];

mysqli_query($conn, "UPDATE `mps` set kode_mesin='$mesin_masuk[0]' where kode_pesanan='$pesanan' and tgl_pengerjaan='$hari' and proses_terlibat='proc-01' and status_pengerjaan='on process' ");

header("location: muncul.html");
  exit();

?>