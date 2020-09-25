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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flat Iron</title>
  <link rel="icon" href="logo.png" type="image/gif">


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>  	
  	html,body{
  		height: 100%;
  	}

     body{
      background-image: url('home_bg.jpg');
      background-size: cover;
  	  background-position: center;
  	  background-repeat: no-repeat;
    }

    h1{
        top-margin: 10%;
        padding-bottom: 20px; 
        color: #000000;
        text-align: center;
     }
     p{
        color: #f9f9f9;
        text-align: center;
     }

     #globe{
        height: 150px;
        width: 150px; 
        border-radius:70px;
     }
     
  </style>


</head>
<body>
   <!-- NAVBAR BEGINS HERE-->
   <?php include("navbar.html"); ?>

   <h1> Flat Iron<br>
   Welcome to the platform of learning</h1>
   <p>Join today and become a part of our family <br><br>
   <img id ="globe" src="globe.jpg" >
   </p>
   
</html>
</body>