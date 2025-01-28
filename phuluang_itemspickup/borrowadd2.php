<?php
require 'connectmysql.php';
require 'sessionlogin.php';
$_SESSION['items'] = [];
if (isset($_POST['items']) && $_POST['items']) {
  $_SESSION['items'][] = $_POST['items'];
}else{
  header("location: /phuluang_itemspickup/borrowadd.php");
}
// foreach ($_POST as $key => $value) {
//   // echo''. $key .''. $value .'';
//   foreach ($value as $key2 => $value2) {
//     echo '' . ' ' . $value2 . '//';
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
                <form class="row g-3" action="borrowaddserv.php" method="post" enctype="multipart/form-data">
                  <div class="col-12">
                    <label for="date" class="form-label">วันที่ยืม</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php $date = date('Y-m-d', time());
                                                                                          echo $date ?>">
                  </div>
                  <div class="col-12">
                    <label for="date_due" class="form-label">วันที่คืน</label>
                    <input type="date" class="form-control" id="date_due" name="date_due" value="<?php $date = date('Y-m-d', time());
                                                                                                  echo $date ?>">
                  </div>
                  <div class="col-12">
                    <label for="name" class="form-label">ชื่อผู้ยืม</label>
                    <input type="text" class="form-control" id="name" name="name">
                  </div>
                  <div class="col-12">
                    <label for="activework" class="form-label">งานที่ใช้</label>
                    <input type="text" class="form-control" id="activework" name="activework">
                  </div>
                  <div class="col-12">
                    <label for="note" class="form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" id="note" name="note" placeholder="">
                  </div>
                  <div class="col-12">
                    <table class="table caption-top table-striped">
                      <caption>รายการสิ่งของ<input class="form-control m-2" id="myInput" type="text" placeholder="ค้นหา.."></caption>
                      <thead>
                        <tr class="text-center text-nowrap">
                          <!-- <th scope="col" style="width: 1%;">#</th> -->
                          <th scope="col">รายการ</th>
                          <th scope="col" style="width: 1%;">เหลือ</th>
                          <th scope="col" style="width: 10%;">จำนวน</th>
                          <th scope="col" style="width: 1%;"></th>
                        </tr>
                      </thead>

                      <tbody id="myTable">
                        <?php
                        $where = "";

                        if (isset($_POST['items'])) {
                          foreach ($_POST['items'] as $key2 => $value2) {
                            $where .= "'$value2',";
                            // echo ($key2 . "/ " . $value2 . "||");
                          }
                          $where = substr($where, 0, strlen($where) - 1);
                        } else {
                          $where = "''";
                        }
                        $sql = "SELECT * FROM items where id in ($where)";
                        // echo $sql;
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          $irow = 0;
                          $items = array();
                          while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo '<td hidden><input id="" type="text" value="' . $row["id"] . '"></td>';
                            // echo '<th scope="row">' . ($irow++) + 1 . "</th>";
                            if (isset($row["image"]) && $row["image"] != null && $row["image"] != "") {
                              $img = $row["image"];
                              $imgtd = '<a class="aaa" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="previewimgm(' . "'" . $img . "'" . ')"><i data-feather="image" style="width:25px;height:25px;"></i></a>';
                            } else {
                              $imgtd = "";
                            }
                            echo "<td><div class='itemname'>" . $row["name"] . $imgtd . ' </div></td>';
                            $sqlleft = 'SELECT i.id, (i.quantity - IFNULL(sum(b.quantity),0)+ IFNULL(sum(br.quantity), 0)) AS "LEFT" 
                            FROM items i 
                            left JOIN borrowdetail b 
                            ON i.id = b.id_items 
                            left JOIN borrowreturn br 
                            ON b.id_items = br.id_items 
                            where i.id ="' . $row["id"] . '"
                            GROUP by i.id;';
                            $resultleft = $conn->query($sqlleft);
                            $resultleft = $resultleft->fetch_assoc();
                            // echo $resultleft['LEFT'];
                            echo "<td>" . ($resultleft['LEFT'] > 0 ? $resultleft['LEFT'] : "∞") . "</td>";
                            echo '<td><input class="form-control form-control-sm" type="number" name="items[' . $row["id"] . ']" id="' . $row["id"] . '" value="' . ($resultleft['LEFT'] > -1 ? "1" : "1") . '" min="0" max="' . ($resultleft['LEFT'] < 0 ? "" : $resultleft['LEFT']) . '"></td>';
                            echo '<td><a class="text-danger" id="itemdel" data-itemid="' . $row["id"] . '"><i data-feather="x-circle" style="width:25px;height:25px;"></i></a></td>';
                            echo "</tr>";
                          }
                        } else {
                          // echo "0 results";
                        }
                        ?>
                      </tbody>

                    </table>
                  </div>
                  <div class="col-12 text-center pt-3">
                    <button type="submit" class="btn btn-success w-25">ยืนยัน</button>
                    <button type="button" class="btn btn-warning w-25" onclick="location.href='borrowadd.php'">ย้อนกลับ</button>
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

    $("#myTable").on("click", "#itemdel", function() {
      // console.log($(this).attr("data-itemid"));
      $.post("borrowitemssession.php", {
        items: $(this).attr("data-itemid")
      }, function(data) {
        // console.log(data);
        // alert("success");
      });
      $(this).closest("tr").remove();


    });

    $('input[type="number"]').on('change input keyup paste', function() {
      if (this.max) this.value = Math.min(parseInt(this.max), parseInt(this.value) || 1);
      if(this.value == ""){ this.value = 1;}
    });

    $(function() {

var thaiYear = function(ct) {
  var leap = 3;
  var dayWeek = ["พฤ.", "ศ.", "ส.", "อา.", "จ.", "อ.", "พ."];
  if (ct) {
    var yearL = new Date(ct).getFullYear() - 543;
    leap = (((yearL % 4 == 0) && (yearL % 100 != 0)) || (yearL % 400 == 0)) ? 2 : 3;
    if (leap == 2) {
      dayWeek = ["ศ.", "ส.", "อา.", "จ.", "อ.", "พ.", "พฤ."];
    }
  }
  this.setOptions({
    i18n: {
      th: {
        dayOfWeek: dayWeek
      }
    },
    dayOfWeekStart: leap,
  })
};

$("#date").datetimepicker({
  timepicker: false,
  format: 'd-m-Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
  lang: 'th', // แสดงภาษาไทย
  onChangeMonth: thaiYear,
  onShow: thaiYear,
  yearOffset: 543, // ใช้ปี พ.ศ. บวก 543 เพิ่มเข้าไปในปี ค.ศ
  closeOnDateSelect: true,
});



});
  </script>
</body>

</html>