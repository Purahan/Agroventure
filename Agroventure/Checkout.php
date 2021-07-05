<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	//Start Session
	session_start();
?>
<?php
$error='';
if(!empty($_POST)) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "agroventure";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if ($conn->connect_error) {
		//die("Connection failed: " . $conn->connect_error);
		$error='Error connecting to website. Please try again.';
	} else {

		$sql = "INSERT INTO `address` (user_id, address1, address2, city, state, zip) VALUES ('".$_SESSION['id']."', '".$_POST['houseadd-1']."', '".$_POST['houseadd-2']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['zip']."')";

		if ($conn->query($sql) === FALSE) {
			$error='Error in saving data. Please try again.';
		} else {
      $sql = "Update `orders` SET order_status='c' WHERE order_status='p' AND user_id = ".$_SESSION['id'];
      $conn->query($sql);
			//redirect to another page
			header("Location: ThankYou.html");
		}
	}
	$conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agroventure Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
</head>
<body style="background-color: rgb(187, 203, 161);">
  <div class="container">
    <div class="title bg-dark text-light">
        <h2>Checkout Form</h2>
    </div>
  <div class="d-flex">
    <form action="Checkout.php" method="POST">
      <label>
        <span>Country <span class="required">*</span></span>
        <select name="selection">
          <option value="select">India</option>
         
        </select>
      </label>
      <label>
        <span> Address-1 <span class="required">*</span></span>
        <input type="text" name="houseadd-1" placeholder="Address-1" required>
      </label>
      <label>
        <span> Address-2 <span class="required">*</span></span>
        <input type="text" name="houseadd-2" placeholder="Address-2" required>
      </label>
      <label>
        <span> City <span class="required">*</span></span>
        <input type="text" name="city" placeholder="Your City" required> 
      </label>
      <label>
        <span>State<span class="required">*</span></span>
        <input type="text" name="state" placeholder="Your State" required>
      </label>
      <label>
        <span>Postcode / ZIP <span class="required">*</span></span>
        <input type="text" name="zip" placeholder="Your Postcode" required> 
      </label>
      
        <button type="submit" class="btn btn-success">Make Order</button>
        
        
    </form>
    <div class="Yorder">
      <table>
        <tr>
          <th colspan="2">Your order</th>
        </tr>
        <tr>
          <td>Payable Amount</td>
          <td class="total-value"><?php echo $_SESSION['payableAmount'];?></td>
        </tr>
        <tr>
          <td>Shipping</td>
          <td>Free shipping</td>
        </tr>
      </table><br>
      <div>
        
     <h3 style="text-align: center;">  Cash on Delivery is the only available method</h3>
      </div>
      <div>

      
       
      </div>
      <a href="shop.php">
      <button type="button" class="btn btn-success">Don't want to buy? So Continue Shopping</button>
      </a>
    </div>
    
   </div>
   
</div>
</body>
</html>

  <style>
      @import url('https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700');

body{
  font-family: 'Roboto Condensed', sans-serif;
  color: #262626;
  margin: 5% 0;
}
.container{
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}
@media (min-width: 1200px)
{
  .container{
    max-width: 1140px;
  }
}
.d-flex{
  display: flex;
  flex-direction: row;
  background: #f6f6f6;
  border-radius: 0 0 5px 5px;
  padding: 25px;
}
form{
  flex: 4;
}
.Yorder{
  flex: 2;
}
.title{
  border-radius:5px 5px 0 0 ;
  padding: 20px;
  color: #f6f6f6;
}
h2{
  margin: 0;
  padding-left: 15px; 
}
.required{
  color: red;
}
label, table{
  display: block;
  margin: 15px;
}
label>span{
  float: left;
  width: 25%;
  margin-top: 12px;
  padding-right: 10px;
}
input[type="text"], input[type="tel"], input[type="email"], select
{
  width: 70%;
  height: 30px;
  padding: 5px 10px;
  margin-bottom: 10px;
  border: 1px solid #dadada;
  color: #888;
}
select{
  width: 72%;
  height: 45px;
  padding: 5px 10px;
  margin-bottom: 10px;
}
.Yorder{
  margin-top: 15px;
  height: 600px;
  padding: 20px;
  border: 1px solid #dadada;
}
table{
  margin: 0;
  padding: 0;
}
th{
  border-bottom: 1px solid #dadada;
  padding: 10px 0;
}
tr>td:nth-child(1){
  text-align: left;
  color: #2d2d2a;
}
tr>td:nth-child(2){
  text-align: right;
  color: #52ad9c;
}
td{
  border-bottom: 1px solid #dadada;
  padding: 25px 25px 25px 0;
}

p{
  display: block;
  color: #888;
  margin: 0;
  padding-left: 25px;
}
.Yorder>div{
  padding: 15px 0; 
}

button{
  width: 100%;
  margin-top: 10px;
  padding: 10px;
  border: none;
  border-radius: 30px;
  background: #52ad9c;
  color: #fff;
  font-size: 15px;
  font-weight: bold;
}
button:hover{
  cursor: pointer;
  background: #428a7d;
}
.total-value:before {
  content: '₹';
}
  </style>

  <script>
      document.querySelector('.btn2').style.display = 'none'; 
document.querySelector('.btn1').addEventListener('click', showBtn); 
 
function showBtn(e) { 
 document.querySelector('.btn2').style.display = 'block'; 
 e.preventDefault(); 
} 
  </script>
