<?php

include './includes/db.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:index.php');
}

if (isset($_POST['add_to_wishlist'])) {

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_wishlist_numbers) > 0) {
      $message[] = 'Already added to wishlist';
   } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'Already added to cart';
   } else {
      mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
      $message[] = 'Product added to the wishlist';
   }
}

if (isset($_POST['add_to_cart'])) {

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'Already added to cart';
   } else {

      $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

      if (mysqli_num_rows($check_wishlist_numbers) > 0) {
         mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
      }

      mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Product added to the cart';
   }
}

?>


<!doctype html>
<html lang="en" class="data-bs-theme">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sweety Cake House - Home Page</title>
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/darkmode.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/navigation.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/user_profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

   <!-- Page navigation btn top and bottem  -->
   <button id="scrollBtn" class="btn btn-lg btn-secondary d-none d-md-block scroll-btn">
    <i id="scrollIcon" class="scrollIcon"></i> 
  </button>

   <!-- Naigation -->

  <?php
  include './includes/nav.php';
  ?>

    <!-- User Profile  -->
    <?php
    include './includes/user_profile.php'
    
    ?>

   <!-- Cart and Wishlist msg section  -->
 <?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="msg_box container text-center fs-4 p-1 mt-2 mb-3">
         <span>'.$message.'</span>
        <a class = "b_login" href = "#login" onclick="this.parentElement.remove();"><i class="fas fa-check fs-3"></i> </a>
      </div>
      ';
   }
}
?>
  


    <!-- slider  -->
    <section class="img_silder_section">

      <div class="container-fluid col-xs-6 col-sm-12 col-md-12 col-lg-12 img_silde">
      <div class="row">

        <div class="col-6 pt-3 img_text col-12 col col col-lg-12 col-xxl-7">
          <h1 class="text-start greeting"><span class="welcome_word1">Welcome</span> to the <span class="welcome_word2">World of Sweetness!</span></h1>

          <p>We’re so glad you’ve chosen us to be part of your sweet journey. <span class="phase_blue">At Sweety Cake House</span>, we believe that every occasion, big or small,<span class="phase_pink"> deserves a special cake.</span> 
            Our team is passionate about creating cakes that capture the essence of joy and celebration. Thank you for visiting – <span class="phase_pink">let’s create something delicious together!</span></p>

            <p class="second_p">We don’t just bake cakes; we create memories. <span class="phase_blue">At Sweety Cake House</span>, every cake is an expression of <span class="phase_pink">love and care,</span> designed to <span class="phase_pink">bring happiness</span> with every bite. 
              Choose from our custom designs or let us craft a one-of-a-kind cake for your next celebration</p>
                  
              <a href=""><button class="btn btn-lg disabled p-2 mt-5">Discover More</button></a>
        </div>




      <div id="carouselExampleSlidesOnly" class="slide col col-sm col-md-5 col-lg pe-0 d-none d-xxl-block" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./assest/img/slider_img_02.jpg" class="d-block w-100 img-fluid" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./assest/img/slider_img_01.jpg" class="d-block w-100 img-fluid" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./assest/img/logo-bg-black.png" class="d-block w-100 img-fluid" alt="...">
          </div>
        </div>
      </div>


    </div>
    </div>
    </section>

    <!-- end of slider  -->

    <!-- About us  -->

    <section id="aboutus" class="about_us_home my-5">


      <div class="topic_aboutus_home container-fluid">
        <hr width="60%" class="top_hr">
        <span class="key">A</span>
        <span class="key">B</span>
        <span class="key">O</span>
        <span class="key">U</span>
        <span class="key">T</span>
        <span class="key">-</span>
        <span class="key">U</span>
        <span class="key">S</span>
        <hr width="60%" class="down_hr">
      </div>
    
      <div class="container about_content_home py-3">
    
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
          <div class="col-12 col-lg-6 col-xl-5">
            <img class="img-fluid rounded" loading="lazy" src="./assest/img/about_cake.png" alt="About 1">
          </div>
          <div class="col-12 col-lg-6 col-xl-7">
            <div class="row justify-content-xl-center">
              <div class="col-12 col-xl-11">
    
                <h3 class="mb-3">Welcome to Sweety Cake House</h3>
                <p class="lead topic_msg fs-5 text-secondary mb-3 ps-2">At Sweety Cake House, we believe that every celebration deserves a sweet touch. Our passion for baking, combined with the finest ingredients, creates the most delightful cakes for your special moments.</p>
    
                <h3 class="mb-3">Our Journey</h3>
                <p class="lead topic_msg fs-5 text-secondary mb-3 ps-2">What began as a small, family-run bakery has grown into a beloved cake destination. We are proud to serve cakes that are not just desserts, but memories made with love and care.</p>
    
                <h3 class="mb-3">Quality Ingredients, Exquisite Flavors</h3>
                <p class="lead topic_msg fs-5 text-secondary mb-3 ps-2">We source only the highest quality ingredients to ensure that every bite is rich, flavorful, and irresistibly fresh. Whether it’s a birthday, wedding, or just a sweet craving, our cakes promise to delight.</p>
    
                <h3 class="mb-3">Our Promise</h3>
                <p class="lead topic_msg fs-5 text-secondary mb-3 ps-2">We are committed to providing cakes that are as unique and special as the moments they celebrate. With a focus on freshness, flavor, and creativity, Sweety Cake House is your go-to destination for sweet indulgence.</p>
                <p class="mb-2 cover_msg">We are a fast-growing company, but we have never lost sight of our core values. We believe in collaboration, innovation, and customer satisfaction. We are always looking for new ways to improve our products and services.</p>
    
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid mt-3 offers">
        <div class="row">
          <div class="col-sm-6 col-lg-4 d-flex text-center justify-content-center p-3 delivery text-white">
            <i class="fa fa-truck fs-1 p-3 text-muted" aria-hidden="true"></i>
            <div class="offers_text d-block text-muted">
              <h2>Fast Delivery</h2>
              <h6 class="text-muted">On all Location</h6>
            </div>
          </div>
          <div class="col col-lg-4 d-flex text-center justify-content-center p-3 fits text-white">
            <i class="fa fa-gift fs-1 p-3 text-muted" aria-hidden="true"></i>
            <div class="offers_text d-block text-muted">
              <h2>Offers & Fifts</h2>
              <h6>On all Oders</h6>
            </div>
          </div>
          <div class="col-md-12 col-lg-4 d-flex text-center justify-content-center p-3 payment text-white">
            <i class="fa fa-credit-card fs-1 p-3 text-muted" aria-hidden="true"></i>
            <div class="offers_text d-block text-muted">
              <h2>Secure Payments</h2>
              <h6>Protected Methods</h6>
            </div>
          </div>

        </div>
      </div>
    
