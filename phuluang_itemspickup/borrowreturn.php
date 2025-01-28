<?php
//  ini_set('display_errors', 0);
require 'connectmysql.php';
require 'sessionlogin.php';
$id = $_GET['id'];

  $date = date('Y-m-d', time());
  $sql = "UPDATE borrow SET date_return='$date',status='success' WHERE id='$id'";
  echo $sql;
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("location: /phuluang_itemspickup/borrow.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("location: /phuluang_itemspickup/borrow.php");
  }



?>