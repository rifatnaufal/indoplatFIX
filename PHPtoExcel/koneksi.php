<html>

<body>
    <?php
    $servername = "localhost";
    $dbh_username = "root";
    $dbh_password = "";
    $db_name = "import_excel_indoplat";

    $conn = mysqli_connect($servername, $dbh_username, $dbh_password, $db_name);

    if (!$conn) {
        die("connection failed" . mysqli_connect_error());
    }

    ?>

</body>

</html>