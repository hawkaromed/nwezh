<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_products_item = $conn->prepare("DELETE FROM `products` WHERE pid = ?");
   $delete_products_item->execute([$delete_id]);
   header('location:category.php?category=rob');
}

elseif(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_products_item = $conn->prepare("DELETE FROM `products` WHERE pid = ?");
   $delete_products_item->execute([$delete_id]);
   header('location:category.php?category=caps');
}



function determineSize($height, $weight) {
   if ($height <= 10 && $weight <= 10) {
       return 'XS'; // Extra Small
   } elseif ($height > 10 && $height <= 30 && $weight > 10 && $weight <= 30) {
       return 'S'; // Small
   } elseif ($height > 30 && $height <= 50 && $weight > 30 && $weight <= 50) {
       return 'M'; // Medium
   } elseif ($height > 50 && $weight > 50) {
       return 'L'; // Large
   } else {
       return 'Undefined'; // Undefined Size
   }
}

if (isset($_POST['add_to_wishlist'])) {

   $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);

   $height = isset($_POST['height']) ? $_POST['height'] : '';
   $height = filter_var($height, FILTER_SANITIZE_STRING);

   $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);

   $details = isset($_POST['details']) ? $_POST['details'] : '';
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $category = isset($_POST['category']) ? $_POST['category'] : '';
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   if (!empty($pid) && !empty($height) && !empty($weight) && !empty($details) && !empty($category)) {
      $size = determineSize($height, $weight);
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, pid,height,weight,details,category,size) VALUES(?,?,?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $height, $weight, $details, $category, $size]);
      $message[] = 'Added to wishlist';
   } else {
      $message[] = 'Error: Missing required data';
   }
}

if (isset($_POST['add_to_cart'])) {

   $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);

   $height = isset($_POST['height']) ? $_POST['height'] : '';
   $height = filter_var($height, FILTER_SANITIZE_STRING);

   $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);

   $details = isset($_POST['details']) ? $_POST['details'] : '';
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $category = isset($_POST['category']) ? $_POST['category'] : '';
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   if (!empty($pid) && !empty($height) && !empty($weight) && !empty($details) && !empty($category)) {
      $size = determineSize($height, $weight);
      $insert_cart = $conn->prepare("INSERT INTO `cart`(id, pid,height,weight,details,category,size) VALUES(?,?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $height, $weight, $details, $category, $size]);
      $message[] = 'Added to cart';
   } else {
      $message[] = 'Error: Missing required data';
   }
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
   <title>ڕۆب و کڵاوەکان</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style1.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="products">

   <h1 class="title">ڕۆب و کڵاوەکان</h1>

   <div class="box-container">

   <?php
      $category_name = isset($_GET['category']) ? $_GET['category'] : '';
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ? AND id = ?");
      $select_products->execute([$category_name, $user_id]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
   ?>

   <form action="" class="box" method="POST">
   
      <div class="price"><a  href="category.php?delete=<?= $fetch_products['pid']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a></div>
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

      
                                                                                                                                                                                       <div><h5 style="font-family:HS alkitab;font-size:20px"> تێبینی </h5></div> 
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_products['details']; ?></div>
      
      <br><br>

      <div style="font-family:HS alkitab;font-size:20px"> درێژی  </div>

      <div style="font-family:HS alkitab;font-size:20px"><?= isset($fetch_products['height']) ? $fetch_products['height'] : ''; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px"> پانی  </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= isset($fetch_products['weight']) ? $fetch_products['weight'] : ''; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px">  قیاسەکەی </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= isset($fetch_products['size']) ? $fetch_products['size'] : ''; ?></div>
      <br><br>

      


     
      
      
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="height" value="<?= isset($fetch_products['height']) ? $fetch_products['height'] : ''; ?>">
      <input type="hidden" name="weight" value="<?= isset($fetch_products['weight']) ? $fetch_products['weight'] : ''; ?>">
      <input type="hidden" name="details" value="<?= isset($fetch_products['details']) ? $fetch_products['details'] : ''; ?>">
      <input type="hidden" name="category" value="<?= isset($fetch_products['category']) ? $fetch_products['category'] : ''; ?>">
   </form>
   <?php
         }
         
      } else {
         echo '<p class="empty">No products available!</p>';
      }
   ?>

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
