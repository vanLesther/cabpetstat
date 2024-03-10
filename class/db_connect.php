<?php
// $servername = "petstat-server.mysql.database.azure.com";
// $username = "pgwsyvsiti";
// $password = "455SGCBRI15EHBWB$";
// $dbname = "petstat-server";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "{path to CA cert}", NULL, NULL);
mysqli_real_connect($conn, "petstat-server.mysql.database.azure.com", "pgwsyvsiti", "455SGCBRI15EHBWB$", "petstat-server", 3306, MYSQLI_CLIENT_SSL);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
