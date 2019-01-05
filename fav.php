<?php include "dbinfo.inc"; ?>
<?php include('server.php') ?>

<html>
<head>
	<style>
<?php include 'css.css'; ?>
</style>
<h1>CloudStore</h1>
  <title>Added!</title>
</head>
<body>
	<h2>Item Added to Favourites</h2>
	<li><a href="index.php">Home</a></li>
	<li><a href="products.php">All Products</a></li>
	<li><a href="personal.php">My Store</a></li>
  	<li><a href="favourites.php">My Favourites</a></li>
<?php
if (!isset($_SESSION['username'])) {
    header('location: login.php');
  }
$database = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$username="fav_" . $_SESSION['username'];
$id = $_GET['fav_id'];
$query = "INSERT INTO $username (fav_id) VALUES('$id')";
mysqli_query($database, $query);
?>
<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>

</body>
</html>
