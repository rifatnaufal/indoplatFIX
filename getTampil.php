<?php

function fetchKeTabel($mingguIni, $kodeProses, $banyakPesanan, $shift, $k)
{
    require("db.php");
    $sql_fill = "SELECT load_proses, kode_mesin from mps where tgl_pengerjaan='$mingguIni' and proses_terlibat='$kodeProses' and kode_pesanan='$banyakPesanan' and
            status_pengerjaan='on process' and
            shift='$shift'";
    $result3 = mysqli_query($conn, $sql_fill);
    $row3 = mysqli_fetch_assoc($result3);

    if ($k == 17) {
        if (($row3['load_proses'] == 0)) {
            echo html_entity_decode($GLOBALS['tdBuka'] . "-" . $GLOBALS['tdTutup'] . $GLOBALS['trTutup']);
        } else {
            echo html_entity_decode($GLOBALS['tdBuka'] . $row3['load_proses'] . '<br>' . $row3['kode_mesin'] . $GLOBALS['tdTutup'] . $GLOBALS['trTutup']);
        }
    } else {
        if (($row3['load_proses'] == 0)) {
            echo html_entity_decode($GLOBALS['tdBuka'] . "-" . $GLOBALS['tdTutup']);
        } else {
            echo html_entity_decode($GLOBALS['tdBuka'] . $row3['load_proses'] . '<br>' . $row3['kode_mesin'] . $GLOBALS['tdTutup']);
        }
    }
}



//initializeeverything
require("db.php");
$getHari = explode("/", $_GET['q']);
$hariPertama = new DateTime($getHari[0]);
$hariTerakhir = new DateTime($getHari[1]);
$pertama =  $hariPertama->format('Y-m-d');
$terakhir = $hariTerakhir->format('Y-m-d');
$trBuka = "&lt;tr&gt;";
$tdBuka = "&lt;td&gt;";
$tdTutup = "&lt;/td&gt;";
$trTutup = "&lt;/tr&gt;";
$buttonBuka = "&lt;Button ";
$buttonTutup = "&lt;/Button&gt;";
$divBuka = "&lt;div ";
$divTutup = "&lt;/div&gt;";
$formBuka = "&lt;form ";
$formTutup = "&lt;/form&gt;";
$h1Buka = "&lt;h1&gt;";
$h1Tutup = "&lt;/h1&gt;";
$pBuka = "&lt;p&gt;";
$pTutup = "&lt;/p&gt;";
$labelBuka = "&lt;label ";
$labelTutup = "&lt;/label&gt;";
$bBuka = "&lt;b&gt;";
$bTutup = "&lt;/b&gt;";
$inputBuka = "&lt;input ";
$spanBuka = "&lt;span ";
$spanTutup = "&lt;/span&gt;";

$mingguIni = [];

for ($i = 0; $i < 6; $i++) {
    array_push($mingguIni, $hariPertama->format('Y-m-d'));
    $hariPertama->modify('+1 day');
}

var_dump($mingguIni);

//fetch banyak pesanan     
$sql_pesanan = "select kode_pesanan from mps where tgl_pengerjaan between '$pertama' and '$terakhir' group by kode_pesanan asc";
$result = mysqli_query($conn, $sql_pesanan);
$banyakPesanan = [];
while ($row1 = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    array_push($banyakPesanan, $row1['kode_pesanan']);
}
//   $hariPertama->modify('+1 day');
//$hariPertama->format('Y-m-d')



