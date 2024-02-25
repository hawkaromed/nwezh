<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE cid = ?");
   $delete_cart_item->execute([$delete_id]);
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE cid = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

$select_college_query = $conn->prepare("SELECT robimage FROM college ORDER BY id DESC LIMIT 1");
    $select_college_query->execute();
    
    // Fetch the result
    $college_info = $select_college_query->fetch();


    if($college_info) {
      
      $college_robimage = $college_info['robimage'];
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="shopping-cart">

   <h1 class="title">زیادکردن</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="cart.php?delete=<?= $fetch_cart['cid']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      
    
      <table >
      <tr>
         <td>
      <img src="<?= $college_robimage; ?>"style="width:100%" alt="">
         </td>
         <td>
      <img src="capsi.png"style="width:100%" alt="">
         </td>
      </tr>
     </table>    
    
   
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_cart['details']; ?></div>
      
      <br><br>

      <div style="font-family:HS alkitab;font-size:20px"> درێژی  </div>

      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_cart['height']; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px"> پانی  </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_cart['weight']; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px">  قیاسەکەی </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_cart['size']; ?></div>
      <br><br>

      
     
   </form>
   <?php
    
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p> <span></span></p>
      <a href="shop.php" class="option-btn">بەردەوام بە</a>
      
      <a href="checkout.php" class="btn">ئۆردەری بکە</a>
   </div>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>