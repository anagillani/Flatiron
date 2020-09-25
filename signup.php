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
  <title>Signup Page</title>
  <link rel="icon" href="logo.png" type="image/gif">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>
    html,body{
      height: 100%;
    }
/*    https://wallpaperplay.com/walls/full/9/b/4/162448.jpg
*/    body{
      background-image: url('login_bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: white;
    }

    input[type=text], input[type=password], input[type="email"] {
      margin: 5px 0 10px 0;

    }
  </style>

</head>


<body>
  <?php include("navbar.html"); ?>
  
   <center><h3>Join today <br> and enter the World of Learning.</h3></center>

   <div class ="container">
      <div class="row">

        <div class="col-md-4 col-md-offset-1" style="padding: 10px; background-color: black; border-radius: 15%;" >

        <form action = "registration.php" method = "POST" >

        <h2 style="text-align: center"> Instructor Signup </h2>

        <center><img src="instructor.jpg" alt="professor" height="100" width="100" style="border-radius: 25%"></center> <br>

        <input class="form-control" type="text" name="first_name" placeholder="First Name" required>

        <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>

        <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>

        <input class="form-control" type="password" name="password" id = "password" placeholder="Password" required>

        <input class="form-control" type="password" name="confirmpassword" id = "confirmpassword" placeholder="ConfirmPassword" onChange = "checkPasswordMatch();" required >

        <center><button class="btn btn-primary" type="submit" name = "prof" style="border-radius:30px">Register</button></center>
        
        </form>

      </div>    

        
      <div class ="col-md-4 col-md-offset-2" style="padding: 10px; background-color: black; border-radius: 15%" >

       <form action = "registration.php" method = "POST" >

        <h2 style="text-align: center;"> Student Signup </h2>

        <center><img src="student.jpg" alt="student" height="100" width="100" style="border-radius: 25%"></center> <br>

        <input class="form-control" type="text" name="first_name" placeholder="First Name" required>

        <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>

        <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>

        <input class="form-control" type="password" name="password" id = "password" placeholder="Password" required>

        <input class="form-control" type="password" name="confirmpassword" id = "confirmpassword" placeholder="ConfirmPassword" onChange = "checkPasswordMatch();" required >

        <center><button class="btn btn-primary" type="submit" name = "student" style="border-radius: 30px" >Register</button></center>

      </form>  

      </div>

    </div>  
  </div>

</body>

</html>