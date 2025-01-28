<?php
require 'connectmysql.php';
require 'sessionlogin.php';
// if (isset($_SESSION['items']) && $_SESSION['items']) {
//   foreach ($_SESSION['items'] as $key => $value) {
//     // echo '' . $key . ' ' . $value . ' //';
//     foreach ($value as $key2 => $value2) {
//       echo 'key ' . $key2 . ' ' . $value2 . ' //';
//     }
//   }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'header.php';
  ?>
  <style>
    body {
      font-family: 'Chakra Petch', sans-serif;
      font-weight: 600;
      min-height: 100vh;
      min-height: -webkit-fill-available;
    }

    html {
      height: -webkit-fill-available;
    }

    /* main {
      height: 100vh;
      height: -webkit-fill-available;
      max-height: 100vh;
      overflow-x: auto;
      overflow-y: hidden;
    } */

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
      color: var(--bs-nav-pills-link-active-color);
      background-color: #001d69;
    }

    .feather {
      width: 30px;
      height: 30px;
      stroke: currentColor;
      stroke-width: 3;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
    }

    .nav-item.active {
      --bs-nav-link-color: gold;
    }

    tbody>tr>th,
    tbody>tr>td {
      text-align: center;
    }

    div.itemname {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
    }

    .imgclose {
      right: 0px;
      position: absolute;
    }

    @media only screen and (max-width: 576px) {
      main {
        font-size: medium;
      }

      table {
        font-size: small;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
      <?php include 'sidebar.php' ?>
      <div class="col d-flex flex-column h-100">
        <main class="row">
          <div class="col pt-4">
            <div class="row justify-content-center">
              <div class="col text-center display-1 fw-bold">ยืมสิ่งของ</div>
            </div>
            <div class="row">
              <div class="col p-4">
                <form class="row g-3" action="borrowadd2.php" method="post">
                  <div class="col-12">
                    <table class="table caption-top table-striped">
                      <caption>รายการสิ่งของ<input class="form-control m-2" id="myInput" type="text" placeholder="ค้นหา.."></caption>
                      <thead>
                        <tr class="text-center text-nowrap">
                          <th scope="col" style="width: 1%;">#</th>
                          <th scope="col">รายการ</th>
                          <th scope="col" style="width: 1%;">เหลือ</th>
                          <th scope="col" style="width: 1%;">เลือก</th>
                        </tr>
                      </thead>
                      <tbody id="myTable">
                        <?php
                        // echo isset($_SESSION['items']);
                        $sql = "SELECT * FROM items";
                        $result = $conn->query($sql);
                        $left = "";
                        if ($result->num_rows > 0) {
                          // output data of each row
                          $irow = 0;
                          $items = array();
                          while ($row = $result->fetch_assoc()) {
                            $check = "";
                            // $sqlleft = 'SELECT i.id, (i.quantity - IFNULL(sum(b.quantity),0) + IFNULL(sum(br.quantity), 0)) AS "LEFT" 
                            // FROM items i 
                            // left JOIN borrowdetail b 
                            // ON i.id = b.id_items 
                            // left JOIN borrowreturn br 
                            // ON b.id_items = br.id_items 
                            // where i.id ="' . $row["id"] . '"
                            // GROUP by i.id;';
                            $sqlleft = 'SELECT i.id, (i.quantity - IFNULL(sum(b.quantity),0)) AS "LEFT" 
                            FROM items i 
                            left JOIN borrowdetail b 
                            ON i.id = b.id_items 
                            left join borrow bb
                            on b.id_borrow = bb.id
                            where i.id ="' . $row["id"] . '" and (bb.status = "active" or bb.status is null) 
                            GROUP by i.id;';
                            // echo  $sqlleft;
                            $resultleft = $conn->query($sqlleft);
                            $resultleft = $resultleft->fetch_assoc();
                            if (isset($resultleft['LEFT'])) {
                              $left = $resultleft['LEFT'];
                            }
                            // if ($resultleft->num_rows > 0) {
                            //   $resultleft = $resultleft->fetch_assoc();
                            //   $left =$resultleft['LEFT'];
                            // } 

                            if ($left != '0') {
                              echo "<tr>";
                              echo '<th scope="row">' . $irow + 1 . "</th>";
                              if (isset($row["image"]) && $row["image"] != null && $row["image"] != "") {
                                $img = $row["image"];
                                $imgtd = '<a class="aaa" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="previewimgm(' . "'" . $img . "'" . ')"><i data-feather="image" style="width:25px;height:25px;"></i></a>';
                              } else {
                                $imgtd = "";
                              }
                              echo "<td><div class='itemname'>" . $row["name"] . $imgtd . ' </div></td>';
                              if ($left > 0) {
                                echo "<td>" . ($left > 0 ? $left : ($row["quantity"] == -1 ? "∞" : $row["quantity"])) . "</td>";
                              } else {
                                echo "<td>" . ($row["quantity"] == -1 ? "∞" : $row["quantity"]) . "</td>";
                              }
                              if (isset($_SESSION['items']) && $_SESSION['items']) {
                                foreach ($_SESSION['items'] as $key => $value) {
                                  // echo '' . $key . ' ' . $value . ' //';
                                  foreach ($value as $key2 => $value2) {
                                    if ($value2 == $row["id"]) {
                                      $check = "checked";
                                    }
                                  }
                                }
                              }
                              echo '<td><input class="form-check-input" type="checkbox" name="items[]" id="' . $row["id"] . '" value="' . $row["id"] . '"' . " $check></td>";
                              echo "</tr>";
                              $irow++;
                            }
                            $left = "";
                          }
                        } else {
                          // echo "0 results";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-12 text-center pt-3">
                    <button type="submit" class="btn btn-success">ต่อไป</button>
                    <button type="button" class="btn btn-danger" onclick="location.href='borrow.php'">ยกเลิก</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close imgclose" data-bs-dismiss="modal" aria-label="Close"></button>
        <img id="imgm" src='' alt="" />
      </div>
    </div>
  </div>
  <?php
  include "sfooter.php";
  ?>
  <script type="text/javascript">
    function previewimgm(pathimg) {
      // console.log(pathimg);
      document.getElementById("imgm").src = pathimg.replace(" ", "/");
    }
    $(document).ready(function() {
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
</body>

</html>