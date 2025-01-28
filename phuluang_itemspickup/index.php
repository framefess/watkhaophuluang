<?php
require 'connectmysql.php';
if (isset($_SESSION["id"])) {
  header("location: /phuluang_itemspickup/items.php");
  exit(0);
}
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
      /* font-size: large; */
      /* display: flex; */
      font-weight: 600;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      min-height: 100vh;
    }
    input{
      font-size: 1.3em;
    }
    /* body {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* div.login>div.mdl-card__title {
      background: rgb(224, 64, 251);
      /* color: rgb(255,193,7); 
    } */
    .hbanner {
      color: yellow;
      background-color: blue;
      height: 150px;
      display: inline-flex;
      justify-content: center;
      flex-direction: row;
      align-items: center;
      flex-wrap: nowrap;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <form action="login.php" method="post">

      <div class="row justify-content-center">
        <div class=" col-md-6 col-sm-12">
          <div class="row justify-content-center text-center">
            <div class="col hbanner display-1">
              วัดเขาภูหลวง
            </div>
          </div>
          <div class="p-3">
            <div class="mb-3 row">
              <label for="name" class="col-4 col-form-label">ชื่อผู้ใช้</label>
              <div class="col-8">
                <input type="text" readonly class="form-control-plaintext" id="name" name="name" value="phuluang">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="password" class="col-4 col-form-label">รหัสผ่าน</label>
              <div class="col-8">
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </div>
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'fail') {
              echo '
          <span class="mdl-chip" style="background-color: red;color:aliceblue ">
            <span class="mdl-chip__text">ชื่อผู้ใช้หรือรหัสผ่านผิด</span>
          </span>
          ';
            }
            ?>
            <div class="col text-center">
              <button type="submit" class="btn btn-primary mb-3">เข้าสู่ระบบ</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>


  <?php
  include "sfooter.php";
  ?>
</body>

</html>