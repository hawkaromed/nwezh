<?php
session_start();
@include 'config.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit(); // Ensure that the script stops executing after redirection.
}

// Fetch the selected college and its color from the database
try {
    // Prepare and execute a query to fetch the selected college and its color
    $select_college_query = $conn->prepare("SELECT name, color,image,details,robimage,bgcolors FROM college ORDER BY id DESC LIMIT 1");
    $select_college_query->execute();
    
    // Fetch the result
    $college_info = $select_college_query->fetch();
    
    if($college_info) {
        $college_name = $college_info['name'];
        $college_color = $college_info['color'];
        $college_Images = $college_info['image'];
        $college_details = $college_info['details'];
        $college_robimage = $college_info['robimage'];
        $college_bcolors = $college_info['bgcolors'];

    } else {
        // Default values if no college is selected
        $college_name = "No College Selected";
        $college_color = "white";
        $college_Images="college.jpg";
        $college_details="";
        $college_robimage="";
        $college_bcolors="";
    }
} catch (PDOException $e) {
    // Handle database errors
    $college_name = "Error: " . $e->getMessage();
    $college_color = "white"; // Default color
    $college_Images="college.jpg";
    $college_details="";
    $college_robimage="";
    $college_bcolors="";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8mb4_general_ci">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style1.css">

    <style>
        * {
            font-family: HS alkitab;
        }

        .drop {
            position: relative;
            width: 350px;
            height: 350px;
            box-shadow: inset 20px 20px 20px rgba(0, 0, 0, 0.05),
                25px 35px 20px rgba(0, 0, 0, 0.05),
                25px 30px 30px rgba(0, 0, 0, 0.05),
                inset -20px -20px 25px rgba(255, 255, 255, 0.9);
            transition: 0.5s;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .home-bg {
            background: url(college.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            transition: background-image 1s ease-in-out;
        }
        .bash{
   text-align: center;
  
   text-transform: uppercase;
   color:var(--black);
   font-size: 3.5rem;
   padding-top: 30px;
   padding-bottom: 30px;
   color: white;
}

.category{
   text-align: center;
   margin-bottom: 2rem;
   text-transform: uppercase;
   color:var(--black);
   font-size: 3rem;
   line-height: 0.8cm;
}




.card {
 
  width: 100%;
  height: 100%;
  border-radius: 10px;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.5);
  
  padding: 30px 50px;
  background: #fff;
  margin: auto;
}



.imgbox {
  
  width: 50%;
  height: 50%;
  transform: translateY(-80px);
  margin: auto;
 
}

img {
  width: 80%;
  border-radius: 10px;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.5);
  margin: auto;
}

.content {
 
  text-align: center;
  
  
}



.content h2 {
  color: #7f9ead;
}

.details {
    text-align: center;
    margin-bottom: 3rem;
   
    color: var(--black);
    font-size: 2rem;
    line-height: 0.8cm;
}

.block {
    position: relative;
   
  
  }
  
  .block:before, .block:after {
    content: '';
    position: absolute;
    left: 0px;
    top: 0px;
    border-radius: 64px;
    background: linear-gradient(45deg , white , <?= $college_bcolors ;?> );
    background-size: 400%;
    width: calc(100%);
    height: calc(95%);
    z-index: -1;
    animation: steam 30s linear infinite;
}
  
  @keyframes steam {
    0% {
      background-position: 0 0;
    }
    50% {
      background-position: 400% 0;
    }
    100% {
      background-position: 0 0;
    }
  }
  
  .block:after {
    filter: blur(50px);
  }
@media only screen and (max-width: 768px) {
    /* Adjust font size and line height for smaller screens */
    .details {
        font-size: 1.5rem;
        line-height: 0.6cm;
    }

    .imgbox {
  
  width: 70%;
  height: 70%;
  transform: translateY(-80px);
  margin: auto;
 
}

img {
  width: 100%;
  border-radius: 10px;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.5);
  margin: auto;
}


}

@media only screen and (max-width: 480px) {
    /* Further adjustments for even smaller screens */
    .details {
        font-size: 1.2rem;
        line-height: 0.5cm;
    }
}



    </style>
</head>

<body>
    <?php include 'header.php'; ?>
   
    <marquee  width="100%" direction="right" height="100px"><h1 class="bash"  style="font-family:HS alkitab; background-color:<?= $college_color; ?>; " > کۆلێژی <?php echo $college_name; ?></h1>
    </marquee>
    
    
    <div class="home-bg">
        <section class="home">
            <!-- Content for the home section -->
        </section>
    </div>
    

    <br><br><br><br><br>

    <section class="home-category">

   
    
        <h1 class="title" style="font-family:HS alkitab">دیاریکردنی ڕۆب و کڵاوەکان</h1>
        <br><br><br>
        <div class="box-container">
            <!-- Display the selected college name -->
          

            <div class="box">
                <img class="drop" id="hawa" src="images/caps.avif" alt="">
                <br>
                <a href="category.php?category=caps" class="btn">کڵاو</a><p></p>
                <br> <br>
                <a href="drwstkrdn.php" ><i class="fa  fa-2x" style="align-items:center; justify-content:center; display:flex; color:grey;width:60px;margin:auto; padding:20px;border-radius:25px ; background-color:white; ">دروستکردن </i> </a>
            </div>

            <div class="box">
                <img  class="drop" id="hawa1" src="images/gownss.jpg" alt="">
                <br>
                <a href="category.php?category=rob" class="btn">ڕۆبەکان</a>
                <br><br> <br>
                <a href="drwstkrdn.php" ><i class="fa  fa-2x" style="align-items:center; justify-content:center; display:flex; color:grey;width:60px;margin:auto; padding:20px;border-radius:25px ; background-color:white; "> دروستکردن </i> </a>
            </div>

            <div class="box">
                <img class="drop" id="hawa2" src="cameraa.png" alt="">
                <br>
                <a href="#" class="btn">وێنەکان</a>
                <br><br> <br>
                <a href="#" ><i class="fa  fa-2x" style="align-items:center; justify-content:center; display:flex; color:grey;width:60px;margin:auto; padding:20px;border-radius:25px ; background-color:white; "> دیاریکردن</i> </a>
            </div>
        </div>
    </section>

    <section class="products">
        <!-- Content for the products section -->
    </section>

    <br><br>

    
   <section class="details">
   <div class="block"></block> 
    <div class="card">
      <div class="imgbox">
        <img
          src="<?= $college_Images ; ?>"
        />
      </div>
     
      <div class="content">
        <h2 style=" color: <?= $college_color; ?>;"><?= $college_name ; ?></h2>
        
        <br><br>
        <p>
        <?= $college_details ; ?>
        </p>
      </div>
    </div>
   </section>

    <?php include 'footer.php'; ?>

    <script>
        var images = ["college2.jpg", "college3.png", "image2.jpg"]; // Add more image URLs if needed
        var currentIndex = 0;
        var bgElement = document.querySelector('.home-bg');

        function changeBackground() {
            bgElement.style.backgroundImage = 'url(' + images[currentIndex] + ')';
            currentIndex = (currentIndex + 1) % images.length;
        }

        setInterval(changeBackground, 3000); // Change background every 5 seconds
    </script>
    <script src="js/script.js"></script>
</body>
</html>
