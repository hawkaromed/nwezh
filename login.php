<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:swperAdmin/admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_id'] = $row['id'];
         header('location:bashakan.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css?v=1.0">

</head>
<body style=" background-image:url('college.jpg');">


   <section  class="form-container">

<form style="box-shadow: 0px 0px 20px 0px white; border:0px"   action="" method="POST">
   <h3>چونە ژوورەوە</h3>
   <input type="email" name="email" class="box" placeholder="ئیمەیڵەکەت بنووسە" required>
   <input type="password" name="pass" class="box" placeholder="وشەی نهێنی بنووسە" required>
   <input type="submit" value="چونە ژوورەوە" class="btn" name="submit">
         <p> ئەگەر خۆت تۆمار نەکردووە ئەمە داگرە <br><a href="register.php"style="color:orange">register now</a> </p>

<p> ئەگەر خوێندکار نیت ئەمە داگرە <br><a href="guest/index.php" style="color:red">Guest</a> </p>

</form>

</section>
</body>
</html>










