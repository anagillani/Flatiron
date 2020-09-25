<?php
	session_start();
	if($_SESSION['type'] != 'S' || $_SESSION['type' != 'D']) {
		header('Location: login.php');
	}
	require('db.php');

	$stdID = $_SESSION['id'];
	$examSubButtons = $_SESSION['examSubButtons'];

	// $arr = explode(" ", $examSubButtons[0]);
	// for($x=0; $x<count($arr); $x++) {
	// 	echo("<p>$arr[$x]</p>");
	// }

	for($x=0; $x<count($examSubButtons); $x++) {
		$examBtn = $examSubButtons[$x];

		// echo ("<p>$examBtn</p>");
		if(isset($_POST[$examBtn])) {

			$arr = explode("_", $examBtn);
			$qSetID = $arr[0];

			// echo ("<p>Found $qSetID</p>");

			for($y=1; $y<count($arr); $y++) {

				$ansID = "ansID".$arr[$y];

				// echo("<p><br>Hello $stdID<br>qSetID<br>$ansID<br><br></p>");

				if(isset($_POST[$ansID])) {

					$ans = $_POST[$ansID];
					$qID = $arr[$y];

					// echo("<p><br>Student ID: $stdID<br>Question Set: $qSetID<br>$qID<br>$ansID<br>$ans<br><br></p>");

					$query = "INSERT INTO student_answers (student_id, questionset_id, question_id, answer) VALUES ('$stdID', '$qSetID', '$qID', '$ans')";
					mysqli_query($db, $query);
				}
			}
			break;
		}
	}

	header('Location: student.php');
	mysqli_close($db);
?>