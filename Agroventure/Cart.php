<?php
	//Start Session
	session_start();
?>
<?php
$error='';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agroventure";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	//die("Connection failed: " . $conn->connect_error);
	$error='Error connecting to website. Please try again.';
}

if(!empty($_GET['id'])) {
  $sql = "SELECT price FROM `products` WHERE id = ".$_GET['id'];
  $products = $conn->query($sql);
  if ($products->num_rows > 0) {
    $rowProduct = $products->fetch_assoc();

    $sql = "SELECT id FROM `orders` WHERE user_id = ".$_SESSION['id']." AND order_status='P'";
    $pendingOrder = $conn->query($sql);

    $orderId = 0;
    if ($pendingOrder->num_rows > 0) {
      $row = $pendingOrder->fetch_assoc();
      $orderId = $row['id'];
    } else {
      $sql = "INSERT INTO `orders` (user_id, order_status, shipment_status) VALUES ('".$_SESSION['id']."', 'p', 'p')";
      if ($conn->query($sql) !== FALSE) {
        $orderId = $conn->insert_id;
      }
    }
    $sql = "INSERT INTO `order_detail` (order_id, product_id, quantity, price) VALUES ('".$orderId."', '".$_GET['id']."', '1', '".$rowProduct['price']."')";
    $conn->query($sql);
  }
  header("Location: Cart.php");
}

if(!empty($_GET['del'])) {
  $sql = "DELETE FROM `order_detail` WHERE id=".$_GET['del'];
  $conn->query($sql);
  header("Location: Cart.php");
}

$sql = "SELECT od.*, p.name, p.picture_1 FROM orders as o JOIN `order_detail` as od ON(o.id=od.order_id) JOIN products as p ON(p.id=od.product_id) WHERE o.user_id = ".$_SESSION['id']." AND o.order_status='P'";
$cart = $conn->query($sql);

if(!empty($_POST['quantity']) && count($_POST['quantity'])>0) {
  foreach($_POST['quantity'] as $id => $quantity) {
    $sql = "UPDATE `order_detail` SET quantity='".$quantity."' WHERE id=".$id;
    $conn->query($sql);
  }
  header("Location: Cart.php");
}
$conn->close();
echo $error;
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
  <title>Agroventure Cart</title>
</head>
<body style="background-color: rgb(187, 203, 161);">
  <div class="nav bg-dark w-100">
    <ul class="main-nav bg-dark">
     <a href="index.html"><li><h2 style="color: white;">Agroventure</h2></li></a>
      <li><h1><a href="index.html" class="link-light nav-link fs-6">Home</a></h1></li>
      <li><h1><a href="Shop.php" class="link-light nav-link fs-6">Continue Shopping</a></h1></li>
    </ul>
  </div>
  <main class="w-auto">
    <div class="basket">
      <form method="post">
      <div class="container">
        <div class="row">
          <div class="col fs-5">Item</div>
          <div class="col fs-5"></div>
          <div class="col fs-5">Price</div>
          <div class="col ml-5 fs-5">Quantity</div>
          <div class="col ml-5 fs-5">Amount</div>
          <div class="col ml-5 fs-5">Delete</div>
        </div>
      </div>
      <div class="container">
      <?php
        $totalPrice=0;
        if ($cart->num_rows>0) {
          while($row = $cart->fetch_assoc()) {
            $amount=$row["price"] * $row['quantity'];
            $totalPrice+=$amount;
            echo '
            <div class="row basket-product">
              <div class="col"><img src="uploads/'.$row["picture_1"].'" height="25" alt="Placholder Image 2" class="product-frame"></div>
              <div class="col"><h1><strong><span class="item-quantity">'.$row["name"].'</span></strong></h1></div>
              <div class="col">'.$row["price"].'</div>
              <div class="col"><input type="number" name="quantity['.$row['id'].']" value="'.$row['quantity'].'" min="1" class="quantity-field"></div>
              <div class="col">'.$amount.'</div>
              <div class="col"><a class="btn btn-danger" onclick="return confirm(\'Are you sure you want to remove this product from cart?\');" href="Cart.php?del='.$row['id'].'" role="button">Remove</a></div>
            </div>';
          }
          $_SESSION['payableAmount'] =  $totalPrice;
        }
      ?>
      </div>
      <div class="clearfix"></div>
      <div class="container">
        <div class="row">
          <div class="col-12 fs-5 mt-5 d-flex justify-content-center"><input type="submit" class="btn btn-secondary" name="updateCart" value="Update Cart" /></div>
        </div>
      </div>
      <?php
        
      ?>
      </form>
    </div>
    <aside>
      <div class="w-25 h-50 summary position-fixed end-0" style="min-height:300px;">
        <div class="summary-total-items"><span class="total-items fs-4">Price</span></div>
        <div class="summary-subtotal fs-5">
          <div class="subtotal-title">Subtotal</div>
          <div class="subtotal-value final-value" id="basket-subtotal"><?php echo $totalPrice;?></div>
          <div class="summary-promo hide">
           
          </div>
        </div>
 
        <div class="summary-total fs-5">
          <div class="total-title">Total</div>
          <div class="total-value final-value" id="basket-total"><?php echo $totalPrice;?></div>
        </div>
        <div class="summary-checkout">
          <a href="Checkout.php">
          <button class="checkout-cta fs-5">Go to Secure Checkout</button>
          </a>
        </div>
      </div>
    </aside>
    
  </main>
