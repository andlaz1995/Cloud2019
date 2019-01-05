<?php include "dbinfo.inc"; ?>
<?php include('server.php') ?>

<html>
<head>
  <title>Favourites</title>
  <style>
<?php include 'css.css'; ?>
</style>
<h1>CloudStore</h1>
</head>
<body>
	<h2>Favourites</h2>
	<li><a href="index.php">Home</a></li>
  <li><a href="products.php">All Products</a></li>
  <li><a href="personal.php">My Store</a></li>
<?php
if (!isset($_SESSION['username'])) {
    header('location: login.php');
  }
  ?>
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);
  $user=$_SESSION['username'];
  $username="fav_" . $_SESSION['username'];
  $product_sort = htmlentities($_POST['Sort']);



 if(!empty($_POST['IDs'])){
    $product_IDs= htmlentities($_POST['IDs']);
    RemoveFavourite($connection,$product_IDs,$username);
  }
  ?>
  <form "<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST" >
  Sort by :
  <select name="Sort">
  <option value="ID">ID</option>
  <option value="Price">Price</option>
  <option value="Category">Category</option>
  <option value="Seller">Seller</option>
</select>
<input type="submit" value= "Sort">
</form>

<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Price (£)</td>
    <td>Category</td>
    <td>Seller</td>
    <td>Description</td>
    <td>Image</td>
  </tr>

<?php

if($product_sort === "ID"){
  $result = mysqli_query($connection, "SELECT id,Name,Price,Category,Seller,Description,img FROM LIms WHERE id IN(SELECT fav_id FROM $username)");
}
elseif($product_sort === "Price"){
  $result = mysqli_query($connection, "SELECT id,Name,Price,Category,Seller,Description,img FROM LIms WHERE id IN(SELECT fav_id FROM $username)ORDER BY LENGTH(Price), Price");
}
elseif($product_sort === "Category"){
  $result = mysqli_query($connection, "SELECT id,Name,Price,Category,Seller,Description,img FROM LIms WHERE id IN(SELECT fav_id FROM $username)ORDER BY Category");
}
elseif($product_sort === "Seller"){
  $result = mysqli_query($connection, "SELECT id,Name,Price,Category,Seller,Description,img FROM LIms WHERE id IN(SELECT fav_id FROM $username)ORDER BY Seller"); 
}
else{
  $result = mysqli_query($connection, "SELECT id,Name,Price,Category,Seller,Description,img FROM LIms WHERE id IN(SELECT fav_id FROM $username)");
}



while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>$query_data[0]</td>";
  echo "<td>$query_data[1]</td>";
  echo "<td>$query_data[2]</td>";
  echo "<td>$query_data[3]</td>";
  echo "<td><a href='Seller.php?id=$query_data[4]'>$query_data[4]</a></td>";
  echo "<td>$query_data[5]</td>";
  echo "<td>";
  echo '<img src="data:image/jpeg;base64,'.base64_encode( $query_data[6] ).'" height="200" width="200" class="img-thumbnail"/>';
  echo"</td>";
  echo "</tr>\n";
}
//mysqli_query($connection, \"DELETE FROM Products WHERE id= Table.cols[0]\"
?>
</table>
<form action="<?php echo $PHP_SELF; ?>"method="POST" >
  <table border="0">

        <input type="number" placeholder="Product's ID" name="IDs" maxlength="5" size="10" />
        <input type="submit" value="Remove Product" />
</form>
<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>

<?php
  
function RemoveFavourite($connection,$ID,$username){
      $query= "DELETE FROM $username WHERE fav_id='$ID'";
      mysqli_query($connection,$query);
      //header("Refresh:0");
      //if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
      //header('location: personal.php');
}


?>
