<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['flat'].' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
   $cart_query->execute([$user_id]);
   



   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ?");
   $order_query->execute([$name, $number, $email, $method, $address]);

   
      $insert_order = $conn->prepare("INSERT INTO `orders`(id, name, number, email, method, address,placed_on) VALUES(?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address,$placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'order placed successfully!';
      header('location:ordertruck.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

  
   <p style="font-family:HSalkitab; font-size:30px; font-weight:bold;"> ( <?= $fetch_profile['name']; ?> ) : ناو    </p>
   <?php
    
 
   ?>
   
</section>

<style>

span{
   font-family:HSalkitab; 
   font-size:30px; 
   font-weight:bold;
}
.btn{
   font-family:HSalkitab; 
   font-size:30px; 
   font-weight:bold;
}


.box{
   font-family:HSalkitab; 
   font-size:30px; 
   font-weight:bold;
}
   </style>
<section class="checkout-orders">

   <form action="" method="POST">

      <h3 style="font-family:HSalkitab; font-size:30px; font-weight:bold;">زانیارییەکان داغڵبکە</h3>

      <div class="flex">
         <div class="inputBox">
            <span > ناو :</span>
            <input type="text" name="name" placeholder="ناوت بنوسە " class="box" required>
         </div>
         <div class="inputBox">
            <span>ژمارەتەلەفۆن :</span>
            <input type="number" name="number" placeholder="ژمارەکەت داغڵ بکە" class="box" required>
         </div>
         <div class="inputBox">
            <span>ئیمەیڵ :</span>
            <input type="email" name="email" placeholder="ئیمەیڵەکەت بنوسە" class="box" required>
         </div>
         <div class="inputBox">
            <span>ناردنی پارە :</span>
            <select name="method" class="box" required>
               <option value="taxi">کاش و تەکسی </option>
               <option value="card">کارد</option>
               <option value="paytem">پایتم</option>
               <option value="pybal">پایباڵ</option>
            </select>
         </div>
         <div class="inputBox">
            <span>ناونیشانی ١ :</span>
            <input type="text" name="flat" placeholder=" نمونە سلێمانی-گەڕەکی عەلی کەمال" class="box" required>
         </div>
        
         
         
         <div class="inputBox">
            <span>کۆد :</span>
            <input type="number" min="0" name="pin_code" placeholder="نمونە ١٢٣٤٥" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn" id="order" value="ئۆردەربکە">

   </form>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>