</body>

</html>
<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,600);

html,
html a {
  -webkit-font-smoothing: antialiased;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
}

body {
  background-color: #fff;
  color: #666;
  font-family: 'Open Sans', sans-serif;
  font-size: 62.5%;
  margin: 0 auto;
}

a {
  border: 0 none;
  outline: 0;
  text-decoration: none;
}

strong {
  font-weight: bold;
}

p {
  margin: 0.75rem 0 0;
}

h1 {
  font-size: 0.75rem;
  font-weight: normal;
  margin: 0;
  padding: 0;
}

input,
button {
  border: 0 none;
  outline: 0 none;
}

button {
  background-color: #666;
  color: #fff;
}

button:hover,
button:focus {
  background-color: #555;
}

.basket-module,
.basket-labels,
.basket-product {
  width: 100%;
}

input,
button,
.basket,
.basket-module,
.basket-labels,
.item,
.price,
.quantity,
.subtotal,
.basket-product,
.product-image,
.product-details {
  float: left;
}

.price:before,
.subtotal:before,
.subtotal-value:before,
.total-value:before,
.promo-value:before {
  content: '₹';
}

.hide {
  display: none;
}

main {
  clear: both;
  font-size: 0.75rem;
  margin: 0 auto;
  overflow: hidden;
  padding: 1rem 0;
  width: 960px;
}

