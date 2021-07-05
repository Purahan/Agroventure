<?php
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
	// Check connection
	if ($conn->connect_error) {
		//die("Connection failed: " . $conn->connect_error);
		$error='Error connecting to website. Please try again.';
	} else {
		$sql = "SELECT id, first_name, last_name, email, gender FROM `users` WHERE email='".$_POST['email']."' AND pwd=MD5('".$_POST['pwd']."')";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "Name:".$row["first_name"]."<br> Email: ".$row["email"]."<br>";
				//$_SESSION['id'] = $row["Username"];
                $_SESSION['id'] = $row['id'];
				$_SESSION['fname'] = $row["first_name"];
                $_SESSION['lname'] = $row["last_name"];
				$_SESSION['email'] = $row["email"];
				$_SESSION['gender'] = $row["gender"];
				header("Location: shop.php");
			}
		} else {
			$error='Username or Password is incorrect.';
		}
	}
	$conn->close();
}?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agroventure-Login</title>
        <link rel="stylesheet" href="style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
    </head>
    <body style="background-color: rgb(187, 203, 161); font-family: Arial, Helvetica, sans-serif;">
        <div id="header">
            <header class="d-flex flex-wrap justify-content-center px-3 py-3 mb-4 border-bottom bg-light">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                <span class="fs-4">Agroventure</span>
                </a>
        
                <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.html" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="index.html" class="nav-link">About</a></li>
                <li class="nav-item"><a href="index.html" class="nav-link">Products</a></li>
                <li class="nav-item"><a href="index.html" class="nav-link">Testimonial</a></li>
                <li class="nav-item"><a href="sign-in.php" class="nav-link active">Login</a></li>
                <li class="nav-item"><a href="sign-up.php" class="nav-link">Sign Up</a></li>
                </ul>
            </header>
        </div>
        <form action="#" method="post">
            <div class="container bg-light my-5 py-4 px-5">
                <h1 class="fs-1">Login</h1>
                <p>Please fill in this form to Login in to your account.</p>
                <hr>
                <div class="row my-3">
                    <div class="col">
                        <label for="email" class="form-label">Username</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" aria-describedby="email" required />
                    </div>
                </div>
                <div class="row pb-3" class="pb-1">
                    <div class="col">
                        <label for="pwd ">Password</label>
                    </div>
                </div>
                <div class="row pb-3" class="pb-1">
                    <div class="col">
                    <input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd" required />
                    </div>
                </div>
                <hr>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

                <input type="submit" class="btn btn-success w-100 px-2 py-2 fs-5" value="Login" />
                <p>Don't have an account? <a href="Sign-Up.html">Sign Up</a>.</p>
            </div>
        </form>
    </body>
</html>
