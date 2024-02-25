<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

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

if(isset($_POST['update_product'])){
   // Get form data
   $pid = $_POST['pid'];
   $category = $_POST['category'];
   $details = $_POST['details'];
   $height = $_POST['height'];
   $weight = $_POST['weight'];

   // Sanitize form data
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $height = filter_var($height, FILTER_SANITIZE_STRING);
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);

   // Determine size
   $size = determineSize($height, $weight);

   // Prepare and execute update query
   $update_product = $conn->prepare("UPDATE `products` SET category = ?, details = ?, height = ?, weight = ?, size = ? WHERE pid = ?");
   $update_success = $update_product->execute([$category, $details, $height, $weight, $size, $pid]);

   if($update_success) {
      $message[] = 'Product updated successfully!';
   } else {
      $message[] = 'Failed to update product. Please try again.';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Products</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="update-product">

   <h1 class="title">Update Product</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE pid = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['pid']; ?>">
      <select name="category" class="box" required>
         <option selected><?= $fetch_products['category']; ?></option>
         <option  value="" selected disabled>جۆر دیاری بکە</option>
               
               <option value="rob" style="font-family:HS alkitab">ڕۆب</option>
               <option value="caps"style="font-family:HS alkitab">کڵاو</option>
      </select>

      <input type="number" class="btn" min="0" name="height" value="<?= $fetch_products['height']; ?>" style="background-color:whitesmoke; color:black;">
      <input type="number" class="btn" min="0" name="weight" value="<?= $fetch_products['weight']; ?>" style="background-color:whitesmoke; color:black;">
      <input type="text" class="btn" name="size" value="<?= $fetch_products['size']; ?>"> 
        
      <textarea name="details" required placeholder="Enter product details" class="box" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
    
      <div class="flex-btn">
         <input type="submit" class="btn" value="Update Product" name="update_product">
         <a href="drwstkrdn.php" class="option-btn">Go Back</a>
      </div>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">No products found!</p>';
      }
   ?>

</section>

<script src="js/script.js"></script>

</body> 
</html>
