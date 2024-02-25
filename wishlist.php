<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};



if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE wid = ?");
   $delete_wishlist_item->execute([$delete_id]);
   header('location:wishlist.php');

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
   <title>wishlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="wishlist">

   <h1 style="font-family: HS alkitab;" class="title">بەدڵبوونەکان</h1>

   <div class="box-container">

   <?php
      
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="wishlist.php?delete=<?= $fetch_wishlist['wid']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
      


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
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_wishlist['details']; ?></div>
      
      <br><br>

      <div style="font-family:HS alkitab;font-size:20px"> درێژی  </div>

      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_wishlist['height']; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px"> پانی  </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_wishlist['weight']; ?></div>
      <br><br>
      <div style="font-family:HS alkitab;font-size:20px">  قیاسەکەی </div>
      <div style="font-family:HS alkitab;font-size:20px"><?= $fetch_wishlist['size']; ?></div>
      <br><br>

      
     
   </form>
   <?php
    
      }
   }else{
      echo '<p style="font-family: HS alkitab;" class="empty">!هیچت دیاری نەکردووە </p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      
      <a style="font-family: HS alkitab;" href="shop.php" class="option-btn">بەردەوام بە</a>
     
   </div>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>