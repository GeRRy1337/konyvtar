<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "c31j202121";

// kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// kapcsolat ellenőrzése
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>