echo "<table>";
echo "<tbody id='div1'>";
for ($i = 0; $i < count($banyakPesanan); $i++) {
    //fetch banyak proses
    $sql_proses = "SELECT kode_proses, nama_proses from mps inner join proses on mps.proses_terlibat=proses.kode_proses where kode_pesanan='$banyakPesanan[$i]' group by proses_terlibat asc";
    $result = mysqli_query($conn, $sql_proses);
    $banyakProses = [];
    $kodeProses = [];
    while ($row2 = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        array_push($banyakProses, $row2['nama_proses']);
        array_push($kodeProses, $row2['kode_proses']);
    }
    var_dump($kodeProses);
    for ($j = 0; $j < count($banyakProses); $j++) {
        if ($j == 0) {
            echo html_entity_decode($trBuka . "&lt;td rowspan=" . count($banyakProses) . "&gt;" . $banyakPesanan[$i] . $tdTutup);
            echo html_entity_decode($tdBuka . $banyakProses[$j] . $tdTutup);

            $shift = 1;
            $h = 0;
            for ($k = 0; $k < 18; $k++) {
                fetchKeTabel($mingguIni[$h], $kodeProses[$j], $banyakPesanan[$i], $shift, $k);

                if ($shift == 3) {
                    $shift = 1;
                    $h += 1;
                } else {
                    $shift += 1;
                }
            }
        } else {
            $shift = 1;
            $h = 0;
            echo html_entity_decode($tdBuka . $banyakProses[$j] . $tdTutup);
            for ($k = 0; $k < 18; $k++) {
                fetchKeTabel($mingguIni[$h], $kodeProses[$j], $banyakPesanan[$i], $shift, $k);
                if ($shift == 3) {
                    $shift = 1;
                    $h += 1;
                } else {
                    $shift += 1;
                }
            }
        }
    }


    echo html_entity_decode($trBuka . "&lt;td colspan=2&gt;" . 'ACTUAL' . $tdTutup);
    for ($t = 0; $t < 6; $t++) {
        $myModal = "myModal" . $t . $banyakPesanan[$i];
        $myMesin = "myMesin" . $t . $banyakPesanan[$i];
        $closeModal = "closeModal" . $t . $banyakPesanan[$i];
        $sql_cek_banyak_proses = "SELECT nama_proses, mps.proses_terlibat FROM `mps` join `proses` on mps.proses_terlibat=proses.kode_proses where kode_pesanan='$banyakPesanan[$i]' and tgl_pengerjaan='$mingguIni[$t]' and status_pengerjaan='on process' and not(load_proses)=0";
        $result4 = mysqli_query($conn, $sql_cek_banyak_proses);
        $sql_cek_hari_pengerjaan_awal = "SELECT min(tgl_pengerjaan) FROM `mps` where kode_pesanan='$banyakPesanan[$i]' and status_pengerjaan='on process'";
        $result5 = mysqli_fetch_array(mysqli_query($conn, $sql_cek_hari_pengerjaan_awal));
        $hari_minimal = new DateTime($result5[0]);
        $sql_cek_hari_pengiriman = "SELECT tgl_kirim FROM `tgl_kirim_pesanan` where kode_pesanan='$banyakPesanan[$i]'";
        $result6 = mysqli_query($conn, $sql_cek_hari_pengiriman);
        $cek_pengiriman = [];
        while ($row6 = mysqli_fetch_assoc($result6)) {
            array_push($cek_pengiriman, $row6['tgl_kirim']);
        }
        print_r($cek_pengiriman);

        $hari_minimal = new DateTime($result5[0]);

        $cek_banyak_proses = [];
        $proses_terlibat = [];
        while ($row4 = mysqli_fetch_assoc($result4)) {
            array_push($cek_banyak_proses, $row4['nama_proses']);
            array_push($proses_terlibat, $row4['proses_terlibat']);
        }

        if ($t == 5) {
            echo html_entity_decode("&lt;td colspan=3 class='submitButton'&gt;" . $buttonBuka . "class='open-submitActual' onclick=" . '"' . "buka('" . $myModal . "')" . '"' . "&gt;Submit actual" . $buttonTutup . " " . $buttonBuka . "class='open-submitActual' onclick=" . '"' . "buka('" . $myMesin . "')" . '"' . "&gt;Submit Mesin" . $buttonTutup);
            echo html_entity_decode($divBuka . "class='modal' id='" . $myModal . "' &gt;" . $divBuka . "class='modal-content'&gt;");
            echo html_entity_decode($spanBuka . "class='closeModal' onClick=" . '"' . "tutup('" . $myModal . "')" . '"' . "&gt;&times" . $spanTutup);
            echo html_entity_decode($formBuka . " method='post' action='action_page.php' class='form-containerActual'&gt;" . $h1Buka . "Input Actual" . $h1Tutup . $pBuka . "Kode Pesanan : " . $banyakPesanan[$i] . $pTutup . $pBuka . "Tanggal :" . $mingguIni[$t] . $pTutup);

            for ($u = 0; $u < count($cek_banyak_proses); $u++) {
                echo html_entity_decode($labelBuka . "for='email'&gt;" . $bBuka . $cek_banyak_proses[$u] . $bTutup . $labelTutup . $inputBuka . "type='text' placeholder='Masukkan jumlah actual' name='email[]'&gt;");
                echo html_entity_decode($inputBuka . "type='hidden' name='proses_terlibat[]' value='" . $proses_terlibat[$u] . "' &gt;");
            }

            for ($e = 0; $e < count($cek_pengiriman); $e++) {
                echo html_entity_decode($inputBuka . "type='hidden' name='pengiriman[]' value='" . $cek_pengiriman[$e] . "' &gt;");
            }
            echo html_entity_decode($inputBuka . "type='hidden' name='hari_bersangkutan' value='" . $mingguIni[$t] . "' &gt;");
            echo html_entity_decode($inputBuka . "type='hidden' name='hari_minimal' value='" . $hari_minimal->format('Y-m-d') . "' &gt;");
            echo html_entity_decode($inputBuka . "type='hidden' name='pesanan' value='" . $banyakPesanan[$i] . "' &gt;");
            echo html_entity_decode($buttonBuka . "type='submit' class='btnSubmit'&gt;Submit" . $buttonTutup . $formTutup . $divTutup . $divTutup);


            echo html_entity_decode($divBuka . "class='modal' id='" . $myMesin . "' &gt;" . $divBuka . "class='modal-content'&gt;");
            echo html_entity_decode($spanBuka . "class='closeModal' onClick=" . '"' . "tutup('" . $myMesin . "')" . '"' . "&gt;&times" . $spanTutup);
            echo html_entity_decode($formBuka . " method='post' action='action_page_mesin.php' class='form-containerActual'&gt;" . $h1Buka . "Mesin injeksi rusak" . $h1Tutup . $pBuka . "Kode Pesanan : " . $banyakPesanan[$i] . $pTutup . $pBuka . "Tanggal :" . $mingguIni[$t] . $pTutup);
            echo html_entity_decode($inputBuka . "type='hidden' name='hari_bersangkutan' value='" . $mingguIni[$t] . "' &gt;");
            echo html_entity_decode($inputBuka . "type='hidden' name='pesanan' value='" . $banyakPesanan[$i] . "' &gt;");
            echo html_entity_decode("Apakah mesin ini rusak dan anda ingin meggantinya? &lt;br&gt;" . $buttonBuka . "type='submit' class='btnSubmit'&gt;YES" . $buttonTutup . $formTutup . $divTutup . $divTutup);

            echo html_entity_decode($tdTutup . $trTutup);
        } else {
            echo html_entity_decode("&lt;td colspan=3 class='submitButton'&gt;" . $buttonBuka . "class='open-submitActual' onclick=" . '"' . "buka('" . $myModal . "')" . '"' . "&gt;Submit actual" . $buttonTutup . " " . $buttonBuka . "class='open-submitActual' onclick=" . '"' . "buka('" . $myMesin . "')" . '"' . "&gt;Submit Mesin" . $buttonTutup);
            echo html_entity_decode($divBuka . "class='modal' id='" . $myModal . "' &gt;" . $divBuka . "class='modal-content'&gt;");
            echo html_entity_decode($spanBuka . "class='closeModal' onClick=" . '"' . "tutup('" . $myModal . "')" . '"' . "&gt;&times" . $spanTutup);
            echo html_entity_decode($formBuka . " method='post' action='action_page.php' class='form-containerActual'&gt;" . $h1Buka . "Input Actual" . $h1Tutup . $pBuka . "Kode Pesanan : " . $banyakPesanan[$i] . $pTutup . $pBuka . "Tanggal :" . $mingguIni[$t] . $pTutup);

            for ($u = 0; $u < count($cek_banyak_proses); $u++) {
                echo html_entity_decode($labelBuka . "for='email'&gt;" . $bBuka . $cek_banyak_proses[$u] . $bTutup . $labelTutup . $inputBuka . "type='text' placeholder='Masukkan jumlah actual' name='email[]'&gt;");
                echo html_entity_decode($inputBuka . "type='hidden' name='proses_terlibat[]' value='" . $proses_terlibat[$u] . "' &gt;");
            }
            for ($e = 0; $e < count($cek_pengiriman); $e++) {
                echo html_entity_decode($inputBuka . "type='hidden' name='pengiriman[]' value='" . $cek_pengiriman[$e] . "' &gt;");
            }
            echo html_entity_decode($inputBuka . "type='hidden' name='hari_bersangkutan' value='" . $mingguIni[$t] . "' &gt;");
            echo html_entity_decode($inputBuka . "type='hidden' name='pesanan' value='" . $banyakPesanan[$i] . "' &gt;");
            echo html_entity_decode($inputBuka . "type='hidden' name='hari_minimal' value='" . $hari_minimal->format('Y-m-d') . "' &gt;");
            echo html_entity_decode($buttonBuka . "type='submit' class='btnSubmit'&gt;Submit" . $buttonTutup . $formTutup . $divTutup . $divTutup);


            echo html_entity_decode($divBuka . "class='modal' id='" . $myMesin . "' &gt;" . $divBuka . "class='modal-content'&gt;");
            echo html_entity_decode($spanBuka . "class='closeModal' onClick=" . '"' . "tutup('" . $myMesin . "')" . '"' . "&gt;&times" . $spanTutup);
            echo html_entity_decode($formBuka . " method='post' action='action_page_mesin.php' class='form-containerActual'&gt;" . $h1Buka . "Mesin injeksi rusak" . $h1Tutup . $pBuka . "Kode Pesanan : " . $banyakPesanan[$i] . $pTutup . $pBuka . "Tanggal :" . $mingguIni[$t] . $pTutup);
            echo html_entity_decode($inputBuka . "type='hidden' name='hari_bersangkutan' value='" . $mingguIni[$t] . "' &gt;");
            echo html_entity_decode($inputBuka . "type='hidden' name='pesanan' value='" . $banyakPesanan[$i] . "' &gt;");
            echo html_entity_decode("Apakah mesin ini rusak dan anda ingin meggantinya? &lt;br&gt;" . $buttonBuka . "type='submit' class='btnSubmit'&gt;YES" . $buttonTutup . $formTutup . $divTutup . $divTutup);





            echo html_entity_decode($tdTutup);
        }
        echo count($cek_banyak_proses);
    }
}

echo "</tbody>";
echo "</table>";
