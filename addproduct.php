<?php include "dbinfo.inc"; ?>
<?php include('server.php') ?>

<html>
<head>
  <style>
<?php include 'css.css'; ?>
</style>
  <title>Add Product</title>
</head>
<body>
  <h1>CloudStore</h1>
	<h2>Add Product</h2>
	<li><a href="index.php">Home</a></li>
  <li><a href="products.php">All Products</a></li>
  <li><a href="personal.php">My Store</a></li>
  <li><a href="favourites.php">My Favourites</a></li>
<?php
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}
?>
<?php
  
  //require ("register.php");
  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  //if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);
  $seller=$_SESSION['username'];
  $product_name = htmlentities($_POST['Name']);
  $product_price = number_format(htmlentities($_POST['Price']), 2, ".", "");
  $product_category = htmlentities($_POST['Category']);
  //$product_seller = htmlentities($_POST['Seller']);
  $product_description = htmlentities($_POST['Description']);
  
  $product_img= file_get_contents($_FILES['image']['tmp_name']);
  ?>
  <form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST" onsubmit="<?PHP AddProduct($connection, $product_name, $product_price,$product_category, $product_description, $product_img)?>" enctype="multipart/form-data">
  
      <br>
      Name :
      <br>
      <input type="text" name="Name" maxlength="45" size="30" />
      <br>
      Price: 
      <br>
      <input type="number"  value="0.00" step="0.01" name="Price" maxlength="11" size="30" />
      <br>
      Category: 
      <br>
      <input type="text" name="Category" maxlength="45" size="30" />
      <br>
      Description: 
      <br>
      <textarea rows = "5" cols = "60" name = "Description"></textarea>
      <br>
      Image:
      <br>
        <input type="file" name="image" id="image"/>
    
        <center><input type="submit" value="Add Product" style="height:50px; width:200px"/></center>
</form>
<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>

<?php
function AddProduct($connection, $name, $price,$category,$description,$image1) {
    $image= addslashes($image1);
   //$i = addslashes(file_get_contents($_FILES['image']['tmp_name']));
   //$pic_size=$_FILES['image']['size'];
  if (strlen($name) && strlen($price) && strlen($category) &&strlen($description) && getimagesize($_FILES['image']['tmp_name'])) {
   $n = mysqli_real_escape_string($connection, $name);
   $p = mysqli_real_escape_string($connection, $price);
   $c = mysqli_real_escape_string($connection, $category);
   //$s = mysqli_real_escape_string($connection, $seller);
   $s=$_SESSION['username'];
   $d = mysqli_real_escape_string($connection, $description);
   ///$i = image somehow
   $query = "INSERT INTO LIms (Name,Price,Category,Seller,Description,img) 
             VALUES ('$n', '$p', '$c', '$s', '$d','$image')";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding product data.</p>");
   //unset($product_name, $product_price,$product_category,$product_seller,$product_description);
  }
   
}
?>