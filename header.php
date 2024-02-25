<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<html>
   <head><script src="js-hawa/logo.js"></script>
   <script src="js-hawa/jetanim.js"></script>

</head>
<body>
<header class="header">

<style>
.drop {
    position: relative;
    width: 350px;
    height: 350px;
    box-shadow: inset 20px 20px 20px rgba(0, 0, 0, 0.05),
        25px 35px 20px rgba(0, 0, 0, 0.05),
        25px 30px 30px rgba(0, 0, 0, 0.05),
        inset -20px -20px 25px rgba(255, 255, 255, 0.9);
    transition: 0.5s;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
}
 a{
   font-family: HS alkitab;
   font-weight: bold;
}


.scroller {
  height: 300px;
  overflow-y: scroll;
  scroll-snap-type: y mandatory;
  color: black;
  
}


</style>
   <div class="flex">

      <a href="home.php"  class="logo"><img style=" width: 90px;
    height: 90px;" class="drop" id="logo" src="images/caps.avif" style="width:90px"></a>

      <nav class="navbar">
         <a href="home.php">سەرەتا</a>
         <a href="shop.php">داواکراوەکان</a>
         <a href="orders.php">وەرگیراوەکان</a>
         <a href="drwstkrdn.php"> دروستکردن
         </a>
      </nav>

      <div class="icons">
     
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>

         <a href="search_page.php" class="fas fa-search"></a>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
            $count_cart_items->execute([$user_id]);
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ?");
            $count_wishlist_items->execute([$user_id]);
         ?>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
        
         <a href="logout.php" >
         <div id="user-btn" class="fas fa-sign-out"></div>
         </a>
      </div>

      <div class="profile">
      <article class="scroller" >
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img id="mylogo" src="swperAdmin/uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['name']; ?></p>
         <a href="user_profile_update.php" class="btn"  >گۆڕینی پڕۆفایل</a>
         <a href="logout.php" class="delete-btn">چونەدەرەوە</a>
         </article>
      </div>

   </div>

</header>

</body>
</html>