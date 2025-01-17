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

    if (empty($_POST['title']))
        $errors['title'] = 'Proejct title is required.';

    if (empty($_POST['type']))
        $errors['type'] = 'Type of project is required.';

    // if type is team then make sure team is not empty
    if($_POST['type'] == "team"){
      if (empty($_POST['team']))
          $errors['team'] = 'Team is required if team project.';

     }

   // if description is set assign it a variable if not assign it an empty string
    if (empty($_POST['description'])){
      $description =  "";
    }else{
      $description =  $_POST['description'];
    }




// return a response ===========================================================

// if there are any errors in errors array, return a success boolean of false
    if (!empty($errors)) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process the form, then return a message

      $title = $_POST['title'];
      $type = $_POST['type'];

      $date = date("Y-m-d H:i:s");




      $projectQuery = mysqli_query($con, "INSERT INTO projects VALUES(NULL, '$title', '$description','$user_id', '0', '$date', '0')");
			$lastId = mysqli_insert_id($con);

			if($projectQuery == false) {
          $data['sql_error'] = "Query failed: " . mysqli_error($con);
      }


     //if type of project is team then insert into teamProjects table else insert into userProjects table
      if($_POST['type'] == "team"){
         $team_id = $_POST['team'];
         $projectTeamQuery = mysqli_query($con, "INSERT INTO teamProjects VALUES(NULL, '$team_id', '$lastId')");
      }
      else if($_POST['type'] == "personal"){
        $projectTeamQuery = mysqli_query($con, "INSERT INTO userProjects VALUES(NULL, '$user_id', '$lastId')");
      }

      $getProject = mysqli_query($con, "SELECT id, title FROM projects WHERE id ='$lastId'");

			while($row = mysqli_fetch_array($getProject)){
				$project['id'] = $row['id'];
				$project['title'] = $row['title'];

			}

      // show a message of success and provide a true success variable
      $data['success'] = true;
      $data['message'] = 'Success!';
      $data['projectId'] = $lastId;
			$data['project'] = $project;
      $data['team'] = $_POST['type'];
			if($_POST['type'] == "team"){
				$data['teamId'] = $team_id;
			}

    }

    // return all our data to an AJAX call
    echo json_encode($data);
