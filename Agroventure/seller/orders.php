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

$sql = "SELECT * FROM `products` WHERE user_id = ".$_SESSION['id']."";
$categories = $conn->query($sql);
// Check connection
if ($conn->connect_error) {
	//die("Connection failed: " . $conn->connect_error);
	$error='Error connecting to website. Please try again.';
} else {
    
}
$conn->close();
echo $error;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Orders</title>
            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
    </head>
    <body>
        <header class="p-3 mb-3 border-bottom bg-dark text-light">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 nav-pills">
                        <li><a href="dashboard.php" class="link-light navbar-link nav-link px-2">Dashboard</a></li>
                        <li><a href="orders.php" class="link-light navbar-link nav-link px-2 active">Orders</a></li>
                        <li><a href="#" class="link-light navbar-link nav-link px-2">Customers</a></li>
                        <li><a href="products.php" class="link-light navbar-link nav-link px-2">Products</a></li>
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
        <div class="wrapper rounded">
            <nav class="navbar navbar-expand-lg navbar-dark dark d-lg-flex align-items-lg-start"> <a class="navbar-brand">Orders<p class="text-muted pl-1">Orders received </p> </a> 
                <div class="collapse navbar-collapse" id="navbarNav">
                    
                </div>
            </nav>
            <div class="row mt-2 pt-2">
                <div class="col-md-6" id="income">
                    <div class="d-flex justify-content-start align-items-center">
                        <p class="fa fa-long-arrow-down"></p>
                        <p class="text mx-3">Total Earnings</p>
                        <p class="text-white ml-4 money">₹Something</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end align-items-center">
                        <div class="fa fa-long-arrow-up"></div>
                        <div class="text mx-3">Orders Yet To Deliver</div>
                        <div class="text-white ml-4 money">1</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <ul class="nav nav-tabs w-75">
                
                </ul> <button class="btn btn-primary">Sell Product</button>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-dark table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Date</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Customer</td>
                            <td scope="row">Something</td>
                            <td class="text-muted">12 Jul 2020, 12:30 PM</td>
                            <td class="row"></span> 2 kg</td>
                            <td scope="row"> </span>123456789</td>
                            
                            <td scope="row"> </span>Pending </td>
                            <td scope="row"> </span>₹10 </td>
                        </tr>
                        <tr>
                            <td scope="row">Customer</td>
                            <td scope="row">Something</td>
                            <td class="text-muted">12 Jul 2020, 12:30 PM</td>
                            <td class="row"></span> 2 kg</td>
                            <td scope="row"> </span>123456789</td>
                            
                            <td scope="row"> </span>Delivered</td>
                            <td scope="row"> </span>₹10 </td>
                        </tr>
                        
                            
                    </tbody>
                </table>
            </div>
        
            
            </div>
        </div>
    </body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato&family=Poppins&display=swap');
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box
        }
        body {
            background-color: #777;
            font-family: 'Poppins', sans-serif
        }
        .wrapper {
            background-color: #222;
            min-height: 100px;
            max-width: 800px;
            margin: 10px auto;
            padding: 10px 30px
        }
        .dark,
        .input:focus {
            background-color: #222
        }
        .navbar {
            padding: 0.5rem 0rem
        }
        .navbar .navbar-brand {
            font-size: 30px
        }
        #income {
            border-right: 1px solid #bbb
        }
        .notify {
            display: none
        }
        .nav-item .nav-link .fa-bell-o,
        .fa-long-arrow-down,
        .fa-long-arrow-up {
            padding: 10px 10px;
            background-color: #444;
            border-radius: 50%;
            position: relative;
            font-size: 18px
        }
        .nav-item .nav-link .fa-bell-o::after {
            content: '';
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #ffc0cb;
            right: 10px;
            top: 10px
        }
        .nav-item input {
            border: none;
            outline: none;
            box-shadow: none;
            padding: 3px 8px;
            width: 75%;
            color: #eee
        }
        .nav-item .fa-search {
            font-size: 18px;
            color: #bbb;
            cursor: pointer
        }
        .navbar-nav:last-child {
            display: flex;
            align-items: center;
            width: 40%
        }
        .navbar-nav .nav-item {
            padding: 0px 0px 0px 10px
        }
        .navbar-brand p {
            display: block;
            font-size: 14px;
            margin-bottom: 3px
        }
        .text {
            color: #bbb
        }
        .money {
            font-family: 'Lato', sans-serif
        }
        .fa-long-arrow-down,
        .fa-long-arrow-up {
            padding-left: 12px;
            padding-top: 8px;
            height: 30px;
            width: 30px;
            border-radius: 50%;
            font-size: 1rem;
            font-weight: 100;
            color: #28df99
        }
        .fa-long-arrow-up {
            color: #ffa500
        }
        .nav.nav-tabs {
            border: none
        }
        .nav.nav-tabs .nav-item .nav-link {
            color: #bbb;
            border: none
        }
        .nav.nav-tabs .nav-link.active {
            background-color: #222;
            border: none;
            color: #fff;
            border-bottom: 4px solid #fff
        }
        .nav.nav-tabs .nav-item .nav-link:hover {
            border: none;
            color: #eee
        }
        .nav.nav-tabs .nav-item .nav-link.active:hover {
            border-bottom: 4px solid #fff
        }
        .nav.nav-tabs .nav-item .nav-link:focus {
            border-bottom: 4px solid #fff;
            color: #fff
        }
        .table-dark {
            background-color: #222
        }
        .table thead th {
            text-transform: uppercase;
            color: #bbb;
            font-size: 12px
        }
        .table thead th,
        .table td,
        .table th {
            border: none;
            overflow: auto auto
        }
        td .fa-briefcase,
        td .fa-bed,
        td .fa-exchange,
        td .fa-cutlery {
            color: #ff6347;
            background-color: #444;
            padding: 5px;
            border-radius: 50%
        }
        td .fa-bed,
        td .fa-cutlery {
            color: #40a8c4
        }
        td .fa-exchange {
            color: #b15ac7
        }
        tbody tr td .fa-cc-mastercard,
        tbody tr td .fa-cc-visa {
            color: #bbb
        }
        tbody tr td.text-muted {
            font-family: 'Lato', sans-serif
        }
        tbody tr td .fa-long-arrow-up,
        tbody tr td .fa-long-arrow-down {
            font-size: 12px;
            padding-left: 7px;
            padding-top: 3px;
            height: 20px;
            width: 20px
        }
        .results span {
            color: #bbb;
            font-size: 12px
        }
        .results span b {
            font-family: 'Lato', sans-serif
        }
        .pagination .page-item .page-link {
            background-color: #444;
            color: #fff;
            padding: 0.3rem .75rem;
            border: none;
            border-radius: 0
        }
        .pagination .page-item .page-link span {
            font-size: 16px
        }
        .pagination .page-item.disabled .page-link {
            background-color: #333;
            color: #eee;
            cursor: crosshair
        }
        @media(min-width:768px) and (max-width: 991px) {
            .wrapper {
                margin: auto
            }
            .navbar-nav:last-child {
                display: flex;
                align-items: start;
                justify-content: center;
                width: 100%
            }
            .notify {
                display: inline
            }
            .nav-item .fa-search {
                padding-left: 10px
            }
            .navbar-nav .nav-item {
                padding: 0px
            }
        }
        @media(min-width: 300px) and (max-width: 767px) {
            .wrapper {
                margin: auto
            }
            .navbar-nav:last-child {
                display: flex;
                align-items: start;
                justify-content: center;
                width: 100%
            }
            .notify {
                display: inline
            }
            .nav-item .fa-search {
                padding-left: 10px
            }
            .navbar-nav .nav-item {
                padding: 0px
            }
            #income {
                border: none
            }
        }
        @media(max-width: 400px) {
            .wrapper {
                padding: 10px 15px;
                margin: auto
            }
            .btn {
                font-size: 12px;
                padding: 10px
            }
            .nav.nav-tabs .nav-link {
                padding: 10px
            }
        }
    </style>
</html>