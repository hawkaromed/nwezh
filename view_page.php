<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);

   $height = $_POST['height'];
   $height = filter_var($height, FILTER_SANITIZE_STRING);

   $weight = $_POST['weight'];
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);
   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
   $check_cart_numbers->execute([ $user_id]);

   $color = $_POST['color'];
   $color = filter_var($color, FILTER_SANITIZE_STRING);

   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

  

      
      $insert_cart = $conn->prepare("INSERT INTO `wishlist`(user_id, pid,height,weight,color,details,category) VALUES(?,?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $height, $weight, $color,$details,$category]);
      $message[] = 'added to wishlist';
   
}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);

   $height = $_POST['height'];
   $height = filter_var($height, FILTER_SANITIZE_STRING);

   $weight = $_POST['weight'];
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);
   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
   $check_cart_numbers->execute([ $user_id]);

 

   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   

      

      $insert_cart = $conn->prepare("INSERT INTO `cart`(id, pid,height,weight,details,category) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $height, $weight,$details,$category]);
      $message[] = 'added to cart!';
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="quick-view">

   <h1 class="title">quick view</h1>

   <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
    <form action="" class="box" method="POST">
      <div class="price"><span style="font-family:HS alkitab;font-size:18px">٥٠,٠٠٠ دینار</span></div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" ></a>
      <img src="images/gownss.jpg"style="width:70%" alt="">
     
 

      <div><h5 style="font-family:HS alkitab;font-size:20px"> تێبینی </h5></div> 
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_products['details']; ?></div>
      
      <br><br>
      <div class="sizes" style="font-family:HS alkitab;font-size:20px">
     <?php
       $height2= $fetch_products['height'];
       $weight2= $fetch_products['weight'];

        $arra = ["S", "M", "L","XL"];
        $basic2=$fetch_products['basic'];
        echo "<div><h5 style='font-family:HS alkitab;font-size:20px'> قەبارەکەی</h5> </div> ";
        if (($height2 >= 1 && $height2 <= 10  && $weight2 >=1 && $weight2 <=10)) {
           echo $arra[0];}
           elseif (($height2 >= 10 && $height2 <= 30  && $weight2 >=10 && $weight2 <=30)) {
            echo $arra[1];
           
          
        }

        elseif (($height2 >= 30 && $height2 <= 50  && $weight2 >=30 && $weight2 <=50)) {
         echo $arra[2];
        
       
     }
     else{

      echo $height2 ."    and     ". $weight2. "    error size";
     }

    
   
   
   ?> </div>

<input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">

<input type="hidden" name="height" value="<?= $fetch_products['height']; ?>">
      <input type="hidden" name="weight" value="<?= $fetch_products['weight']; ?>">
    
      <input type="hidden" name="details" value="<?= $fetch_products['details']; ?>">
      <input type="hidden" name="category" value="<?= $fetch_products['category']; ?>">

     
      
      
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>