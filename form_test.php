<!DOCTYPE html>
<?php
require 'db.php';
?>
<html>

<head>
  <title>Form Input Pesanan</title>
  <link rel="stylesheet" href="form.css">
</head>

<body>
  <h2 class="judul">Form Input Pesanan</h2>
  <form action="form_test1_fetch_excel.php" method="POST" id="formTanggal" onkeydown="return event.key != 'Enter';">
    <div class="cardInput">
      <p>
        <label>Nama Pemesan:</label>
        <input type="text" name="nama" placeholder="Nama Pemesan..." />
      </p>
      <p>
        <label>Nama Part yang dipesan:</label>
        <input type="text" name="namapart" placeholder="Nama Part..." />
      </p>
      <p>
        <label>Jumlah part:</label>
        <input type="text" name="JumlahPart" placeholder="Jumlah Part..." />
      </p>
      <p>
        <label>Proses:</label>
        
        <div style="padding: 0; margin-top: -5px;margin-bottom:20px;display: flex; flex-wrap: wrap;align-content:center;justify-content: space-around; "> 
        <?php
        $sql_proses = "SELECT * from proses";
        $result = mysqli_query($conn, $sql_proses);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        ?>
        
        <div style="display: inline-block;padding:0;margin:0;width:90px; height: 60px; align: center;">
          <input type="checkbox" class="checkmark" name='checkboxvar[]' value=<?php echo $row['kode_proses']; ?> />
        <span ><?php echo '<br>';echo $row['nama_proses']; ?></span>
        </div>
        
        <?php
        }
        ?>
        </div>
      </p>
      <p>
        <label>Jumlah Pengiriman:</label>
        <input type="number" onChange=fungsiJmlKirim() id="jumlahkirim" name="jumlahkirim" min="1" style="width: 4em;">
        <script>
          function fungsiJmlKirim() {
            document.getElementById("tanggal").innerHTML = "";
            var banyak = document.getElementById("jumlahkirim").value;
            console.log(banyak);
            var y = document.createElement("INPUT");
            y.setAttribute("type", "hidden");
            y.setAttribute("value", banyak);
            y.setAttribute("name", "banyakTanggal");
            document.getElementById("tanggal").appendChild(y);
            for (var i = 0; i < banyak; i++) {
              var x = document.createElement("INPUT");
              var str1 = "tanggalkirim";
              var str2 = i;
              var res = str1.concat(str2);
              x.setAttribute("type", "date");
              x.setAttribute("name", res);
              document.getElementById("tanggal").appendChild(x);
            }
          }

          function popupBox() {
            alert("Data berhasil disimpan.");
          }
        </script>
      </p>
      <!-- Menampilkan banyaknya tanggal pengiriman -->
      <div id="tanggal">
      </div>
      <div>
        <input id="Simpan" type="submit" name="simpan" value="Simpan" onclick="popupBox()" />
      </div>
    </div>

  </form>
</body>

</html>