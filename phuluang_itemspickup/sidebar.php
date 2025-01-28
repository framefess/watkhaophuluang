<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[2];
$activePage = basename($_SERVER['PHP_SELF'], ".php");
// echo$activePage;
?>
<style>
  .sidebar {
    transition: all 0.5s linear;
  }
  .sidebar ul {
    width: 100%;
  }
  .sidebar li{
    width: 100%;
    padding: .6rem;
    margin: 5px 0;
    border-radius: 8px;
    transition: all 0.5s ease-in-out;
  }
  .sidebar li:hover
  ,.active{
    background-color: yellow;
    color: blueviolet;
    
  }
  .sidebar a:last-child
  {
    width: 100%;
    padding: .1rem ;
    margin: 5px 0;
    border-radius: 8px;
    transition: all 0.5 ease-in-out;
  }
</style>
<div class="col-12 col-sm-3 col-xl-auto px-sm-2 px-0 bg-dark d-flex sticky-top sidebar">
  <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
    <a href="items.php" class="d-flex align-items-center p-2 pb-sm-1 mb-md-0 me-md-auto text-white text-decoration-none" style="width:100%;justify-content: center;
    align-content: center;">
      <span style="font-size: 1rem;">วัดเขาภูหลวง</span>
    </a>
    <ul
      class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start"
      id="menu">
      <!-- <li class="nav-item 
      <?php 
      // if ($activePage == "dashboard") {
      //   echo "active";
      // } 
      ?>">
        <a href="dashboard.php" class="nav-link px-sm-0 px-1">
          <i data-feather="pie-chart"></i>
          <span class="ms-1 d-none d-sm-inline">รายงาน</span>
        </a>
      </li> -->
      <li class="nav-item <?php if ($activePage == "items") {
        echo "active";
      } ?>">
        <a href="items.php" class="nav-link px-sm-0 px-1">
          <i data-feather="box"></i>
          <span class="ms-1 d-none d-sm-inline">สิ่งของ</span>
        </a>
      </li>
      <li class="nav-item <?php if ($activePage == "borrow") {
        echo "active";
      } ?>">
        <a href="borrow.php" class="nav-link px-sm-0 px-1">
          <i data-feather="external-link"></i>
          <span class="ms-1 d-none d-sm-inline">ยืม</span>
        </a>
      </li>
      <li class="nav-item <?php if ($activePage == "itemsreturn") {
        echo "active";
      } ?>">
        <a href="itemsreturn.php" class="nav-link px-sm-0 px-1">
          <i data-feather="check-circle"></i>
          <span class="ms-1 d-none d-sm-inline">คืน</span>
        </a>
      </li>
    </ul>
    <div class=" py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
      <a href="logout.php" class="d-flex align-items-center text-white text-decoration-none px-sm-0 px-1">
        <i data-feather="log-out" style="color:red"></i>
        <span class="d-none d-sm-inline mx-1">ออกจากระบบ</span>
      </a>
    </div>
  </div>
</div>