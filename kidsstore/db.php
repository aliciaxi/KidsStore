<?php
include("navbar.php"); 

$host = "localhost";
$port = "3307"; // dacă ai schimbat portul MySQL la 3307
$user = "root";
$pass = "";
$dbname = "kidsstore"; // numele bazei tale de date

$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}
?>
