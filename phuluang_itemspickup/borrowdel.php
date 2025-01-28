<?php
require 'connectmysql.php';
require 'sessionlogin.php';
$id = $_POST['id'];

// foreach ($_POST as $key => $value) {
//   echo''. $key .' '. $value .' ';
// }

// $sqlborrowdetail = "DELETE FROM borrow WHERE id=$id";

$sql = "
DELETE FROM borrowdetail WHERE id_borrow='$id';
DELETE FROM borrow WHERE id='$id';
";

if ($conn->multi_query($sql) === TRUE) {
  // echo "Record deleted successfully";
  header("location: /phuluang_itemspickup/borrow.php");
} else {
  // echo "Error deleting record: " . $conn->error;
  header("location: /phuluang_itemspickup/borrow.php");  
}
?>