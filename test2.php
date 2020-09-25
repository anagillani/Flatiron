<?php
	
	session_start();

	require('db.php');

	// $query = "SELECT sum(points) FROM question q, questionset qs, questionset_question qsq, student_answers sa WHERE q.question_id = qsq.question_id AND sa.question_id = q.question_id AND qsq.questionset_id = qs.questionset_id AND qsq.questionset_id = sa.questionset_id AND sa.answer = q.answer";

	// $query = "SELECT question_id FROM student_answers WHERE student_id = '5'AND questionset_id = '1' AND question_id = '2'";
	// $result = mysqli_query($db, )


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
		$st=$st. "<div class='col-md-4' style='border: 1px; border-style: double; border-radius: 2%; padding: 2%; margin: 2%;'>";
		$st=$st. "<p>Student's Name: $name</p>";

		for($exam=0; $exam<count($examList); $exam++) {

			$examID = $examList[$exam][0];
			$examTitle = $examList[$exam][1];

			if($exam < count($examList)) {
				$st=$st. "-------------------------------";
			}

			$st=$st. "<p>Exam/Quiz Title: $examTitle</p>";

			$query = "SELECT sum(points) FROM questionset_question WHERE questionset_id = '$examID'";
			$result = mysqli_query($db, $query);
			$totalExamPoints = mysqli_fetch_all($result);
			$totalExamPoints = $totalExamPoints[0][0];
			// echo ($totalExamPoints);
			
			$st=$st. "<p>Total Available Points: $totalExamPoints</p>";

			// get question list for exam
			$query = "SELECT question_id, points FROM questionset_question WHERE questionset_id = '$examID'";
			$result = mysqli_query($db, $query);
			$questionList = mysqli_fetch_all($result);
			// echo json_encode($questionList);

			$sum = 0;
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
			}
			$st=$st. "<p>Student Scored: $sum</p>";
		}
		$st=$st. "</div>";
		$st=$st. "</div>";
	}
	$st=$st. "</div>";
	echo $st;

	// Query to select exams/quiz a student needs to take
	// $query = "SELECT questionset_id, title FROM questionset WHERE questionset_id NOT IN (SELECT questionset_id FROM student_answers)";
	// $result = mysqli_query($db, $query);
	// echo json_encode(mysqli_fetch_all($result));
	
	// echo json_encode(mysqli_fetch_all($result));

	//$query = "SELECT a FROM questionset q, student_answers s WHERE s.student_id = '5' AND q.questionset_id != s.questionset_id";
	//$result = mysqli_query($db, $query);
	//echo json_encode(mysqli_fetch_all($result));


	// // get all question set IDs
	// $query = "SELECT questionset_id FROM questionset";
	// $result = mysqli_query($db, $query);
	// $qSetIDarray = mysqli_fetch_all($result, MYSQLI_NUM);
	// $arr = array();
	// for($x=0; $x<count($qSetIDarray); $x++) {
	// 	array_push($arr, $qSetIDarray[$x][0]);
	// }
	// $qSetIDarray = $arr;
	// $stdID = $_SESSION['id'];

	// // get all question sets that the student took
	// $stdID = 5;
	// $query = "SELECT questionset_id FROM student_answers WHERE student_id = '$stdID'";
	// $result = mysqli_query($db, $query);
	// $stdQSetIDarray = mysqli_fetch_all($result, MYSQLI_NUM);
	// $arr = array();
	// for($x=0; $x<count($stdQSetIDarray); $x++) {
	// 	array_push($arr, $stdQSetIDarray[$x][0]);
	// }
	// $stdQSetIDarray = $arr;

	// // find question sets which the student didnt take
	// $arr = array();
	// for($x=0; $x<count($qSetIDarray); $x++) {
	// 	if(!in_array($qSetIDarray[$x], $stdQSetIDarray)){
	// 		array_push($arr, $qSetIDarray[$x]);
	// 	}
	// }
	// $stdQSetIDarray = $arr;

	// echo json_encode($stdQSetIDarray);

	// mysqli_close($db);






	// to test
	//-----------------------
	// $qSetTitle = "EXAM 1";
	// $query = "SELECT questionset_id FROM questionset WHERE title = '$qSetTitle'";
	// if($result = mysqli_query($db, $query)) {
	// 	if(mysqli_num_rows($result) != 0) {
	// 		$result = mysqli_num_rows($result);
	// 		echo ("<p>$result</p>");
	// 	}
	// 	else
	// 		echo("<p>Zero</p>");
	// }





	// to test Qestion Set Title
	//--------------------------
	// $qSetTitle = "TEST 2";
	// echo("<p>$qSetTitle</p>");
	// $qSetQRY = "INSERT INTO questionset (title) VALUES ('$qSetTitle')";
	// mysqli_query($db, $qSetQRY);

	// $qSetID = "SELECT questionset_id FROM questionset WHERE title = '$qSetTitle'";
	// $qSetID = mysqli_query($db, $qSetID);
	// $qSetID = mysqli_fetch_assoc($qSetID);

	// echo json_encode($qSetID);

	// $var = $qSetID['questionset_id'];

	// echo ("<p>$var</p>");

	mysql_close($db);

	// echo("<p>Done</p>");
?>