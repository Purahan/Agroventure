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

$sql = "SELECT * FROM `products` WHERE 1";
$products = $conn->query($sql);
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
    <title>Agroventure-Shop</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: rgb(187, 203, 161);">
  <div id="header container">
    <header class="d-flex row flex-wrap justify-content-center px-3 py-3 mb-4 border-bottom bg-dark ">
      <div class="col">
        <a href="shop.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-light text-decoration-none">
          <span class="fs-4 mx-3">Agroventure Shop</span>
        </a>      
      </div>
      <div class="col offset-6">
        <ul class="nav nav-pills ">
          <li class="nav-item">
            <a href="Cart.php" class="nav-link link-light active mx-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
              </svg> Cart
            </a>
          </li>
          <li class="nav-item text-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
            <span class="display-name mx-2 my-1"><?php echo $_SESSION['fname']." ".$_SESSION['lname'];?></span>
          </li>
          <li class="nav-item text-light">
            <a href="log-out.php">
              <button type="button" class="btn btn-danger">Log Out
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                  <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"></path>
                </svg>
              </button>
            </a>
          </li>
        </ul>
      </div>
    </header>
</div>
<div class="col mx-3">
  <div id="myBtnContainer">
    <button class="butn active-butn" onclick="filterSelection('all')">Show all</button>
    <button class="butn" onclick="filterSelection('fruits')">Fruits</button>
    <button class="butn" onclick="filterSelection('vegetables')">Vegetables</button>
    <button class="butn" onclick="filterSelection('dairy-products')">Dairy Products</button>
    <button class="butn" onclick="filterSelection('poultry-products')">Poultry Products</button>
    <button class="butn" onclick="filterSelection('handicrafts')">Handicrafts</button>
    <button class="butn" onclick="filterSelection('handloom')">Handloom</button>
    <button class="butn" onclick="filterSelection('clay-products')">Clay Products</button>
    <button class="butn" onclick="filterSelection('others')">Others</button>
  </div>
</div>
<i>
<?php
if ($products->num_rows > 0) {
  while($row = $products->fetch_assoc()) {
    if($row['category_id'] == "1"){
      $row['category_id'] = "fruits";
    }
    if($row['category_id'] == "2"){
      $row['category_id'] = "vegetables";
    }
    if($row['category_id'] == "3"){
      $row['category_id'] = "dairy-products";
    }
    if($row['category_id'] == "4"){
      $row['category_id'] = "poultry-products";
    }
    if($row['category_id'] == "5"){
      $row['category_id'] = "handicrafts";
    }
    if($row['category_id'] == "6"){
      $row['category_id'] = "handloom";
    }
    if($row['category_id'] == "7"){
      $row['category_id'] = "clay-products";
    }
    if($row['category_id'] == "8"){
      $row['category_id'] = "others";
    }

    echo '
    <div class="shadow bg-body rounded filterDiv bg-light card mx-2 my-2 h-10 '.$row["category_id"].'" style="width: 18rem;">
      <img src="uploads/'.$row["picture_1"].'" class="card-img-top" alt="...">
      <div class="card-body mb-0">
        <h5 class="card-title fs-2">'.$row["name"].'</h5>
        <p class="card-text text-dark fs-6 mb-0">Price: ₹'.$row["price"].'<br />'.$row["description"].'</p>
        <a href="Cart.php?id='.$row['id'].'" class="btn btn-primary">Add to Cart</a>
      </div>
    </div>';
  }
}
?>
</i>
  <script>
    filterSelection("all")
    function filterSelection(c) {
      var x, i;
      x = document.getElementsByClassName("filterDiv");
      if (c == "all") c = "";
      for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
      }
    }

    function w3AddClass(element, name) {
      var i, arr1, arr2;
      arr1 = element.className.split(" ");
      arr2 = name.split(" ");
      for (i = 0; i < arr2.length; i++) {
        if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
      }
    }

    function w3RemoveClass(element, name) {
      var i, arr1, arr2;
      arr1 = element.className.split(" ");
      arr2 = name.split(" ");
      for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
          arr1.splice(arr1.indexOf(arr2[i]), 1);     
        }
      }
      element.className = arr1.join(" ");
    }

    // Add active class to the current button (highlight it)
    var btnContainer = document.getElementById("myBtnContainer");
    var btns = btnContainer.getElementsByClassName("butn");
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function(){
        var current = document.getElementsByClassName("active-butn");
        current[0].className = current[0].className.replace(" active-butn", "");
        this.className += " active-butn";
      });
    }
  </script>
  <style>
    .butn {
      border: none;
      outline: none;
      padding: 12px 16px;
      background-color: #f1f1f1;
      cursor: pointer;
    }
    .butn:hover {
      background-color: #ddd;
    }
    .active-butn {
      background-color: #666;
      color: white;
    }
    .container {
      margin-top: 20px;
      overflow: hidden;
    }
    .active:hover {
      color: #000;
    }
    .filterDiv {
      float: left;
      background-color: #2196F3;
      color: #ffffff;
      width: 100px;
      line-height: 100px;
      text-align: center;
      margin: 2px;
      display: none;
    }
    .show {
      display: block;
    }
  </style>
  </body>
</html>