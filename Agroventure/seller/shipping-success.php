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
    $sql = "Update `orders` SET shipment_status='c' WHERE id = ".$_GET['id'];
    $conn->query($sql);
}
$conn->close();
echo $error;
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agroventure-Dashboard</title>
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
                        <li><a href="dashboard.php" class="link-light navbar-link nav-link px-2 active">Dashboard</a></li>
                        <li><a href="orders.php" class="link-light navbar-link nav-link px-2">Orders</a></li>
                        <li><a href="#" class="link-light navbar-link nav-link px-2">Customers</a></li>
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
        <div class="container my-0 px-3 py-4 bg-light">
        <!--If any error it will be printed here-->
        <?php if(!empty($error)) { ?>						
            <div class="row error">
                <?php echo $error;?>
            </div>
        <?php } ?>
            <div class="row text-dark">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <strong>Order Shipped Successfully</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
