<?php
$servername = "localhost";
$username = "root";
$password = "bf@r2025";
$db = "dairymart";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";