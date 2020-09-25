<?php
	session_start();
	if($_SESSION['type'] != 'S' || $_SESSION['type' != 'D']) {
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
				<h3><center>Student's<br>Menu<center></h3>
			</div>

			<ul class="list-unstyled components">                
				<li>
					<a id="take_exam">Take exam</a>
				</li>
			 
				<li>
					<a id="view_grade">View My Grades</a>
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
						if(isset($_SESSION['type']) == 'S') {
							echo"<p>Hello ".$_SESSION['name']."</p>";
						}
					?>
					<!-- change the php file name after creating a php file for logout-->
					<form action = "registration.php" method = "POST">
						<button type="submit" class="btn btn-info" name="logout">Log out</button>   
					</form>                 
				</div>
			</nav>


			<div id="view_grade_SHOW" style="display: none">
				<?php
					require("db.php");
					session_start();
					$id = $_SESSION['id'];

					$st = "<div class='container-fluid'>";

					$query = "SELECT questionset_id, title FROM questionset";
					$result = mysqli_query($db, $query);
					$examList = mysqli_fetch_all($result);

					for($exam=0; $exam<count($examList); $exam++) {

						$examID = $examList[$exam][0];
						$examTitle = $examList[$exam][1];

						$st=$st. "<p>$examTitle<br>";

						$query = "SELECT sum(points) FROM questionset_question WHERE questionset_id = '$examID'";
						$result = mysqli_query($db, $query);
						$totalExamPoints = mysqli_fetch_all($result);
						$totalExamPoints = $totalExamPoints[0][0];

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
							$st=$st. "You Scored: $sum</p>";
						else
							$st=$st. "You Scored: (Not Taken)</p>";
					}

					$st = $st. "</div>";

					echo $st;

					mysql_close($db);					
				?>
			</div>

			<div id="take_exam_SHOW" style="display: none">
				<?php
					require('db.php');

					$stdID = $_SESSION['id'];
					$query = "SELECT questionset_id, title FROM questionset WHERE questionset_id NOT IN (SELECT questionset_id FROM student_answers WHERE student_id = '$stdID')";
					$result = mysqli_query($db, $query);
					$toTake = mysqli_fetch_all($result);

					// Display the questions
					$st= "<div class='container'>";

					$submitButtons = array();

					for($x=0; $x<count($toTake); $x++) {

						$toTakeTitle = $toTake[$x][1];
						$toTakeID = $toTake[$x][0];
						$examButton = "".$toTakeID;

						$query = "SELECT question_id FROM questionset_question WHERE questionset_id = '$toTakeID'";
						$result = mysqli_query($db, $query);
						$qList = mysqli_fetch_all($result, MYSQLI_NUM);

						$st=$st. "<div class= row style='border-width: 5px; border-style:double; border-color:blue; border-radius: 5%; padding: 5%; margin:2%; background-color: #F5FCFF;' >";
						$st=$st. "<form action='studDB.php' method='POST'>";
						$st=$st. "<div class='form-group'>";
						$st=$st. "<h4>". $toTakeTitle ."</h4>";

						for($y=0; $y<count($qList); $y++) {

							$qstID = $qList[$y][0];
							$examButton = $examButton. "_" .$qstID;
							$ansID = "ansID".$qstID;

							$query = "SELECT title, question_type, content, answer FROM question WHERE question_id = '$qstID'";
							$result = mysqli_query($db, $query);
							$qst = mysqli_fetch_assoc($result);

							$title = $qst['title'];
							$qType = $qst['question_type'];
							$cont = $qst['content'];
							$ans = $qst['answer'];

							$a=$y+1;
							$st=$st. "<div class='form-group'>";
							$st=$st. "<p style= 'color: black'> Q $a) "; 
							$st=$st. "$title : ";
							$st=$st. "$cont</p>";

							if($qType == "MC") {

								$option;
								$tempArray = explode(",", $ans);

								for($z=0; $z<count($tempArray); $z++) {

									$option = $tempArray[$z];

									if(strpos($option, "*") == true) {
										$correctAns = $ans;
									}

									$option = trim($option, "*");
									$option = trim($option);
									$option = trim($option, "*");

									$st=$st. "<div class= 'form-check' >";

									if(!empty($correctAns)) {
										$st=$st. "<input class='form-check-input' type='checkbox' id=$title name=$ansID value='$correctAns'>";
									}										
									else {
										$st=$st. "<input class='form-check-input' type='checkbox' id=$title name=$ansID value='$option'>";
									}
									$st=$st. "<label class='form-check-label' for=title> $option</label><br>";
									$st=$st. "</div>";								

								}
								$st=$st. "</div>";								

							}
							else {
								$st=$st. "<input class ='form-control' type='text' name=$ansID placeholder='Enter your answer here'><br>";
								$st=$st. "</div>";								

							}
						}

						$st=$st. "<input class='btn btn-primary' type='submit' name=$examButton value='Submit'>";

						array_push($submitButtons, $examButton);

						// echo ("<p>$examButton</p>");

						$st=$st. "</div>";
						$st=$st. "</form>";
						$st=$st. "</div>";
					}
					$st= $st."</div>";

					$_SESSION['examSubButtons'] = $submitButtons;

					echo($st);

					mysqli_close($db);
				?>
			</div>

		</div>		 
	</div>
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
			$('#take_exam').click(function () {
				$('#take_exam_SHOW').toggle();
				$('#view_grade_SHOW').hide();
				$('.wrapper').toggleClass('hide');
				$('.wrapper').css('background-size','0px');
				// $('#sidebarCollapse').click();
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function () {
			$('#view_grade').click(function () {
				$('#take_exam_SHOW').hide();
				$('#view_grade_SHOW').toggle();
				$('.wrapper').toggleClass('hide');
				$('.wrapper').css('background-size','0px');

			});
		});
	</script>
</body>
</html>