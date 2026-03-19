<?php
$servername = 'localhost';
$username   = 'kayiranga';
$password   = 'donca';
$dbname     = 'year1c';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_errno) {
    exit('Connection Failed: ' . $conn->connect_error);
}
?>