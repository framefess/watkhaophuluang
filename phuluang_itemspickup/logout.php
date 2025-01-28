<?php
require 'connectmysql.php';

$id = $_SESSION["id"];
$sql = "UPDATE user SET activity='0000-00-00 00:00:00' WHERE id='$id'";
$result = $conn->query($sql);

session_unset(); // unset $_SESSION variable for the run-time 
session_destroy();
header("location: /phuluang_itemspickup/index.php");
?>