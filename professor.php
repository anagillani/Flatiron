<?php
	session_start();
	if($_SESSION['type'] != 'P' || $_SESSION['type' != 'D']) {
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Flat Iron</title>
	<link rel="icon" href="logo.png" type="image/gif">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<!-- Our Custom CSS -->
	<link rel="stylesheet" href="sidebar_style.css">

		<!-- Font Awesome JS -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

	<style>  	
  	html,body{
  		height: 100%;
  	}

     .wrapper{
      background-image: url('logo.png');
      background-size: 250px;
  	  background-position: center;
  	  background-repeat: no-repeat;
    }

    .hide{
    	background-size: 0;
    }
	</style>

</head>

<body>
	<div class="wrapper" >
		<!-- Sidebar  -->
		<nav id="sidebar">
			<div class="sidebar-header">
				<h3><center>Professor's<br>Menu<center></h3>
			</div>

			<ul class="list-unstyled components">                
				<li>
					<a id = "creater">Create Question</a>
				</li>
			 
				<li>
					<a id="CQSet">Create Question Set</a>
				</li>
				<li>
					<a id ="gradeList">Check Student Progress</a>
				</li>
			</ul>

		</nav>

		<!-- Page Content  -->
		<div id="content">

			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">

					<button type="button" id="sidebarCollapse" class="btn btn-info">
						<i class="fas fa-align-left"></i>
						<span>Show/Hide Menu</span>
					</button>
					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fas fa-align-justify"></i>
					</button>

					<?php
						if(isset($_SESSION['type']) == 'P') {
							echo"<p>Hello ".$_SESSION['name'].",</p>";
						}
					?>

					<!-- change the php file name after creating a php file for logout-->
					<form action = "registration.php" method = "POST">
						<button type="submit" class="btn btn-info" name="logout">
							Log out
						</button>
					</form>
				</div>
			</nav>
			 <!--hidden items-->
			 <!--fill in names for each input and label for="" according to the database values-->

			<!-- Question Set -->
			<!-- <form action = "profDB.php" method = "POST" id="showCQSet" style="display: none">
				
			</form> -->

			<!-- test -->
			<div id="showCQSet" style="display: none">
				<?php
					require('db.php');

					$sql = "SELECT question_id, title, question_type, content, answer FROM question ORDER BY question_id";
					$result = mysqli_query($db, $sql);
					$qst = mysqli_fetch_all($result, MYSQLI_NUM);
					$_SESSION['questionCount'] = count($qst);

					mysql_close($db);

					$st = "<form action='profDB.php' method='POST'>";
					$st = $st. "<input type='text' name='qSetTitle' placeholder='Enter a title for the set' required><br>";
					$st = $st. " Now select all the questions you want in to be placed in the question set<br><br>";

					for ($x = 0; $x < count($qst); $x++) {

						$id = $qst[$x][0];
						$ttl = $qst[$x][1];
						$qT = $qst[$x][2];
						$qC = $qst[$x][3];
						$qA = $qst[$x][4];

						$qSet = "qSet".$x;
						$qSetP = "qSetP".$x;

						$st = $st. "<div class='form-check'>";
						$st = $st. "<input class='form-check-input' type='checkbox' id=$qSet name=$qSet value=$id>";
						$st = $st. "<label class='form-check-label' for=$qSet> Question title: $ttl <br>  Question type: $qT <br> Question: $qC<br> Answer: $qA </label><br>";
						$st = $st. "<input type='text' name=$qSetP placeholder='Enter points for this question'><br><br>";
						$st = $st. "</div>";
					}

					$st = $st. "<center><input class='btn btn-primary' type='submit' name='qSetSub' value='Submit'><center>";
					$st = $st. "</form>";

					echo($st);
				?>
			</div>

			<!-- Creater -->
			<form  action = "profDB.php" method = "POST" id="show_creater" style="display: none">
				<div class="form-group row">
					<label for="" class="col-sm-2 col-form-label">Enter Title</label> 
					<div class="col-sm-10"> 
						<input class="form-control form-control-lg" type="text" name="xTitle" placeholder="Ex: Chapter 4 (Network)" required>
					</div>
				</div>

				<!-- <div class="form-group row">
					<label for="" class="col-sm-2 col-form-label">Select Question Type</label> 
					<div class="col-sm-10"> 
						<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
							<option selected>Choose...</option>
							<option value="1" name="xMC">Multiple Choice Question</option required>
							<option value="2" name="xWord">One word/sentence/number answer</option required>
							</select>             
					 </div>
				</div> -->

				<div class="form-group row">
					<label for="" class="col-sm-2 col-form-label">Enter Question Type</label> 
					<div class="col-sm-10"> 
						<input class='form-control form-control-lg' type="text" name="xQType" placeholder="Ex: m (for MCQ) OR w (for word/sentence etc)" required>
					</div>
				</div>

				<div class="form-group row">
					<label for="" class="col-sm-2 col-form-label">Enter Question</label> 
					<div class="col-sm-10"> 
						<input class="form-control form-control-lg" type="text" name="xQuestion" placeholder="Ex: What is IPv4?" required>
					</div>
				</div>

				<div class="form-group row">
					<label for="" class="col-sm-2 col-form-label">Enter Answer</label> 
					<div class="col-sm-10"> 
						<input class="form-control form-control-lg" type="text" name="xAnswer" placeholder="For MCQ, separate with coma & mark correct answer beginning with * Ex: a, b, *c" required>
					</div>
				</div>

				<!-- <div class="form-group row">
					<label for="" class="col-sm-2 col-form-label">Enter points</label> 
					<div class="col-sm-10"> 
						<input class="form-control form-control-lg" type="text" name="" placeholder="Question " required>
					</div>
				</div> -->

				<center><input class="btn btn-primary" type="submit" name="qSub" value="Submit"></center>

			</form>

			<div id="grades" style="display: none">

				<?php
				require("db.php");

				//----------------View All Student Grades--------------------------------------------
				$query = "SELECT user_id, first_name, last_name FROM appuser au WHERE user_type = 'S'";
				$result = mysqli_query($db, $query);
				$studList = mysqli_fetch_all($result);
				// echo json_encode($studList);

				$query = "SELECT questionset_id, title FROM questionset";
				$result = mysqli_query($db, $query);
				$examList = mysqli_fetch_all($result);
				// echo json_encode($examList);

				$st = "<div class='container-fluid'>";
				for($student=0; $student<count($studList); $student++) {

					$id = $studList[$student][0];
					$name = $studList[$student][1]." ".$studList[$student][2];

					$st=$st. "<div class='row'>"; 
					$st=$st. "<div class='col-md-4' style='border: 1px; border-style: double; border-radius: 2%; padding: 1.5%; margin: 2%;background-color:  #DBF3FA;'>";

					$st=$st. "<div class='row'>"; 
					$st=$st. "<div class='col-md-12'>";
					$st=$st. "<p><center>Student's Name: $name</center></p>";
					$st=$st. "</div>";
					$st=$st. "</div>";

					for($exam=0; $exam<count($examList); $exam++) {

						$examID = $examList[$exam][0];
						$examTitle = $examList[$exam][1];

						$st=$st. "<div class='row' style='border: 1px;  border-style: solid; border-radius: 2%; padding: 2%; margin: 2%; background-color: white;'>"; 
					
						$st=$st. "<p><div class='text-center'>$examTitle</div><br>";

						$query = "SELECT sum(points) FROM questionset_question WHERE questionset_id = '$examID'";
						$result = mysqli_query($db, $query);
						$totalExamPoints = mysqli_fetch_all($result);
						$totalExamPoints = $totalExamPoints[0][0];
						// echo ($totalExamPoints);
						
						$st=$st. "Total Points: $totalExamPoints<br>";

						// get question list for exam
						$query = "SELECT question_id, points FROM questionset_question WHERE questionset_id = '$examID'";
						$result = mysqli_query($db, $query);
						$questionList = mysqli_fetch_all($result);
						// echo json_encode($questionList);

						$sum = 0;
						$x = 0;
						for($ans=0; $ans<count($questionList); $ans++) {

							$qID = $questionList[$ans][0];
							$points = $questionList[$ans][1];

							// get student answers for exam and compare answer
							$query = "SELECT answer FROM student_answers WHERE student_id = '$id'AND questionset_id = '$examID' AND question_id = '$qID'";
							$result = mysqli_query($db, $query);
							$answer = mysqli_fetch_all($result);
							$answer = $answer[0][0];
							// echo $answer;

							// if correct then get point from qsq for that question else zero
							$query = "SELECT answer FROM question WHERE question_id = '$qID' AND answer = '$answer'";
							$result = mysqli_query($db, $query);
							$qA = mysqli_fetch_all($result);
							$qA = $qA[0][0];

							if(!empty($qA)) {
								$sum = $sum + $points;
							}
							if(!is_null($answer)) {
								$x++;
							}
						}
						if($x > 0)
							$st=$st. "Student Scored: $sum</p>";
						else
							$st=$st. "Student Scored: (Not Taken)</p>";
						$st=$st. "</div>"; 
					
					}
					$st=$st. "</div>";
					$st=$st. "</div>";
				}
				$st=$st. "</div>";
				echo $st;

				mysql_close($db)
				?>
			</div>
	</div>
		</div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- Popper.JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<!-- Bootstrap JS -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

		<script type="text/javascript">
			$(document).ready(function () {
				$('#sidebarCollapse').on('click', function () {
					$('#sidebar').toggleClass('active');
				});
			});
		</script>

		<script type="text/javascript">
			$(document).ready(function () {
			 	$('#creater').click(function(){
					$('#show_creater').toggle();
					$('#grades').hide();
					$('#showCQSet').hide();
					$('.wrapper').toggleClass('hide');
					$('.wrapper').css('background-size','0px');

				});
			});

		</script>

		<script type="text/javascript">
			$(document).ready(function () {
				$('#CQSet').click(function() {
					$('#showCQSet').toggle();
					$('#grades').hide();
					$('#show_creater').hide();
					$('.wrapper').toggleClass('hide');
					$('.wrapper').css('background-size','0px');

				});
			});
		</script>

		<script type="text/javascript">
			$(document).ready(function () {
			 	$('#gradeList').click(function(){
					$('#grades').toggle();
					$('#show_creater').hide();
					$('#showCQSet').hide();
					$('.wrapper').css('background-size','0px');
				});
			});
		</script>
</body>
</html>