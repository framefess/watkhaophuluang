<?php
require 'connectmysql.php';
require 'sessionlogin.php';
header("location: /phuluang_itemspickup/items.php");
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

    main {
      height: 100vh;
      height: -webkit-fill-available;
      max-height: 100vh;
      overflow-x: auto;
      overflow-y: hidden;
    }

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
  </style>
</head>

<body>
  <div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
      <?php include 'sidebar.php' ?>
      <div class="col d-flex flex-column h-100">
        <main class="row">
          <div class="col pt-4">
            <h3>Vertical Sidebar that switches to Horizontal Navbar</h3>
            <p class="lead">An example multi-level sidebar with collasible menu items. The menu functions like an
              "accordion" where only a single menu is be open at a time.</p>
            <hr />
            <h3>More content...</h3>
            <p>Sriracha biodiesel taxidermy organic post-ironic, Intelligentsia salvia mustache 90's code editing
              brunch. Butcher polaroid VHS art party, hashtag Brooklyn deep v PBR narwhal sustainable mixtape swag wolf
              squid tote bag. Tote bag cronut semiotics, raw denim deep v taxidermy messenger bag. Tofu YOLO Etsy,
              direct trade ethical Odd Future jean shorts paleo. Forage Shoreditch tousled aesthetic irony, street art
              organic Bushwick artisan cliche semiotics ugh synth chillwave meditation. Shabby chic lomo plaid vinyl
              chambray Vice. Vice sustainable cardigan, Williamsburg master cleanse hella DIY 90's blog.</p>
            <p>Ethical Kickstarter PBR asymmetrical lo-fi. Dreamcatcher street art Carles, stumptown gluten-free
              Kickstarter artisan Wes Anderson wolf pug. Godard sustainable you probably haven't heard of them, vegan
              farm-to-table Williamsburg slow-carb readymade disrupt deep v. Meggings seitan Wes Anderson semiotics,
              cliche American Apparel whatever. Helvetica cray plaid, vegan brunch Banksy leggings +1 direct trade.
              Wayfarers codeply PBR selfies. Banh mi McSweeney's Shoreditch selfies, forage fingerstache food truck
              occupy YOLO Pitchfork fixie iPhone fanny pack art party Portland.</p>
          </div>
        </main>
        <!-- <footer class="row bg-light py-4 mt-auto">
                <div class="col"> Bottom footer content here... </div>
            </footer> -->
      </div>
    </div>
  </div>

  <?php
  include "sfooter.php";
  ?>
</body>

</html>