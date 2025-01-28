<?php
require 'connectmysql.php';
// echo $_POST["name"];
// echo $_POST["password"];
// echo "test";
// echo "<br>";
$id = $_POST["name"];
$password = $_POST["password"];
$sql = "SELECT id, password FROM user where id='$id' and password='$password'";
$result = $conn->query($sql);
$n = 0;

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $n++;
        // echo "id: " . $row["id"] . " - Password: " . $row["password"] . "<br>";
        $_SESSION['id'] = $row["id"];
    }
    // echo $n;
    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $sql = "UPDATE user SET activity=now() WHERE id='$id'";
        $result = $conn->query($sql);
    }
    header("location: /phuluang_itemspickup/items.php");
    exit(0);
} else {
    // echo "0 results";
    header("location: /phuluang_itemspickup/index.php?status=fail");
    exit(0);
}
?>