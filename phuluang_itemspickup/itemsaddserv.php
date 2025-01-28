<?php
//  ini_set('display_errors', 0);
require 'connectmysql.php';
require 'sessionlogin.php';
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$note = $_POST['note'];
// $fileimg = $_POST['fileimg'];
echo $_FILES["fileimg"]["error"];
// foreach ($_POST as $key => $value) {
//   echo''. $key .' '. $value .' ';
// }
if ((isset($_FILES['fileimg']['error']) || is_array($_FILES['fileimg']['error'])) && $_FILES['fileimg']['error'] == 0) {
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileimg"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["fileimg"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
  if ($result === false) {
    header("Location: errorpage.php");
    exit;
  }

  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    $ext = explode(".", basename($_FILES["fileimg"]["name"]));
    echo "</br>";
    echo count($ext);
    echo "</br>";

    $target_file = $target_dir . basename($name . "." . $ext[count($ext) - 1]);
    if (move_uploaded_file($_FILES["fileimg"]["tmp_name"], $target_file)) {
      echo "The file " . htmlspecialchars(basename($target_file)) . " has been uploaded.";
      $sql = "INSERT INTO items (name, quantity, note,image)
VALUES ('$name', '$quantity', '$note','$target_file')";
      echo $sql;

      if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("location: /phuluang_itemspickup/items.php");
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("location: /phuluang_itemspickup/items.php");
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
} else {
  $sql = "INSERT INTO items (name, quantity, note)
  VALUES ('$name', '$quantity', '$note')";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("location: /phuluang_itemspickup/items.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("location: /phuluang_itemspickup/items.php");
  }
}


?>