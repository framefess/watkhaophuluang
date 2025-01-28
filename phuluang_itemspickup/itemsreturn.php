<?php
require 'connectmysql.php';
require 'sessionlogin.php';
$_SESSION['items'] = [];
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
/* 
    main {
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


    tbody>tr>th,
    tbody>tr>td:nth-child(n+3):not(:last-child) {
      text-align: center;
    }

    .imgclose {
      right: 0px;
      position: absolute;
    }

    div.itemname {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
    }

    @media only screen and (max-width: 576px) {
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
            <div class="row">
              <div class="col d-flex justify-content-end">
                <input class="form-control m-2" id="myInput" type="text" placeholder="ค้นหา..">
              </div>

            </div>

            <div class="table-responsive-sm">
              <table class="table table-bordered caption-top align-middle">
                <caption>รายการยืม</caption>
                <thead>
                  <tr class="text-center text-nowrap">
                    <th scope="col" style="width: 0%;">#</th>
                    <th scope="col" style="width: 0%;">วันที่คืน</th>
                    <!-- <th scope="col" style="width: 0%;">วันที่ยืม</th> -->
                    <th scope="col" style="width: 0%;">เลขที่</th>
                    <th scope="col" style="width: 30%">งานที่ใช้</th>
                    <th scope="col" style="width: 30%;">ชื่อผู้ยืม</th>
                    <th scope="col" style="width: 0%;">ACTION</th>
                    <th scope="col" style="width: 10%;">หมายเหตุ</th>
                  </tr>
                </thead>
                <tbody id="myTable">
                  <?php
                  $sql = "SELECT * FROM borrow where status='success' ORDER BY date_return DESC,date DESC,id desc;";
                  // echo $sql;
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    // output data of each row
                    $irow = 0;
                    $items = array();
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo '<th scope="row">' . ($irow++) + 1 . "</th>";
                      
                      echo '<td style="white-space: nowrap;width: 1%;"><a href="reportborrow.php?p=2&bid=' . $row["id"] . '" target="_blank">' . date("Y/m/d", strtotime('+543 year',strtotime($row["date_return"]))) . '</a></td>';
                      // echo "<td style='white-space: nowrap;width: 1%;'>" . date("Y/m/d", strtotime('+543 years', strtotime($row["date"]))) . '</td>';
                      echo "<td>" . $row["id"] . "</td>";
                      echo "<td>" . '<a href="borrowdetail.php?id=' . $row["id"] . '&page=itemsreturn">' . $row["activework"] . "</a></td>";
                      echo "<td>" . $row["name"] . "</td>";
                      // $editget = "id=" . $row["id"] . "&name=" . $row["name"] . "&quantity=" . $row["quantity"] . "&note=" . $row["note"] . "&img=" . $row["image"];
                      echo '<td class="p-1">';
                      echo '<button type="button" style="width:40px;font-size:smaller;" class="p-0 mt-1 btn btn-outline-success btn-sm" onclick="location.href=' . "'" . "borrowreturncancel.php?id=".$row["id"]."'" . '">ยกเลิก</button>';
                      echo "<td>" . $row["note"] . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    // echo "0 results";
                  }
                  ?>
                  <!-- onclick="del(' . "'" . $row["id"] . "'" . ')" -->
                </tbody>
              </table>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
  <!-- Modal2 -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="row">
            <div class="col p-3">
              <span class="text-center"></span>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <form class="row g-3" action="borrowdel.php" method="post">
                <input id="borrow_id" type="text" class="form-control" id="id" name="id" hidden>
                <button data-id="" type="submit" class="btn btn-danger">ยืนยัน</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">ยกเลิก</button>
              </form>
            </div>
          </div>
        </div>
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

    function delmodal(data) {
      // console.log($(data).data("name"));
      $("#exampleModal2 > div > div > div > div:nth-child(1) > div > span").html("ลบ </br>" + $(data).data("name"));
      $("#borrow_id").val($(data).data("id"));

      // console.log($("#itemsdel").attr("data-id"));
    }
    // function deli(id) {
    //   console.log($(id).data("id"));
    //   loca
    // }
    // Filter Tables
    $(document).ready(function () {
      $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
</body>

</html>