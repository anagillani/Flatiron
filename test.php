<?php
	
	session_start();

	require('db.php');

	// $query = "SELECT sum(points) FROM question q, questionset qs, questionset_question qsq, student_answers sa WHERE q.question_id = qsq.question_id AND sa.question_id = q.question_id AND qsq.questionset_id = qs.questionset_id AND qsq.questionset_id = sa.questionset_id AND sa.answer = q.answer";

	// $query = "SELECT q.question_id, q.answer, qsq.points FROM question q, questionset_question qsq WHERE qsq.questionset_id = '1'";
	// $result = mysqli_query($db, $query);
	// echo json_encode(mysqli_fetch_all($result));

	$query = "SELECT * FROM student_answers";
	$result = mysqli_query($db, $query);
	$studAnsList = mysqli_fetch_all($result);
	// echo json_encode($studAnsList);


	//------------------------------------------------------------------------------------
	$query = "SELECT user_id, first_name, last_name FROM appuser au WHERE user_type = 'S'";
	$result = mysqli_query($db, $query);
	$studList = mysqli_fetch_all($result);
	// echo json_encode($studList);

	$query = "SELECT questionset_id, title FROM questionset";
	$result = mysqli_query($db, $query);
	$examList = mysqli_fetch_all($result);
	// echo json_encode($examList);

	$st = "<div>";
	for($student=0; $student<count($studList); $student++) {

		$id = $studList[$student][0];
		$name = $studList[$student][1]." ".$studList[$student][2];

		$st=$st. "<div>"; 
		$st=$st. "<p>Student's Name: $name</p>";

		for($exam=0; $exam<count($examList); $exam++) {

			$examID = $examList[$exam][0];
			$examTitle = $examList[$exam][1];

			$st=$st. "<p>Exam/Quiz Title: $examTitle</p>";

			$query = "SELECT sum(points) FROM questionset_question WHERE questionset_id = '$examID'";
			$result = mysqli_query($db, $query);
			$totalExamPoints = mysqli_fetch_all($result);
			$totalExamPoints = $totalExamPoints[0][0];
			// echo ($totalExamPoints);
			
			$st=$st. "<p>Total Available Points: $totalExamPoints</p>";

			$query = "SELECT count(q.question_id) FROM questionset_question qs, student_answers sa, question q, questionset s WHERE sa.student_id='$id' AND qs.questionset_id = '$examID' AND sa.answer= q.answer AND q.question_id=qs.question_id AND qs.question_id=sa.question_id AND s.questionset_id='$examID'AND s.title='$examTitle'" ;
			$result = mysqli_query($db, $query);
			//$studScore=mysqli_fetch_all($result);
			//$studScore=$studScore[0][0];
			echo ($examTitle);
			echo ($id);
			echo($examID);
			echo json_encode(mysqli_fetch_all($result));


			// get question list for exam
			// $query = "SELECT q.question_id, q.answer, qsq.points FROM question q, questionset_question qsq WHERE qsq.questionset_id = '$examID'";
			// $result = mysqli_query($db, $query);
			// echo json_encode(mysqli_fetch_all($result));


			// get student asnwwers for exam
			// compare answer
			// if correct then get point from qsq for that question
			// else zero

			$st=$st. "<p>Student Scored: $studScore</p>";
		}
		$st=$st."-----------------------------------------------";
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