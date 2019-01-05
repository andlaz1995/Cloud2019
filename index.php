<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: index.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<style>
<?php include 'css.css'; ?>
</style>
</head>
<body>

<div class="header">
	<h1>CloudStore</h1>
</div>
<h2>Home page</h2>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> !</p>
      <li><a href="products.php">All Products</a></li>
      <li><a href="personal.php">My Store</a></li>
      <li><a href="favourites.php">My Favourites</a></li>
      <p style="color: teal;"> CloudStore gives you the ability to advertise your products along with products from other sellers. Each user can view all available products and see the contact information of the seller to discuss how they want to proceed with the purchase.</p>
      <p style="color: white;"> Have fun using CloudStore!</p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
		
</body>
</html>