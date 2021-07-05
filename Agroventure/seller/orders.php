<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
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
if ($conn->connect_error) {
	//die("Connection failed: " . $conn->connect_error);
	$error='Error connecting to website. Please try again.';
}

$sql = "SELECT p.*, c.name as categoryName, od.order_id, od.quantity, od.price as sellingPrice FROM `order_detail` as od JOIN `products` as p ON(od.product_id=p.id) JOIN categories c ON(p.category_id=c.id)  WHERE p.user_id = ".$_SESSION['id'];
$products = $conn->query($sql);
if(!empty($_POST)) {
	//Check connection
	// generates a unique name for the uploaded pictures
	
	//Saves data to the database
	$sql = "INSERT INTO `products` (user_id, name, description, picture_1, picture_2, picture_3, picture_4, picture_5, price, category_id, created_on) VALUES ('".$_SESSION['id']."', '".$_POST['name']."', '".$_POST['description']."', '".$uniqueFilename_1."', '".$uniqueFilename_2."', '".$uniqueFilename_3."', '".$uniqueFilename_4."', '".$uniqueFilename_5."', '".$_POST['price']."', '".$_POST['category']."', '".date("Y-m-d")."')";

	if ($conn->query($sql) === FALSE) {
		$error='Error in saving data. Please try again.';
	}
	else {
		//redirect to another page
		header("Location: dashboard.php");
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
		<title>Agroventure Add-Products</title>
        <link rel="stylesheet" href="../style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
	</head>
	<body style="background-color: #ced4da;">
        <header class="p-3 mb-3 border-bottom bg-dark text-light">
            <div class="container">
				<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
					<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
						<svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
					</a>

					<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 nav-pills">
						<li><a href="dashboard.php" class="link-light navbar-link nav-link px-2">Dashboard</a></li>
						<li><a href="orders.php" class="link-light navbar-link nav-link px-2 active">Orders</a></li>
						<li><a href="products-list.php" class="link-light navbar-link nav-link px-2">Products</a></li>
					</ul>

					<div class="row">
						<div class="col">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
								<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
								<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
							</svg><span class="display-name mx-2 my-1"><?php echo $_SESSION['fname']." ".$_SESSION['lname'];?></span>
							<a href="log_out.php">
								<button type="button" class="mr-3 px-2 py-1 btn btn-danger">Log-Out
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
										<path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
									</svg>
								</button>
							</a>
						</div>
					</div>
				</div>
            </div>
        </header>
		<div class="container rounded-bottom my-0 mb-0 px-3 py-4 text-dark bg-light">
			<!--If any error it will be printed here-->
			<?php if(!empty($error)) { ?>						
				<div class="error alert alert-danger">
					<?php echo $error;?>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col fs-2">Orders:</div>
			</div>
		</div>
		<div class="container rounded-top my-0 px-3 mt-0 py-4 text-dark bg-light">
			<div class="row">
				<div class="row">
					<table class="table table-striped table-hover">
						<tr>
							<th>Product Name</th>
							<th>Description</th>
							<th>Category</th>
							<th>Price</th>
							<th>Quantity</th>
							<th></th>
						</tr>
					<?php
						if ($products->num_rows > 0) {
							while($row = $products->fetch_assoc()) {
								echo '<tr>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$row['description'].'</td>';
								echo '<td>'.$row['categoryName'].'</td>';
								echo '<td>'.$row['sellingPrice'].'</td>';
								echo '<td>'.$row['quantity'].'</td>';
								echo '<td><a class="btn btn-primary" href="shipping.php?id='.$row['order_id'].'" role="button">Ship Now</a></td>';
								echo '</tr>';
							}
						}
					?>
					</table>
				</div>
			</div>
		
		</div>
	</body>
</html>