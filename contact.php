
<!DOCTYPE html>
<html lang ="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>About Us</title>
	<link rel="icon" href="logo.png" type="image/gif">

 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<style>
		h1{
			text-align: center;
		}

		p{
			text-align: center;
			font-family: serif;
			font-size: 25px;

		}

		html,body{
  			height: 100%;
  		}
		
		body{
			background-image: url(bubbles.png); 
			background-size: cover;
  	  		background-position: center;
  	  		background-repeat: no-repeat;
		}

		h2{
			font-size: 20px;
			padding-top: 5px;
			padding-left: 0px;
			color: white;
		}
		#boxtext{
			color: white;
		}

		#button{
			border-radius: 30px; 
			background-color: blue;
			color: white
		}

		
	</style>
</head>

<body>
	 <?php include("navbar.html"); ?>

	<h1> About Us </h1>
	<p>
		Flat iron is an interative learning platform that is helping<br>
		millions of students to achieve better grades. It helps students<br>
		to learn better via tesing questions provided for each module.
	</p>
	<h1> Meet our Team <h1>

	<div class ="container">
      <div class="row">

        <div class="col-lg-3 col-md-offset-2" style="padding: 20px; background-color: black; border-radius: 15%;" >

		<h2> Ana Gillani </h2>
		<p id="boxtext">
			I'm currently a student at Queens college pursuing
			Bachelor's in computer science. I've worked on designing the website and
			the front end programming.<br><br>
			<center><button type = "button" class="btn btn-email" id ="button"><a href= "mailto:ana.gillani53@qmail.cuny.edu">Contact me</a></button></center>

		</p>
		</div>


      <div class ="col-lg-3 col-md-offset-2" style="padding: 20px; background-color: black; border-radius: 15%" >

		<h2> Mohammad R. Hossain</h2>
		<p id="boxtext">
			I'm currently a student at Queens college pursuing
			Bachelor's in computer science. I'm the database designer and 
			server-side programmer for flat iron. <br><br><br>
			<center><button type = "button" class="btn btn-email" id="button"><a href= "mailto:mailto:mohammad.hossain123@qmail.cuny.edu">Contact me</a></button></center>

		</p>


		</div>
	</div>
</div>

</body>
</html>