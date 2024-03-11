<?php
// $servername = "http://20.168.8.174/";
// $username = "van";
// $password = "As@dawe123";
// $dbname = "petstat";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "{path to CA cert}", NULL, NULL);
mysqli_real_connect($conn, "http://20.168.8.174/", "van", "As@dawe123", "petstat", 3306, MYSQLI_CLIENT_SSL);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
