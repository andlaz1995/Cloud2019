<?php include('server.php') ?>
<!DOCTYPE html>
<?php
if (isset($_SESSION['username'])) {
    header('location: index.php');
  }
  ?>
<html>
<head>
  <h1>CloudStore</h1>
  <title>Login</title>
  <style>
<?php include 'css.css'; ?>
</style>
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" placeholder="username" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" placeholder:"password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>