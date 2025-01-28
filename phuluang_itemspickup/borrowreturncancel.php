<?php
//  ini_set('display_errors', 0);
require 'connectmysql.php';
require 'sessionlogin.php';
$id = $_GET['id'];

  $date = date('Y-m-d', time());
  $sql = "UPDATE borrow SET status='active',date_return='0000-00-00 00:00:00' WHERE id='$id'";
  echo $sql;
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("location: /phuluang_itemspickup/itemsreturn.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("location: /phuluang_itemspickup/itemsreturn.php");
  }



?>