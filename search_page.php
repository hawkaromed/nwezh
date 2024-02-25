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

  
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

  

      
      $insert_cart = $conn->prepare("INSERT INTO `wishlist`(id, pid,height,weight,details,category) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $height, $weight,$details,$category]);
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
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="search-form">

   <form action="" method="POST">
      <input type="text" class="box" name="search_box" placeholder="search products...">
      <input type="submit" name="search_btn" value="search" class="btn">
   </form>

</section>

<?php



?>

<section class="products" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
      if(isset($_POST['search_btn'])){
      $search_box = $_POST['search_box'];
      $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
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
         
     
        
      }else{
         echo '<p class="empty">no result found!</p>';
      }
      
   };
   ?>

   </div>

</section>






<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>