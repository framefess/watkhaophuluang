<?php
require 'connectmysql.php';
require 'sessionlogin.php';
$_GET['id'];
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
    tbody>tr>td:nth-child(n+3):not(:last-child) {
      text-align: center;
    }

    @media only screen and (max-width: 768px) {
      #previewimg {
        max-width: 75%;
        max-height: 200px;
      }
    }

    @media only screen and (min-width: 769px) {
      #previewimg {
        max-width: 30%;
        max-height: 300px;
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
              <div class="col text-center display-1 fw-bold">แก้ไขรายการสิ่งของ</div>
            </div>
            <div class="row">
              <div class="col p-5">
                <form class="row g-3" action="itemseditserv.php" method="post" enctype="multipart/form-data">
                  <div class="col-12">
                    <input type="text" class="form-control" id="id" name="id" value="<?php if (isset($_GET['id'])) {
                      echo $_GET['id'];
                    } ?>" hidden>
                    <label for="name" class="form-label">ชื่อสิ่งของ</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php if (isset($_GET['name'])) {
                      echo $_GET['name'];
                    } ?>">
                  </div>
                  <div class="col-12">
                    <label for="quantity" class="form-label">จำนวน</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="-1" value="<?php if (isset($_GET['quantity'])) {
                      echo $_GET['quantity'];
                    } ?>">
                  </div>
                  <div class="col-12">
                    <label for="note" class="form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" id="note" name="note" placeholder="" value="<?php if (isset($_GET['note'])) {
                      echo $_GET['note'];
                    } ?>">
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="fileimg" class="form-label">รูป</label>
                      <input class="form-control" type="file" id="fileimg" name="fileimg" accept="image/*">

                      <div class="text-center p-3">
                        <img id="previewimg" src="<?php if (isset($_GET['img'])) {
                          echo $_GET['img'];
                        } ?>" class="rounded">
                      </div>
                    </div>
                  </div>
                  <div class="col-12 text-center pt-3">
                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" onclick="location.href='items.php'">ยกเลิก</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
  <?php
  include "sfooter.php";
  ?>

  <script>
    fileimg.onchange = evt => {
      const [file] = fileimg.files

      if (file) {
        previewimg.src = URL.createObjectURL(file)
      }
    }
  </script>
</body>

</html>