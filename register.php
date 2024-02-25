<?php
// register.php

include 'config.php';

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']); // Hash and salt the password
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']); // Hash and salt the confirm password
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   
   // File upload handling
   $image = $_FILES['image']['name'];
   $image_tmp = $_FILES['image']['tmp_name'];
   $image_folder = 'swperAdmin/uploaded_img/'.$image;
   move_uploaded_file($image_tmp, $image_folder); // Move the uploaded file to a specified directory

   // Validate input data
   if(empty($name) || empty($email) || empty($_POST['pass']) || empty($_POST['cpass']) || empty($image)){
      $message[] = "All fields are required";
   } elseif($pass != $cpass){
      $message[] = "Password and Confirm Password do not match";
   } else {
      // Check if email already exists in the database
      $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $select->execute([$email]);

      if($select->rowCount() > 0){
         $message[] = "Email already exists";
      } else {
         // Insert user into the database
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            $message[] = "User registered successfully";
            header('location:login.php');
            // Optionally, you can redirect the user to the login page after successful registration
            // header('location:login.php');
         } else {
            $message[] = "Registration failed";

         }
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body  style=" background-image:url('college.jpg');">

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
   
<section class="form-container">

   <form style="box-shadow: 0px 0px 20px 0px white; border:0px" action="" enctype="multipart/form-data" method="POST">
      <h3>خۆت تۆمار بکە</h3>
      <input type="text" name="name" class="box" placeholder="ناوت بنووسە" required>
      <input type="email" name="email" class="box" placeholder="ئیمەیڵەکەت بنووسە" required>
      <input type="password" name="pass" class="box" placeholder="وشەی نهێنی بنووسە" required>
      <input type="password" name="cpass" class="box" placeholder="دلنیابونەوە لە وشەی نهێنی" required>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png,image/avif">
      <input type="submit" value="خۆتۆمارکردن" class="btn" name="submit">
           
<p>ئەگەر خۆت تۆمار کردووە ئەمە داگرە <br><a href="login.php">login now</a></p>

 <p> ئەگەر خوێندکار نیت ئەمە داگرە <br><a href="guest/index.php" style="color:red">Guest</a> </p>
  
   </form>

</section>


</body>
</html>



