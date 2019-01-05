<?php include "dbinfo.inc"; ?>
<?php include('server.php') ?>

<html>
<head>
  <title>Products</title>
  <style>
<?php include 'css.css'; ?>
</style>
</head>
<body>
<h1>CloudStore</h1>
  <li><a href="index.php">Home</a></li>
  <li><a href="personal.php">My Store</a></li>
  <li><a href="favourites.php">My Favourites</a></li>
<h2>Products</h2>

<?php
if (!isset($_SESSION['username'])) {
    header('location: login.php');
  }
  ?>
<?php
  
  //require ("register.php");
  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);


  VerifyProductsTable($connection, DB_DATABASE);


  $product_name = htmlentities($_POST['Name']);
  $product_price = htmlentities($_POST['Price']);
  $product_category = htmlentities($_POST['Category']);
  $product_description = htmlentities($_POST['Description']);
  $product_ID= htmlentities($_POST['ID']);
  $product_img= file_get_contents($_FILES['image']['tmp_name']);
  $product_sort = htmlentities($_POST['Sort']);
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
<p style="color: teal;"> Click on the ID of a product to add it to your favourites!</p>
<!-- Display table data. -->
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
  $result = mysqli_query($connection, "SELECT * FROM LIms"); 
}
elseif($product_sort === "Price"){
  $result = mysqli_query($connection, "SELECT * FROM LIms ORDER BY LENGTH(Price), Price"); 
}
elseif($product_sort === "Category"){
  $result = mysqli_query($connection, "SELECT * FROM LIms ORDER BY Category"); 
}
elseif($product_sort === "Seller"){
  $result = mysqli_query($connection, "SELECT * FROM LIms ORDER BY Seller"); 
}
else{
  $result = mysqli_query($connection, "SELECT * FROM LIms");
}



while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td><a href='fav.php?fav_id=$query_data[0]'>$query_data[0]</a></td>";
  echo "<td>$query_data[1]</td>";
  echo "<td>$query_data[2]</td>";
  echo "<td>$query_data[3]</td>";
  echo "<td><a href='Seller.php?id=$query_data[4]'>$query_data[4]</a></td>";
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
</table>
<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>






<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>




<?php

///////////////////////////////////////////////////////
/* Check whether the table exists and, if not, create it. */
function VerifyProductsTable($connection, $dbName) {
  if(!TableExists("LIms", $connection, $dbName)) 
  { 
     $query = "CREATE TABLE LIms (
                id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                Name VARCHAR(30) NOT NULL,
                Price VARCHAR(6) NOT NULL,
                Category VARCHAR(50) NOT NULL,
                Seller VARCHAR(90) NOT NULL,
                Description VARCHAR(255) NOT NULL,
                img LONGBLOB NOT NULL
                )";
    if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
     
  }
}



/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection, 
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
