<?php include "dbinfo.inc"; ?>
<?php include('server.php') ?>

<html>
<head>
  <title>Personal Store</title>
  <style>
<?php include 'css.css'; ?>
</style>
<h1>CloudStore</h1>
</head>
<body>
	<h2>Personal Store</h2>
	<li><a href="index.php">Home</a></li>
  <li><a href="products.php">All Products</a></li>
  <li><a href="favourites.php">My Favourites</a></li>
	<li><a href="addproduct.php">Add Product</a></li>

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
  $product_sorts = htmlentities($_POST['Sorting']);
  $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller'");
  if(!empty($_POST['ID'])){
    $product_ID= htmlentities($_POST['ID']);
    DeleteProduct($connection,$product_ID,$seller);
  }


 
  ?>
  <form "<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST" >
  Sort by :
  <select name="Sorting">
  <option value="ID">ID</option>
  <option value="Price">Price</option>
  <option value="Category">Category</option>
</select>
<input type="submit" value= "Sort">
</form>
<?php
  
  if($product_sorts === "ID"){
    $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller'"); 
  }
  elseif($product_sorts === "Price"){
    $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller' ORDER BY LENGTH(Price), Price"); 
  }
  elseif($product_sorts === "Category"){
    $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller' ORDER BY Category"); 
  }
?>
  <table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Price (£)</td>
    <td>Category</td>
    <td>Description</td>
    <td>Image</td>
  </tr>
  <?php 

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>$query_data[0]</td>";
  echo "<td>$query_data[1]</td>";
  echo "<td>$query_data[2]</td>";
  echo "<td>$query_data[3]</td>";
  echo "<td>$query_data[5]</td>";
  //echo "<td>$query_data[6]</td>";
  echo "<td>";
  echo '<img src="data:image/jpeg;base64,'.base64_encode( $query_data[6] ).'" height="200" width="200" class="img-thumbnail"/>';
  //echo "<img src='data:image/jpeg;base64,'.base64_encode($query_data[6]).''/>";
  //echo "<td> <img src=\"data:image/jpeg;base64,'.base64_encode($query_data[6]).'\" height=\"200\" width=\"200\" class=\"img-thumbnail\" /> </td>";
       //image somehow
  echo"</td>";
  echo "</tr>\n";
}
//mysqli_query($connection, \"DELETE FROM Products WHERE id= Table.cols[0]\"
?>
<form action="<?php echo $PHP_SELF; ?>"method="POST">
  <table border="0">
        <input type="number" placeholder="Product's ID" name="ID" maxlength="5" size="10" />
        <input type="submit" value="Remove Product" />
</form>
<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>

<?php
function DeleteProduct($connection,$ID,$seller){
  //$q = mysqli_real_escape_string($connection, $ID);
      $query= "DELETE FROM LIms WHERE id='$ID' AND Seller='$seller'";
      mysqli_query($connection,$query);
      header('Refresh: 0');
}
?>
</body>
</html>