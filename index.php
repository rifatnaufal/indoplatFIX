<html>

<head>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="tabel.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar" id="mySidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="#">Timeline</a>
    </div>

    <div>
        <div id="main">
            <button class="openbtn" onclick="openNav()">☰</button>

            <div class="dropdown">
                <button class="dropbtn"><img src="profile-icon.png" width="20px" height="15px"> ADMIN</button>
                <div class="dropdown-content">
                    <a href="#">Edit</a>
                    <a href="#">Logout</a>
                </div>
            </div>
        </div>

        <h2 style="margin-left: 130px; margin-top: 40px;">PENJADWALAN PRODUKSI</h2>

        <div style="margin-top: 20px; width:100vw; height: 42vh; display:flex; justify-content:
        center;" class="tabel1">

            <table style="width:40%;">
                <thead>
                    <tr>
                        <th>KODE PRODUKSI</th>
                        <th>PROSES</th>
                        <th>JUMLAH PRODUKSI</th>
                        <th>TANGGAL PRODUKSI</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <tr>
                        <td>PES-1</td>
                        <td>Injection</td>
                        <td>480</td>
                        <td>01-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-2</td>
                        <td>Plating</td>
                        <td>500</td>
                        <td>08-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-3</td>
                        <td>Painting</td>
                        <td>600</td>
                        <td>14-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-4</td>
                        <td>Sub-Assy</td>
                        <td>820</td>
                        <td>22-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-5</td>
                        <td>Finishing</td>
                        <td>910</td>
                        <td>30-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-6</td>
                        <td>QC</td>
                        <td>540</td>
                        <td>04-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-7</td>
                        <td>Injection</td>
                        <td>700</td>
                        <td>09-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-8</td>
                        <td>QC</td>
                        <td>900</td>
                        <td>18-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-9</td>
                        <td>Plating</td>
                        <td>1000</td>
                        <td>22-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-10</td>
                        <td>Finishing</td>
                        <td>600</td>
                        <td>29-11-2020</td>
                    </tr>
                </tbody>
            </table>
            <table style="width:45%;">
                <thead>
                    <tr>
                        <th>SENIN</th>
                        <th class="warna-hari">SELASA</th>
                        <th>RABU</th>
                        <th>KAMIS</th>
                        <th>JUMAT</th>
                        <th>SABTU</th>
                        <th class="warna-minggu">MINGGU</th>
                    </tr>
                </thead>
                <tbody>
                    <div>
                        <tr>
                            <td>-</td>
                            <td class="warna-1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>-</td>
                            <td class="warna">2000</td>
                            <td>-</td>
                            <td>1300</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>-</td>
                            <td class="warna-1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>500</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna-1">2000</td>
                            <td>200</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>1000</td>
                            <td class="warna"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna-1">750</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>-</td>
                            <td class="warna">2000</td>
                            <td>-</td>
                            <td>1300</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>-</td>
                            <td class="warna-1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>500</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </div>
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px; width:100vw; height: 42vh; display:flex; justify-content:
        center;" class="tabel2">

            <table style="width:40%;">
                <thead>
                    <tr>
                        <th>KODE PRODUKSI</th>
                        <th>PROSES</th>
                        <th>JUMLAH PRODUKSI</th>
                        <th>TANGGAL PRODUKSI</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <tr>
                        <td>PES-1</td>
                        <td>Injection</td>
                        <td>480</td>
                        <td>01-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-2</td>
                        <td>Plating</td>
                        <td>500</td>
                        <td>08-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-3</td>
                        <td>Painting</td>
                        <td>600</td>
                        <td>14-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-4</td>
                        <td>Sub-Assy</td>
                        <td>820</td>
                        <td>22-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-5</td>
                        <td>Finishing</td>
                        <td>910</td>
                        <td>30-10-2020</td>
                    </tr>
                    <tr>
                        <td>PES-6</td>
                        <td>QC</td>
                        <td>540</td>
                        <td>04-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-7</td>
                        <td>Injection</td>
                        <td>700</td>
                        <td>09-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-8</td>
                        <td>QC</td>
                        <td>900</td>
                        <td>18-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-9</td>
                        <td>Plating</td>
                        <td>1000</td>
                        <td>22-11-2020</td>
                    </tr>
                    <tr>
                        <td>PES-10</td>
                        <td>Finishing</td>
                        <td>600</td>
                        <td>29-11-2020</td>
                    </tr>
                </tbody>
            </table>
            <table style="width:45%;">
                <thead>
                    <tr>
                        <th>SENIN</th>
                        <th class="warna-hari">SELASA</th>
                        <th>RABU</th>
                        <th>KAMIS</th>
                        <th>JUMAT</th>
                        <th>SABTU</th>
                        <th class="warna-minggu">MINGGU</th>
                    </tr>
                </thead>
                <tbody>
                    <div>
                        <tr>
                            <td>1000</td>
                            <td class="warna-1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>500</td>
                            <td class="warna">2000</td>
                            <td>-</td>
                            <td>1300</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>200</td>
                            <td class="warna-1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>300</td>
                            <td class="warna"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>500</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna-1">2000</td>
                            <td>200</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>1000</td>
                            <td class="warna"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna-1">750</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>-</td>
                            <td class="warna">2000</td>
                            <td>-</td>
                            <td>1300</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>

                            <td>-</td>
                            <td class="warna-1"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td class="warna"></td>
                            <td>-</td>
                            <td>-</td>
                            <td>500</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </div>
                </tbody>
            </table>

        </div>
    </div>

    </div>
    </div>
    <div class="pagination" style="margin-left: 85em; ">
        <a id="prev">&laquo; Prev</a>
        <a id="next">Next &raquo;</a>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "150px";
            document.getElementById("main").style.marginLeft = "150px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }

        $(document).ready(function() {
            $("#prev").click(function() {
                $(".tabel1").show();
                $(".tabel2").hide();
            });
            $("#next").click(function() {
                $(".tabel1").hide();
                $(".tabel2").show();
            });
        });
    </script>
</body>

</html>