.basket,
aside {
  padding: 0 1rem;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.basket {
  width: 70%;
  background: #fff;
  padding: 30px 0;
}

.basket-module {
  color: #111;
}

label {
  display: block;
  margin-bottom: 0.3125rem;
}

.promo-code-field {
  border: 1px solid #ccc;
  padding: 0.5rem;
  text-transform: uppercase;
  transition: all 0.2s linear;
  width: 48%;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
  -o-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}

.promo-code-field:hover,
.promo-code-field:focus {
  border: 1px solid #999;
}

.promo-code-cta {
  border-radius: 4px;
  font-size: 0.625rem;
  margin-left: 0.625rem;
  padding: 0.6875rem 1.25rem 0.625rem;
}

.basket-labels {
  border: 1px solid #ccc;
  margin-top: 1.625rem;
}

ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

li {
  color: #111;
  display: inline-block;
  padding: 0.625rem 0;
}

li.price:before,
li.subtotal:before {
  content: '';
}

.item {
  width: 55%;
}

.price,
.quantity,
.subtotal {
  width: 15%;
}

.subtotal {
  text-align: right;
}

.remove {
  bottom: 1.125rem;
  float: right;
  position: absolute;
  right: 0;
  text-align: right;
  width: 45%;
}

.remove button {
  background-color: transparent;
  color: #777;
  float: none;
  text-decoration: underline;
  text-transform: uppercase;
}

.item-heading {
  padding-left: 4.375rem;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.basket-product {
  border-bottom: 1px solid #ccc;
  padding: 1rem 0;
  position: relative;
}

.product-image {
  width: 35%;
}

.product-details {
  width: 65%;
}

.product-frame {
  border: 1px solid #aaa;
}

.product-details {
  padding: 0 1.5rem;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.quantity-field {
  background-color: #ccc;
  border: 1px solid #aaa;
  border-radius: 4px;
  font-size: 0.625rem;
  padding: 2px;
  width: 3.75rem;
}

aside {
  /* float: right; */
  position: relative;
  width: 30%;
}

.summary {
  background-color: #eee;
  border: 1px solid #aaa;
  padding: 1rem;
  position: fixed;
  width: 250px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.summary-total-items {
  color: #666;
  font-size: 0.875rem;
  text-align: center;
}

.summary-subtotal,
.summary-total {
  border-top: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
  clear: both;
  margin: 1rem 0;
  overflow: hidden;
  padding: 0.5rem 0;
}

.subtotal-title,
.subtotal-value,
.total-title,
.total-value,
.promo-title,
.promo-value {
  color: #111;
  float: left;
  width: 50%;
}

.summary-promo {
  -webkit-transition: all .3s ease;
  -moz-transition: all .3s ease;
  -o-transition: all .3s ease;
  transition: all .3s ease;
}

.promo-title {
  float: left;
  width: 70%;
}

.promo-value {
  color: #8B0000;
  float: left;
  text-align: right;
  width: 30%;
}

.summary-delivery {
  padding-bottom: 3rem;
}

.subtotal-value,
.total-value {
  text-align: right;
}

.total-title {
  font-weight: bold;
  text-transform: uppercase;
}

.summary-checkout {
  display: block;
}

.checkout-cta {
  display: block;
  float: none;
  font-size: 0.75rem;
  text-align: center;
  text-transform: uppercase;
  padding: 0.625rem 0;
  width: 100%;
}

.summary-delivery-selection {
  background-color: #ccc;
  border: 1px solid #aaa;
  border-radius: 4px;
  display: block;
  font-size: 0.625rem;
  height: 34px;
  width: 100%;
}

@media screen and (max-width: 640px) {
  aside,
  .basket,
  .summary,
  .item,
  .remove {
    width: 100%;
  }
  .basket-labels {
    display: none;
  }
  .basket-module {
    margin-bottom: 1rem;
  }
  .item {
    margin-bottom: 1rem;
  }
  .product-image {
    width: 40%;
  }
  .product-details {
    width: 60%;
  }
  .price,
  .subtotal {
    width: 33%;
  }
  .quantity {
    text-align: center;
    width: 34%;
  }
  .quantity-field {
    float: none;
  }
  .remove {
    bottom: 0;
    text-align: left;
    margin-top: 0.75rem;
    position: relative;
  }
  .remove button {
    padding: 0;
  }
  .summary {
    margin-top: 1.25rem;
    position: relative;
  }
}

*{
  margin: auto 0;
}

nav {
  background-color: black;
}

.main-nav {
  display: flex;
  list-style: none;
  font-size: 1em;
  margin: 0;
}

@media only screen and (max-width: 600px) {
  .main-nav {
    font-size: 0.7em;
    padding: 0;
  }
}
/* faz o contato ir para o lado direito da pagina */
.push {
  margin-left: auto;
}

li {
  padding: 20px;
}

a {
  text-decoration: none;
  color: white;
}

@media screen and (min-width: 641px) and (max-width: 960px) {
  aside {
    padding: 0 1rem 0 0;
  }
  .summary {
    width: 28%;
  }
}

@media screen and (max-width: 960px) {
  main {
    width: 100%;
  }
  .product-details {
    padding: 0 1rem;
  }
}
</style>
<script>
  /* Set values + misc */
var promoCode;
var promoPrice;
var fadeTime = 300;

/* Assign actions */
$(".quantity input").change(function () {
  updateQuantity(this);
});

$(".remove button").click(function () {
  removeItem(this);
});

$(document).ready(function () {
  updateSumItems();
});

$(".promo-code-cta").click(function () {
  promoCode = $("#promo-code").val();

  if (promoCode == "10off" || promoCode == "10OFF") {
    //If promoPrice has no value, set it as 10 for the 10OFF promocode
    if (!promoPrice) {
      promoPrice = 10;
    } else if (promoCode) {
      promoPrice = promoPrice * 1;
    }
  } else if (promoCode != "") {
    alert("Invalid Promo Code");
    promoPrice = 0;
  }
  //If there is a promoPrice that has been set (it means there is a valid promoCode input) show promo
  if (promoPrice) {
    $(".summary-promo").removeClass("hide");
    $(".promo-value").text(promoPrice.toFixed(2));
    recalculateCart(true);
  }
});

/* Recalculate cart */
function recalculateCart(onlyTotal) {
  var subtotal = 0;

  /* Sum up row totals */
  $(".basket-product").each(function () {
    subtotal += parseFloat($(this).children(".subtotal").text());
  });

  /* Calculate totals */
  var total = subtotal;

  //If there is a valid promoCode, and subtotal < 10 subtract from total
  var promoPrice = parseFloat($(".promo-value").text());
  if (promoPrice) {
    if (subtotal >= 10) {
      total -= promoPrice;
    } else {
      alert("Order must be more than £10 for Promo code to apply.");
      $(".summary-promo").addClass("hide");
    }
  }

  /*If switch for update only total, update only total display*/
  if (onlyTotal) {
    /* Update total display */
    $(".total-value").fadeOut(fadeTime, function () {
      $("#basket-total").html(total.toFixed(2));
      $(".total-value").fadeIn(fadeTime);
    });
  } else {
    /* Update summary display. */
    $(".final-value").fadeOut(fadeTime, function () {
      $("#basket-subtotal").html(subtotal.toFixed(2));
      $("#basket-total").html(total.toFixed(2));
      if (total == 0) {
        $(".checkout-cta").fadeOut(fadeTime);
      } else {
        $(".checkout-cta").fadeIn(fadeTime);
      }
      $(".final-value").fadeIn(fadeTime);
    });
  }
}

/* Update quantity */
function updateQuantity(quantityInput) {
  /* Calculate line price */
  var productRow = $(quantityInput).parent().parent();
  var price = parseFloat(productRow.children(".price").text());
  var quantity = $(quantityInput).val();
  var linePrice = price * quantity;

  /* Update line price display and recalc cart totals */
  productRow.children(".subtotal").each(function () {
    $(this).fadeOut(fadeTime, function () {
      $(this).text(linePrice.toFixed(2));
      recalculateCart();
      $(this).fadeIn(fadeTime);
    });
  });

  productRow.find(".item-quantity").text(quantity);
  updateSumItems();
}

function updateSumItems() {
  var sumItems = 0;
  $(".quantity input").each(function () {
    sumItems += parseInt($(this).val());
  });
  $(".total-items").text(sumItems);
}

/* Remove item from cart */
function removeItem(removeButton) {
  /* Remove row from DOM and recalc cart total */
  var productRow = $(removeButton).parent().parent();
  productRow.slideUp(fadeTime, function () {
    productRow.remove();
    recalculateCart();
    updateSumItems();
  });
}

</script>
