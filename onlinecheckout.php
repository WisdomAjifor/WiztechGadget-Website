<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};


//echo uniqid();
if(isset($_POST["check"])){
 $name = htmlspecialchars($_POST["name"]);
 $email = htmlspecialchars($_POST["email"]);
 $phone_number = htmlspecialchars($_POST["number"]);
 $amount = htmlspecialchars(430000);

 //integrate Rave payment
 $endpoint = "https://api.flutterwave.com/v3/payments";

 //Required Data
 $postdata = array(
 "tx_ref" => uniqid().uniqid(),
  "currency" => "NGN",
  "amount" => $amount,
  "customer" =>array(
    "name" => $name,
    "email" => $email,
    "phone_number" => $phone_number
  ),
  "customizations" =>array(
    "title" => "Payment on product",
    "description" => "paying for product"
  ),

  "meta" =>array(
    "reason" => "Paying for products",
    "address" => "Abuja"
  ),
  "redirect_url" => "http://localhost/work/verify.php"
 );

 //init cURL handler
 $ch = curl_init();

 //Turning off SSL checking
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

 //Set the endpoint
 curl_setopt($ch, CURLOPT_URL, $endpoint);

 //Turn on the cURL post method
 curl_setopt($ch, CURLOPT_POST, 1);

 //Encode the post field
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));

 //Make it to return data
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

 //Set the waiting timeout
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
 curl_setopt($ch, CURLOPT_TIMEOUT, 200);

 //Set the headers from endpoint
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Authorization: Bearer FLWSECK_TEST-ef19ba1eb29c4df96c32680667955883-X",
  "Content-Type: Application/json",
  "Cache-Control: no-cache"
 ));

 //Execute the cURL section
 $request = curl_exec($ch);

 $result = json_decode($request);
 header("Location: ".$result->data->link);

 //var_dump($result);
 //Close cURL section
 curl_close($ch);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span>NGN<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="99999999999" onkeypress="if(this.value.length == 11) return false;" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" onchange="location = this.value;" required>
               <option value="onlinecheckout.html">Online Payment</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. Gwarinpa" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. Abuja" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. Nigeria" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="check" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>