  <?php
$server="127.0.0.1";
$username="root";
$password="3005";
$database = "indoplat";

/* Create database  connection with correct username and password*/

$conn=new mysqli($server,$username,$password,$database);

/* Check the connection is created properly or not */
if($conn->connect_error)
    echo "Connection error:" .$connect->connect_error;

  ?>
