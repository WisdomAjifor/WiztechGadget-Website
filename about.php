<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/pic2-removebg-preview.png" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Welcome to WIZTECH! We are thrilled to have you. At our ecommerce website we offer a range of gadgets that cater to all your tech needs. Allow us to introduce ourselves and give you a glimpse into what makes our store special.<br><br>Our passion for gadgets is what drives us. We understand the excitement that comes with exploring technologies and discovering products. Thats why we have curated a collection that combines fuctionality, style and quality. When you shop with us you can expect a selection of gadgets across categories. Whether you're looking for smartphones, tablets, smartwatches or other cutting edge devices-we've got you covered. Our team keeps up with the trends. Ensures that our inventory is constantly updated with the hottest gadgets on the market.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>