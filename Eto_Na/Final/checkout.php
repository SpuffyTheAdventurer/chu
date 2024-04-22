<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($fetch_cart = mysqli_fetch_assoc($cart_query)){
         // Check if price and quantity are numeric before calculation
         if (is_numeric($fetch_cart['price']) && is_numeric($fetch_cart['quantity'])) {
            $product_price = $fetch_cart['price'] * $fetch_cart['quantity'];
            $price_total += $product_price;
         } else {
            // Handle the case where price or quantity is not numeric
            echo "<div style='color: red;'>Price or quantity is not numeric for product: " . $fetch_cart['name'] . "</div>";
         }
      };
   };

   // Check if $price_total is numeric before inserting into the database
   if (is_numeric($price_total)) {
      // Proceed with inserting into the database
      $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','Total Products','$price_total')") or die(mysqli_error($conn));
   } else {
      // Handle the case where price_total is not numeric
      echo "<div style='color: red;'>Price total is not numeric.</div>";
   }

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Thank you for shopping!</h3>
         <div class='order-detail'>
            <span>Total Products</span>
            <span class='total'> Total : ₱".$price_total."/-  </span>
         </div>
         <div class='customer-details'>
            <p> Your Name : <span>".$name."</span> </p>
            <p> Your Number : <span>".$number."</span> </p>
            <p> Your Email : <span>".$email."</span> </p>
            <p> Your Address : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
            <p> Your Payment Mode : <span>".$method."</span> </p>
            <p>(*Pay when product arrives*)</p>
         </div>
            <a href='products.php' class='btn'>Continue Shopping</a>
         </div>
      </div>
      ";
   }

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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            // Check if price and quantity are numeric before calculation
            if (is_numeric($fetch_cart['price']) && is_numeric($fetch_cart['quantity'])) {
               $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
               $grand_total = $total += $total_price;
               echo "<span>" . $fetch_cart['name'] . "(" . $fetch_cart['quantity'] . ")</span>";
            } else {
               // Handle the case where price or quantity is not numeric
               echo "<div style='color: red;'>Price or quantity is not numeric for product: " . $fetch_cart['name'] . "</div>";
            }
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : ₱<?= $grand_total; ?>/- </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Students Name</span>
            <input type="text" placeholder="enter your name" name="name" required>
         </div>
         <div class="inputBox">
            <span>Students Contact Number</span>
            <input type="number" placeholder="enter your number" name="number" required>
         </div>
         <div class="inputBox">
            <span>Students Email</span>
            <input type="email" placeholder="enter your email" name="email" required>
         </div>
         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="Gcash Payment" selected>Gcash Payment</option>
               <option value="credit cart">N/A</option>
               <option value="paypal">N/A</option>
            </select>
         </div>
         <div class="inputBox">
            <span>School Building</span>
            <input type="text" placeholder="your building" name="flat" required>
         </div>
         <div class="inputBox">
            <span>Students Strand and Section</span>
            <input type="text" placeholder="your strand" name="street" required>
         </div>
         <div class="inputBox">
            <span>Students Cluster</span>
            <input type="text" placeholder="your cluster" name="city" required>
         </div>
         <div class="inputBox">
            <span>Students Advisory</span>
            <input type="text" placeholder="Students Advisor" name="state" required>
         </div>
         <div class="inputBox">
            <span>Students Year</span>
            <input type="text" placeholder="Students Year" name="country" required>
         </div>
         <div class="inputBox">
            <span>Students ID NUMBER</span>
            <input type="text" placeholder="your ID NUMBER" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>