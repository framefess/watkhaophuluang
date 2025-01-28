<?php
require 'connectmysql.php';
require 'sessionlogin.php';

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
                <caption>รายการสิ่งของ</caption>
                <button type="button" class="btn btn-success" style="width: 100px;" onclick="location.href='itemsadd.php';">เพิ่ม</button>
                <button type="button" class="btn btn-primary" style="width: auto;margin:5px;" onclick="window.open('reportborrow.php?p=1')">ออกรายงานสิ่งของ</button>
                <thead>
                  <tr class="text-center text-nowrap">
                    <th scope="col" style="width: 0%;">#</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col" style="width: 0%;">จำนวน</th>
                    <th scope="col" style="width: 0%;">เหลือ</th>
                    <th scope="col" style="width: 1%;">ACTION</th>
                    <th scope="col" style="width: 20%;">หมายเหตุ</th>
                  </tr>
                </thead>
                <tbody id="myTable">
                  <?php
                  $sql = "SELECT * FROM items";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    // output data of each row
                    $irow = 0;
                    $items = array();
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo '<th scope="row">' . ($irow++) + 1 . "</th>";
                      if (isset($row["image"]) && $row["image"] != null && $row["image"] != "") {
                        $img = $row["image"];
                        $imgtd = '<a class="aaa" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="previewimgm(' . "'" . $img . "'" . ')"><i data-feather="image" style="width:25px;height:25px;"></i></a>';
                      } else {
                        $imgtd = "";
                      }
                      echo "<td><div class='itemname'>" . $row["name"] . $imgtd . ' </div></td>';
                      echo "<td>" . ($row["quantity"] == -1 ? "∞" : $row["quantity"]) . "</td>";
                      // $sqlleft = 'SELECT i.id, (i.quantity - IFNULL(sum(b.quantity),0)+ IFNULL(sum(br.quantity), 0)) AS "LEFT" 
                      //       FROM items i 
                      //       left JOIN borrowdetail b 
                      //       ON i.id = b.id_items 
                      //       left JOIN borrowreturn br 
                      //       ON b.id_items = br.id_items 
                      //       where i.id ="' . $row["id"] . '"
                      //       GROUP by i.id;';
                      $sqlleft = 'SELECT i.id, (i.quantity - IFNULL(sum(b.quantity),0)) AS "LEFT" 
                            FROM items i 
                            left JOIN borrowdetail b 
                            ON i.id = b.id_items 
                            left join borrow bb
                            on b.id_borrow = bb.id
                            where i.id ="' . $row["id"] . '" and (bb.status = "active" or bb.status is null) 
                            GROUP by i.id;';
                      // echo $sqlleft;
                      $resultleft = $conn->query($sqlleft);
                      if ($resultleft->num_rows > 0) {
                        $resultleft = $resultleft->fetch_assoc();
                        echo "<td>" . ($resultleft['LEFT'] > 0 ? $resultleft['LEFT'] : ($row["quantity"] == -1 ? "∞" : $row["quantity"])) . "</td>";
                      } else {
                        echo "<td>" . ($row["quantity"] == -1 ? "∞" : $row["quantity"]) . "</td>";
                      }
                      
                      $editget = "id=" . $row["id"] . "&name=" . $row["name"] . "&quantity=" . $row["quantity"] . "&note=" . $row["note"] . "&img=" . $row["image"];
                      echo '<td class="p-1"><button style="width:40px;font-size:smaller;" type="button" class="p-0 btn btn-outline-primary btn-sm" onclick="location.href=' . "'" . "itemsedit.php?" . $editget . "'" . '" >แก้ไข</button>';
                      echo '<button type="button" style="width:40px;font-size:smaller;" data-id="' . $row["id"] . '" data-name="' . $row["name"] . '" data-bs-toggle="modal" data-bs-target="#exampleModal2" class="p-0 mt-1 btn btn-outline-danger btn-sm" onclick="delmodal(this)" >ลบ</button>' . "</td>";
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
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close imgclose" data-bs-dismiss="modal" aria-label="Close"></button>
        <img id="imgm" src='' alt="" />
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
              <form class="row g-3" action="itemsdel.php" method="post">
                <input id="itemsid" type="text" class="form-control" id="id" name="id" hidden>
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
      $("#itemsid").val($(data).data("id"));

      // console.log($("#itemsdel").attr("data-id"));
    }
    // function deli(id) {
    //   console.log($(id).data("id"));
    //   loca
    // }
    // Filter Tables
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