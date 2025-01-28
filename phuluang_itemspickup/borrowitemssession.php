<?php
session_start();


// foreach ($_SESSION['items'] as $key => $value) {
//     // echo''.$key.''.$value.'';
//     foreach ($value as $k => $v) {
//         // echo '' . '' . $v . '';
//         if ($v == $_POST['items']) {
//             echo "$key dub ";
//             $_SESSION['items'][$k] = [];
//         }
//     }
// }

// foreach ($_SESSION['items'] as $key => $value) {
//     // echo''.$key.''.$value.'';
//     foreach ($value as $k => $v) {
//         echo '' . $k . '' . $v . '';

//     }
// }

// echo $_POST['items'];
// $items = array("ss", "aa");
// echo $_SESSION['items'];
// foreach ($_SESSION['items'][0] as $key => $value) {
//     echo''. $key .''. $value .'';
// }
if (isset($_POST['items'])) {
    $key = array_search($_POST['items'], $_SESSION['items'][0]);
    echo '' . $key . '';
    if ($key !== false) {
        unset($_SESSION['items'][0][$key]);
    }

}

?>