<?php

	session_start();
	if($_SESSION['type'] != 'P' || $_SESSION['type' != 'D']) {
		header('Location: login.php');
	}


	require('db.php');

	$site = "professor.php";


	// Create Questions
	if(isset($_POST['qSub'])) {

		$errors = array();

		$qTitle = $_POST['xTitle'];
		$qType = $_POST['xQType'];

		if($qType != 'm' && $qType != 'w')
			array_push($errors, 'Question Type needs to be either "m" or "w"');
		if($qType == 'm')
			$qType = 'MC';
		if($qType == 'w') 
			$qType = "WA";

		$qQuestion = $_POST['xQuestion'];
		$qAnswer = $_POST['xAnswer'];

		if(empty($qTitle))
			array_push($errors, 'Question Title Required');

		if(empty($qQuestion))
			array_push($errors, 'Question Content Required');

		if(empty($qAnswer))
			array_push($errors, 'Answer to the question is required');


		if(count($errors) == 0) {

			// add question to database
			$query = "INSERT INTO question (title, question_type, content, answer) VALUES ('$qTitle', '$qType', '$qQuestion', '$qAnswer')" ;

	    	mysqli_query($db , $query );

	    	header( "location: professor.php" ) ;
		}
	}

	if(isset($_POST['qSetSub'])) {

		$errors = array();

		$qSetTitle = $_POST['qSetTitle'];
		$query = "SELECT questionset_id FROM questionset WHERE title = '$qSetTitle'";
		$result = mysqli_query($db, $query);

		if(mysqli_num_rows($result) != 0) {
			array_push($errors, "Title: \"".$qSetTitle."\" already exists.");
		}

		mysqli_free_result($result);

		$x = 0; $total = $_SESSION['questionCount'];

		$fine = false;

		while($x < $total) {

			$qS = "qSet".$x;
			$qS = $_POST[$qS];

			$qSP = "qSetP".$x;
			$qSP = $_POST[$qSP];

			if(isset($qS)) {
				$fine = true;
				if(is_null($qSP) || empty($qSP)) {
					array_push($errors, "Points need to be set.");
				}
			}

			$x++;
		}

		if($fine == false) {
			array_push($errors, "Please select atleast one question for this question set.");
		}

		if(count($errors) == 0) {

			$query = "INSERT INTO questionset (title) VALUES ('$qSetTitle')";
			mysqli_query($db, $query);

			$qSetID = "SELECT questionset_id FROM questionset WHERE title = '$qSetTitle'";
			$qSetID = mysqli_query($db, $qSetID);
			$qSetID = mysqli_fetch_assoc($qSetID);
			$qSetID = $qSetID['questionset_id'];

			$x = 0; $total = $_SESSION['questionCount'];

			while($x < $total) {

				$qS = "qSet".$x;
				$qS = $_POST[$qS];

				$qSP = "qSetP".$x;
				$qSP = $_POST[$qSP];

				$query = "INSERT INTO questionset_question (questionset_id, question_id, points) VALUES ('$qSetID', '$qS', '$qSP')";

				mysqli_query($db, $query);

				$x++;
			}
			header( "location: professor.php" ) ;
		}
	}
	mysqli_close($db);
?>

<?php if (is_countable($errors) && count($errors) > 0) : ?>

    <div>

    <?php foreach($errors as $error) : ?>

    <p><?php echo $error ?></p>

    <?php endforeach ?>

    <!--redirect to index.php after 2 seconds-->

    <?php header("Refresh:2; url= '$site'"); ?>

    </div>

    

    <?php endif ?>