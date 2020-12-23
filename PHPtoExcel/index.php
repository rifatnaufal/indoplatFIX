<!DOCTYPE html>
<html>

<head>
	<title>Mari Belajar Coding</title>
	<?php
	//include 'koneksi.php';
	?>
</head>

<body>
	<?php
	if (isset($_POST['upload'])) {
		require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
		require('spreadsheet-reader-master/SpreadsheetReader.php');
		//upload data excel kedalam folder uploads
		$target_dir = "uploads/" . basename($_FILES['filemhsw']['name']);
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
			// import data excel mulai baris ke-2 (karena ada header pada baris 1)
			 
			
			if ($Row[0]!='no') {
				if ($Row[0]=='tgl kirim') {
					if ($i!=0) {
						$nama_pemesan_besar[$i]=$nama_pemesan_kecil;
						$part_besar[$i]=$part_kecil;
						$qty_besar[$i]=$qty_kecil;
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
						$nama_pemesan_besar[$i]=$nama_pemesan_kecil;
						$part_besar[$i]=$part_kecil;
						$qty_besar[$i]=$qty_kecil;
						$nama_pemesan_kecil=[];
						$part_kecil=[];
						$qty_kecil=[];						
						$tgl_kirim_kecil=[];
					}
				} 				

			}
			/* if ($Row[0] == 'tgl Pengiriman') {
				break;
			}  */
			
		}
/* 
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
		echo '</pre>'; */
	}
	?>
	
</body>

</html>