</section>
    

     <!-- End about us  -->

     <!-- Products  -->
   
     <section id="products" class="products_home">
    
      <div class="topic_product_home">
        <hr width="60%" class="top_hr">
        <span class="key">O</span>
        <span class="key">U</span>
        <span class="key">R</span>
        <span class="key">-</span>
        <span class="key">P</span>
        <span class="key">R</span>
        <span class="key">O</span>
        <span class="key">D</span>
        <span class="key">U</span>
        <span class="key">C</span>
        <span class="key">T</span>
        <span class="key">S</span>
        <hr width="60%" class="down_hr">
      </div>

      <div class="container text-center mt-3 py-3">
   <div class="row">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 9") or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
         while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
               <div class="card h-100">
                  <form action="" method="POST" class="box">
                     <div class="card-body">
                        <h5 class="card-title fs-4"><?php echo $fetch_products['name']; ?></h5>
                        <p class="price text-muted">Rs.<?php echo $fetch_products['price']; ?>/-</p>
                        <div class="image mb-3">
                           <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="img-fluid" alt="">
                        </div>
                     </div>
                     <div class="card-footer">
                        <input type="hidden" name="product_quantity" value="1" min="0" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                        <input type="submit" value="&#129293;" name="add_to_wishlist" class="btn btn_wishlist w-100 mb-3 p-2 fs-5">
                        <input type="submit" value="Add to cart" name="add_to_cart" class="btn btn_cart w-100 mb-3 p-2 fs-5">
                     </div>
                  </form>
               </div>
            </div>
      <?php
         }
      } else {
         echo '<div class = "container noproducts_msg py-2 my-2">
         <p class="empty text-center m-3 fs-5">No products added yet!</p>
         </div>';
      }
      ?>
   </div>

      </section>

      
      <!-- End of Products  -->

      
      

      <!-- Footer  -->
      
      <?php
     include './includes/footer.php';
 
      ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script src="./js/navigation.js"></script>
    <script src="./js/darkmode.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>