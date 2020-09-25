<?php
  session_start();
  if($_SESSION['type'] == 'P') {
    header('Location: professor.php');
  }
  if($_SESSION['type'] == 'S') {
    header('Location: student.php');
  }
  if($_SESSION['type'] == 'D') {
    header('Location: developer.php');
  }
?>

<!DOCTYPE html>
<html lang ="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
  <link rel="icon" href="logo.png" type="image/gif">

 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  

	<style>
		html,body{
  			height: 100%;
  		}
    	 body{
      		background-image: url('login_bg.jpg');
      		background-size: cover;
  	  		background-position: center;
  	  		background-repeat: no-repeat;
  	  		color: white;
   		 }
   		 input[type=password], input[type="email"] {
    		  margin: 5px 0 22px 0;
    		  color:black; 
    	}
    	button{
    		border-radius:30px;
    		width:100px;
    		padding-top: 5%
    	}


		
	</style>
</head>
	
	<body>
   <?php include("navbar.html"); ?>
   	<center><h1 class="display-3" style="padding:1%; ">Welcome Back</h1></center>
	<div class ="container">
		<div class="col-md-4 col-md-offset-4" style="padding-bottom:15%; padding-left: 5%;padding-right: 5%;  background-color: black; border-radius: 15%;">
			<form action = "registration.php" method = "POST">
				<center><h1 class="display-3" style="padding:5%; padding-bottom:7%;">Login</h1></center>			
				<label for="uname">Username:</label><br>
  				<input class="form-control" type="email" name="email" placeholder="Enter email" style="color: black"><br>
  				<label for="pword">Password:</label><br>
  				<input class="form-control" type="password" id="pword" name="password" placeholder="Enter password"><br>
				<center><button class="btn btn-primary" type="submit" name = "login" value="Login">Login</button></center>  				
  			</form>
		</div>
	</div>
	</body>
</html>
