<?php
require 'connectmysql.php';
require 'sessionlogin.php';
$id = $_POST['id'];

// foreach ($_POST as $key => $value) {
//   echo''. $key .' '. $value .' ';
// }
$sql = "DELETE FROM items WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  // echo "Record deleted successfully";
  header("location: /phuluang_itemspickup/items.php");
} else {
  // echo "Error deleting record: " . $conn->error;
  header("location: /phuluang_itemspickup/items.php");  
}
?>