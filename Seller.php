<?php include "dbinfo.inc"; ?>
<?php include('server.php') ?>
<?php
$id = $_GET['id'];
?>
<html>
<head>
  <title><?php echo $id?>'s Store</title>
  <h1>CloudStore</h1>
  <style>
<?php include 'css.css'; ?>
</style>
</head>
<body>
	<h2><?php echo $id?>'s Store</h2>
	<li><a href="index.php">Home</a></li>
  <li><a href="products.php">All Products</a></li>
  <li><a href="personal.php">My Store</a></li>
  <li><a href="favourites.php">My Favourites</a></li>
	
	<h3>Contact information:</h3>

	<p>Email: 
		<?php
  
  //require ("register.php");
  		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  //if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  		$database = mysqli_select_db($connection, DB_DATABASE);
  		
  		$product_sorts = htmlentities($_POST['Sorting']);
  		//$result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller'");

  		$seller_query= mysqli_query($connection, "SELECT * FROM users WHERE username='$id'");
  		$seller_fetch= mysqli_fetch_assoc($seller_query);
  		$seller=$seller_fetch['email'];
  		$seller_username= $seller_fetch['username'];
  		  echo " $seller </p><p>Name: $seller_username</p>";
  ?>
  <h4>Products</h4>
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
    $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller_username'"); 
  }
  elseif($product_sorts === "Price"){
    $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller_username' ORDER BY LENGTH(Price), Price"); 
  }
  elseif($product_sorts === "Category"){
    $result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller_username' ORDER BY Category"); 
  }
  else{
  	$result = mysqli_query($connection, "SELECT * FROM LIms WHERE Seller='$seller_username'");
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
<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>

</body>
</html>