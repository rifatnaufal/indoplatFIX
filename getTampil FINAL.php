<?php
    //initializeeverything
    require("db.php");
    $getHari = explode("/",$_GET['q']);
    $hariPertama = new DateTime($getHari[0]);
    $hariTerakhir = new DateTime($getHari[1]); 
    $pertama =  $hariPertama->format('Y-m-d');
    $terakhir = $hariTerakhir->format('Y-m-d');
    $trBuka= "&lt;tr&gt;";
    $tdBuka= "&lt;td&gt;";
    $tdTutup= "&lt;/td&gt;";
    $trTutup= "&lt;/tr&gt;";

    $mingguIni = [];

    for ($i=0; $i < 6; $i++) { 
        array_push($mingguIni, $hariPertama->format('Y-m-d'));
        $hariPertama->modify('+1 day');
    }
        
    var_dump($mingguIni);

    //fetch banyak pesanan     
    $sql_pesanan = "select kode_pesanan from mps where tgl_pengerjaan between '$pertama' and '$terakhir' group by kode_pesanan asc";
    $result = mysqli_query($conn, $sql_pesanan);
    $banyakPesanan=[];
    while ($row1 = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        array_push($banyakPesanan, $row1['kode_pesanan']);
    }
  //   $hariPertama->modify('+1 day');
  //$hariPertama->format('Y-m-d')
    
    
    
    echo "<table>";
    echo "<tbody id='div1'>";
    for ($i=0; $i < count($banyakPesanan); $i++) { 
        //fetch banyak proses
        $sql_proses = "select kode_proses, nama_proses from mps inner join proses on mps.proses_terlibat=proses.kode_proses where kode_pesanan='$banyakPesanan[$i]' group by proses_terlibat asc";
        $result = mysqli_query($conn, $sql_proses);
        $banyakProses=[];
        $kodeProses=[];
        while ($row2 = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            array_push($banyakProses, $row2['nama_proses']);
            array_push($kodeProses, $row2['kode_proses']);
        }
        var_dump($kodeProses);
        for ($j=0; $j < count($banyakProses); $j++) {      
            if ($j==0) {                
            echo html_entity_decode($trBuka."&lt;td rowspan=".count($banyakProses)."&gt;".$banyakPesanan[$i].$tdTutup);
            echo html_entity_decode($tdBuka.$banyakProses[$j].$tdTutup);
            for ($k=0; $k < 6; $k++) { 
                $sql_fill = "SELECT load_proses from mps where tgl_pengerjaan='$mingguIni[$k]' and proses_terlibat='$kodeProses[$j]' and kode_pesanan='$banyakPesanan[$i]'";
                $result3 = mysqli_query($conn, $sql_fill);
                $row3 = mysqli_fetch_array($result3,MYSQLI_NUM);
                
                if ($k==5) {
                    if ($row3[0]==0) {
                        echo html_entity_decode($tdBuka."-".$tdTutup.$trTutup);
                    } else{
                        echo html_entity_decode($tdBuka.$row3[0].$tdTutup.$trTutup);
                    }
                } else{
                    if ($row3[0]==0) {
                        echo html_entity_decode($tdBuka."-".$tdTutup);
                    } else{
                        echo html_entity_decode($tdBuka.$row3[0].$tdTutup);
                    }
                    
                }
                
                
            }
            
            } else{
                
                echo html_entity_decode($tdBuka.$banyakProses[$j].$tdTutup);
                for ($k=0; $k < 6; $k++) { 
                    $sql_fill = "SELECT load_proses from mps where tgl_pengerjaan='$mingguIni[$k]' and proses_terlibat='$kodeProses[$j]' and kode_pesanan='$banyakPesanan[$i]'";
                $result3 = mysqli_query($conn, $sql_fill);
                $row3 = mysqli_fetch_array($result3,MYSQLI_NUM);
                    
                    if ($k==5) {
                        if ($row3[0]==0) {
                            echo html_entity_decode($tdBuka."-".$tdTutup.$trTutup);
                        } else{
                            echo html_entity_decode($tdBuka.$row3[0].$tdTutup.$trTutup);
                        }
                    } else{
                        if ($row3[0]==0) {
                            echo html_entity_decode($tdBuka."-".$tdTutup);
                        } else{
                            echo html_entity_decode($tdBuka.$row3[0].$tdTutup);
                        }
                    }
                }
            }
            
        }
    }
    echo "</tbody>";
    echo "</table>";
?>