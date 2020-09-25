<?php

if(is_null($_POST['prof']) || is_null($_POST['student'])) {
    header('Location: index.php');
}

require('db.php');

//Login users


$email = $_POST['email'] ;
$password = $_POST['password'];
$site = "signup.php";


//move this to a different php file
if(isset($_POST['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}
                                        

if(isset($_POST['login']) )

 {
    $site = "login.php";

    $errors = array() ;



    if( empty($email))

    {

        array_push($errors , "Email is required" ) ;

    }

    if( empty($password))

    {

        array_push($errors , "Password is required" ) ;

    }

    if( count($errors) == 0 )

    {

        // $password = md5($password) ; //  not used because database pass size limitations

        $query = "Select * from appuser where email = '$email' AND password = '$password' " ;

        $results = mysqli_query($db , $query) ;


        // all questions for creating question set
        // $query = "Select * from question";

        // $questions = mysql_query($db, $query);


        if( mysqli_num_rows($results) ) 

        {
            $user = mysqli_fetch_assoc($results) ;

            session_start();

            // $_SESSION['email'] = $email ;

            $_SESSION['id'] = $user['user_id'];

            $_SESSION['name'] = $user['first_name'];
            $_SESSION['lName'] = $user['last_name'];

            $_SESSION['type'] = $user['user_type'];

            // $_SESSION['numOfQuestions'] = mysqli_num_rows($questions);

            // $_SESSION['quest'] = mysqli_fetch_array($questions);


            $sendTo = "developer.php";
            if($user['user_type'] == "P")
                $sendTo = "professor.php";
            if($user['user_type'] == "S")
                $sendTo = "student.php";


            // echo "You are now logged in. Thank you :)" ;

            header( "location: $sendTo" ) ;

        }

        else

        {

            array_push($errors , "Wrong email/Password combination. Please try again." ) ;

        }

    }

mysqli_close($db);

 }



 else



 {



$errors = array() ;



//register users

$confirmpassword = $_POST['confirmpassword'] ;
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$user_type='S';
if(isset($_POST['prof']))
    $user_type='P';



//form validation



if( empty($first_name) )

{

    array_push( $errors , "First name is required") ;

} 

if( empty($last_name) )

{

    array_push( $errors , "Last name is required") ;

} 


if( empty($email) )

{

    array_push($errors , "email is required") ;

} 



if( empty($password))

{

    array_push($errors , "Password is required") ;

} 



if( $password != $confirmpassword )

{

    array_push($errors , "Password do not match" ) ;

}



//check database for existing user with same username

$user_check_query = "Select * from appuser where email = '$email' LIMIT 1" ;



$results = mysqli_query( $db , $user_check_query ) ;

$user = mysqli_fetch_assoc($results) ;





if($user)

{

    if($user["email"] === $email)

    {

        array_push($errors , "This email is already registered" ) ;

    }

}



//Register user if no errors



if( count($errors) == 0 )

{

    // $password = md5($password) ; //This will encrypt password (also messes up database character limit)


    $query = "INSERT INTO appuser (email, password, first_name, last_name, user_type ) VALUES ( '$email' , '$password' , '$first_name', '$last_name', '$user_type')" ;

    mysqli_query($db , $query );

    // session_start();

    // $_SESSION['email'] = $email ;

    // $_SESSION['id'] = $user['user_id'];

    // $_SESSION['type'] = $user['user_type'];

    // $_SESSION['success'] = "You are now signed Up" ;


    header( 'location: login.php' ) ;

    mysqli_close($db);

}

 

}



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

    