<?php

include("../config.php");
include("../classes/Account.php");
include("../classes/Constants.php");
include("../classes/User.php");


	$account = new Account($con);



$errors = array();      // array to hold validation errors
$data = array();        // array to pass back data
$project = array();     //used to pass prject data back


if(isset($_SESSION['userLoggedIn'])) {
$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
$username = $userLoggedIn->getUsername();
$user_id = $userLoggedIn->getUserId();
}
else{
  $errors['user'] = 'Could not get user id.';
}

// if any of these variables don't exist, add an error to $errors array

    if (empty($_POST['team_name']))
        $errors['team_name'] = 'Team is required.';
		if (empty($_POST['number']))
		        $errors['num'] = 'Number of membrs is required.';
// return a response ===========================================================

// if there are any errors in errors array, return a success boolean of false
    if (!empty($errors)) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

			$num = $_POST['number'];
			$team_name = $_POST['team_name'];
			$date = date("Y-m-d H:i:s");

			switch($num){

				case 1:

				 $member1 = $_POST['member1'];

				 $teamQuery = mysqli_query($con, "INSERT INTO teams VALUES(NULL, '$team_name', '1', '$date')");
				 $lastId = mysqli_insert_id($con);

				 $getMember1 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member1'");
				 if($getMember1 == true){

						 while($row == mysqli_fetch_array($getMember1)){
							  $memberId1 = $row['id'];
						  }

					  //insert team member 1 into teamUsers table
					  $teamUser1 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId1')");

					 //insert logged in user into teamUsers
					 $teamUserLoggedIn = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$user_id')");
				 }
				 else{
					 $errors['member1'] = 'Team member 1 username is incorrect!';
				 }


				break;

				case 2:

					$member1 = $_POST['member1'];
					$member2 = $_POST['member2'];

					//insert team name to teams
					$teamQuery = mysqli_query($con, "INSERT INTO teams VALUES(NULL, '$team_name', '1', '$date')");
 				  $lastId = mysqli_insert_id($con);

          //MEMBER 1 SECTION
					$getMember1 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member1'");
					if($getMember1 == true){

							while($row = mysqli_fetch_array($getMember1)){
								 $memberId1 = $row['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser1 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId1')");

					}
					 else{
					 	$errors['member1'] = 'Team member 1 username is incorrect!';
						break;
				 	}
					//END MEMBER 1

					//MEMBER 2 SECTION
					$getMember2 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member2'");
					if($getMember2 == true){

							while($row2 = mysqli_fetch_array($getMember2)){
								 $memberId2 = $row2['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser2 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId2')");

						 //insert logged in user into teamUsers
						 $teamUserLoggedIn = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$user_id')");

					}
					 else{
					 	$errors['member2'] = 'Team member 2 username is incorrect!';
						break;
				 	}
					//END MEMBER 2


				break;

				case 3:

					$member1 = $_POST['member1'];
					$member2 = $_POST['member2'];
					$member3 = $_POST['member3'];

					//MEMBER 1 SECTION
					$getMember1 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member1'");
					if($getMember1 == true){

							while($row = mysqli_fetch_array($getMember1)){
								 $memberId1 = $row['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser1 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId1')");

					}
					 else{
						$errors['member1'] = 'Team member 1 username is incorrect!';
						break;
					}
					//END MEMBER 1

					//MEMBER 2 SECTION
					$getMember2 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member2'");
					if($getMember2 == true){

							while($row2 = mysqli_fetch_array($getMember2)){
								 $memberId2 = $row2['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser2 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId2')");

					}
					 else{
						$errors['member2'] = 'Team member 2 username is incorrect!';
						break;
					}
					//END MEMBER 2

					//MEMBER 3 SECTION
					$getMember3 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member3'");
					if($getMember3 == true){

							while($row3 = mysqli_fetch_array($getMember3)){
								 $memberId3 = $row3['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser3 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId3')");

						 //insert logged in user into teamUsers
						 $teamUserLoggedIn = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$user_id')");

					}
					 else{
						$errors['member3'] = 'Team member 3 username is incorrect!';
						break;
					}
					//END MEMBER 3

				break;

				case 4:

					$member1 = $_POST['member1'];
					$member2 = $_POST['member2'];
					$member3 = $_POST['member3'];
					$member4 = $_POST['member4'];


					//MEMBER 1 SECTION
					$getMember1 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member1'");
					if($getMember1 == true){

							while($row == mysqli_fetch_array($getMember1)){
								 $memberId1 = $row['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser1 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId1')");

					}
					 else{
						$errors['member1'] = 'Team member 1 username is incorrect!';
						break;
					}
					//END MEMBER 1

					//MEMBER 2 SECTION
					$getMember2 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member2'");
					if($getMember2 == true){

							while($row2 = mysqli_fetch_array($getMember2)){
								 $memberId2 = $row2['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser2 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId2')");



					}
					 else{
						$errors['member2'] = 'Team member 2 username is incorrect!';
						break;
					}
					//END MEMBER 2

					//MEMBER 3 SECTION
					$getMember3 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member3'");
					if($getMember3 == true){

							while($row3 = mysqli_fetch_array($getMember3)){
								 $memberId3 = $row3['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser3 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId3')");

					}
					 else{
						$errors['member3'] = 'Team member 3 username is incorrect!';
						break;
					}
					//END MEMBER 3

					//MEMBER 4 SECTION
					$getMember4 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member4'");
					if($getMember4 == true){

							while($row4 = mysqli_fetch_array($getMember4)){
								 $memberId4 = $row4['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser4 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId4')");

						 //insert logged in user into teamUsers
						 $teamUserLoggedIn = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$user_id')");

					}
					 else{
						$errors['member4'] = 'Team member 4 username is incorrect!';
						break;
					}
					//END MEMBER 4

				break;

				case 5:

					$member1 = $_POST['member1'];
					$member2 = $_POST['member2'];
					$member3 = $_POST['member3'];
					$member4 = $_POST['member4'];
					$member5 = $_POST['member5'];

					//MEMBER 1 SECTION
					$getMember1 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member1'");
					if($getMember1 == true){

							while($row = mysqli_fetch_array($getMember1)){
								 $memberId1 = $row['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser1 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId1')");

					}
					 else{
						$errors['member1'] = 'Team member 1 username is incorrect!';
						break;
					}
					//END MEMBER 1

					//MEMBER 2 SECTION
					$getMember2 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member2'");
					if($getMember2 == true){

							while($row2 = mysqli_fetch_array($getMember2)){
								 $memberId2 = $row2['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser2 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId2')");

					}
					 else{
						$errors['member2'] = 'Team member 2 username is incorrect!';
						break;
					}
					//END MEMBER 2

					//MEMBER 3 SECTION
					$getMember3 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member3'");
					if($getMember3 == true){

							while($row3 = mysqli_fetch_array($getMember3)){
								 $memberId3 = $row3['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser3 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId3')");

					}
					 else{
						$errors['member3'] = 'Team member 3 username is incorrect!';
						break;
					}
					//END MEMBER 3

					//MEMBER 4 SECTION
					$getMember4 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member4'");
					if($getMember4 == true){

							while($row4 = mysqli_fetch_array($getMember4)){
								 $memberId4 = $row4['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser4 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId4')");

					}
					 else{
						$errors['member4'] = 'Team member 4 username is incorrect!';
						break;
					}
					//END MEMBER 4

					//MEMBER 5 SECTION
					$getMember5 = mysqli_query($con, "SELECT id  FROM users WHERE username ='$member5'");
					if($getMember5 == true){

							while($row5 = mysqli_fetch_array($getMember5)){
								 $memberId5 = $row5['id'];
							 }

						 //insert team member 1 into teamUsers table
						 $teamUser5 = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$memberId5')");

						 //insert logged in user into teamUsers
						 $teamUserLoggedIn = mysqli_query($con, "INSERT INTO teamUsers VALUES(NULL, '$lastId', '$user_id')");

					}
					 else{
						$errors['member5'] = 'Team member 5 username is incorrect!';
						break;
					}
					//END MEMBER 5

				break;

				default:
			  	$errors['switch'] = 'Switch did not work';
			}

			if (!empty($errors)) {
					// if there are items in our errors array, return those errors
					$data['success'] = false;
					$data['errors']  = $errors;
			}else{
				// if there are no errors process form

	      // show a message of success and provide a true success variable
	      $data['success'] = true;
	      $data['message'] = 'Success!';

				$data['team_name'] = $_POST['team_name'];
				$data['team_id'] = $lastId;

			}
    }

    // return all our data to an AJAX call
    echo json_encode($data);
