<?php
// echo "<script>console.log('session');</script>";
if (!isset($_SESSION["id"])) {
    // echo "<script>console.log('$id');</script>";
    header("location: /phuluang_itemspickup");
    exit(0);
} else {
    $id = $_SESSION["id"];
    $sql = "select activity from user WHERE id='$id' limit 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo $result;
    // $row = $result[;
    // echo $row['activity'];
    $addingtime = strtotime($row['activity'] . ' + 30 minute');
    if (time() > $addingtime) {
        header("location: /phuluang_itemspickup/logout.php");
        exit(0);
    } else {
        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
            $sql = "UPDATE user SET activity=now() WHERE id='$id'";
            $result = $conn->query($sql);
        }
    }
    // echo "<script>console.log('$id');</script>";
    // echo "have";
}
?>