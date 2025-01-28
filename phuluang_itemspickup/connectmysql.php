<?php

date_default_timezone_set('Asia/Bangkok');
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phuluang";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

}

// echo "<script>console.log('Mysql Connected successfully' );</script>";
?>