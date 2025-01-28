<?php
//  ini_set('display_errors', 0);
require 'connectmysql.php';
require 'sessionlogin.php';
$date = $_POST['date'];
$date_due = $_POST['date_due'];
$name = $_POST['name'];
$activework = $_POST['activework'];
$note = $_POST['note'];
$items = $_POST['items'];
$id = $_SESSION["id"];
$sql = "";
// foreach ($items as $key => $value) {
//   echo " $key => $value";
//   $sql .= "INSERT INTO borrow (id_user, id_items, date,name,quantity,activework,note)
//   VALUES ('$id', '$key', '$date', '$name', '$value', '$activework', '$note');";
// }

// echo $sql;
$sql .= "INSERT INTO borrow (id_user, date,name,activework,note,date_due)
  VALUES ('$id', '$date', '$name', '$activework', '$note','$date_due');";

if ($conn->multi_query($sql) === TRUE) {
  echo "New record created successfully";
  $sql = "";
  $last_id = $conn->insert_id;
  foreach ($items as $key => $value) {
    echo " $key => $value";
    $sql .= "INSERT INTO borrowdetail (id_borrow , id_items , quantity) VALUES ('$last_id', '$key','$value');";
  }
  echo $sql;
  if ($conn->multi_query($sql) === TRUE) {
    header("location: /phuluang_itemspickup/borrow.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("location: /phuluang_itemspickup/borrow.php");
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  header("location: /phuluang_itemspickup/borrow.php");
}


?>