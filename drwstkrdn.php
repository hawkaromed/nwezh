<?php


@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
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

if(isset($_POST['add_product'])){

   
  
   
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);


   $height = $_POST['height'];
   $height = filter_var($height, FILTER_SANITIZE_STRING);

   $weight = $_POST['weight'];
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);
   $size = determineSize($height, $weight); // Determine size based on height and weight

 
   
  



 // Check if a similar product already exists
 $select_products = $conn->prepare("SELECT * FROM products WHERE category = ? AND details = ? AND id = ?");
 $select_products->execute([$category, $details, $user_id]);

 if ($select_products->rowCount() > 0) {
     $message[] = 'Product already exists!';
 } else {
     // Insert new product
     $insert_products = $conn->prepare("INSERT INTO products(category, details, height, weight, size, id) VALUES(?,?,?,?,?,?)");
     $insert_products->execute([$category, $details, $height, $weight, $size, $user_id]);
 }
}


if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   
  
  
   $delete_products = $conn->prepare("DELETE FROM products WHERE pid = ?");
   $delete_products->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM wishlist WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM cart WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   


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
<html style="font-family:HS alkitab" lang="en">
<head>
   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>create</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
   
<?php include 'header.php'; ?>


<section class="add-products">

   <h1 class="title" style="font-family:HS alkitab">دروستکردنی ڕۆب و کڵاو</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div>
        


         

        
        
         </div>
         <select name="category" class="box" required style="font-family:HS alkitab;width:100%">
            <option  value="" selected disabled>جۆر دیاری بکە</option>
               
               <option value="rob" style="font-family:HS alkitab">ڕۆب</option>
               <option value="caps"style="font-family:HS alkitab">کڵاو</option>
            
               
             
         </select>

        
         <input type="number" class="btn"  min="0"  name="height" placeholder="درێژی" style="background-color:whitesmoke ; color:black; font-family:HS alkitab">
         <input type="number" class="btn" min="0"  name="weight" placeholder="کێش" style="background-color:whitesmoke ; color:black; font-family:HS alkitab">
        <input type="text" class="sizes" name="size"> 
         <div class="inputBox">
         
         
       </div>
      </div>
      <textarea style="font-family:HS alkitab" name="details" class="box" required placeholder="تێبینی  " cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="زیادکردن" name="add_product" style="font-family:HS alkitab">
   </form>

</section>

<section class="show-products">

   <h1 class="title" style="font-family:HS alkitab">زیادکراوەکان</h1>

   <div class="box-container">

   <?php
    $show_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $show_products->execute([$user_id]);
  
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">  
   <table >
      <tr>
         <td>
      <img src="<?= $college_robimage; ?>"style="width:100%" alt="">
         </td>
         <td>
      <img src="capsi.png"style="width:100%" alt="">
         </td>
      </tr>
     </table>                                                                                                                                                                          <div><h5 style="font-family:HS alkitab;font-size:20px"> تێبینی </h5></div> 
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_products['details']; ?></div>
      
      <br><br>

      <div style="font-family:HS alkitab;font-size:20px"> درێژی  </div>

      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_products['height']; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px"> پانی  </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_products['weight']; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px">  قیاسەکەی </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_products['size']; ?></div>
      <br><br>

      <div class="sizes" style="font-family:HS alkitab;font-size:20px">
    
      </div>


      
      
      <div class="flex-btn">
         <a href="update.php?update=<?= $fetch_products['pid']; ?>" class="option-btn">update</a>
         <a href="drwstkrdn.php?delete=<?= $fetch_products['pid']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">!هیچ شتێکت زیاد نەکردووە</p>';
   }
   ?>

   </div>

</section>











<script src="js/script.js"></script>

</body>
</html>
