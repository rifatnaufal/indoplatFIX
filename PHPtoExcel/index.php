<!DOCTYPE html>
<html>

<head>
	<title>Mari Belajar Coding</title>
	<?php
	include 'koneksi.php';
	?>
</head>

<body>

	<table>
		<!--form upload file-->
		<form method="post" enctype="multipart/form-data">
			<tr>
				<td>Pilih File</td>
				<td><input name="filemhsw" type="file" required="required"></td>
			</tr>
			<tr>
				<td></td>
				<td><input name="upload" type="submit" value="Import"></td>
			</tr>
		</form>
	</table>
	<?php
	if (isset($_POST['upload'])) {

		require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
		require('spreadsheet-reader-master/SpreadsheetReader.php');

		//upload data excel kedalam folder uploads
		$target_dir = "uploads/" . basename($_FILES['filemhsw']['name']);

		move_uploaded_file($_FILES['filemhsw']['tmp_name'], $target_dir);

		$Reader = new SpreadsheetReader($target_dir);

		foreach ($Reader as $Key => $Row) {
			// import data excel mulai baris ke-2 (karena ada header pada baris 1)
			/* echo '<pre>';
			print_r($Row[0]);
			echo '</pre>';
			if ($Row[0] == 'tgl Pengiriman') {
				break;
			} */
			if ($Key < 1) continue;
			$query = mysqli_query($conn, "INSERT INTO mps(kode_produksi, nama_pemesan, nama_part, qty, tanggal_kirim) VALUES ('" . $Row[0] . "', '" . $Row[1] . "','" . $Row[2] . "','" . $Row[3] . "','" . $Row[4] . "')");
		}
		if ($query) {
			echo "Import data berhasil";
		} else {
			echo mysqli_connect_error();
		}
	}
	?>
	<h2>Jadwal Produksi</h2>
	<table border="1">
		<tr>
			<th>Kode Produksi</th>
			<th>Nama Pemesan</th>
			<th>Nama Part</th>
			<th>Qty</th>
			<th>Tanggal Kirim</th>
		</tr>
		<?php
		$no = 1;
		$data = mysqli_query($conn, "select * from mps");
		while ($d = mysqli_fetch_array($data)) {
		?>
			<tr>
				<td><?= $d['kode_produksi']; ?></td>
				<td><?= $d['nama_pemesan']; ?></td>
				<td><?= $d['nama_part']; ?></td>
				<td><?= $d['qty']; ?></td>
				<td><?= $d['tanggal_kirim']; ?></td>
			</tr>
		<?php
		}
		?>
	</table>
</body>

</html>