<?php

include("../config.php");


$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


// if any of these variables don't exist, add an error to $errors array

    if (empty($_POST['teamId']))
        $errors['teamId'] = 'Team Id is required.';



// return a response ===========================================================

// if there are any errors in errors array, return a success boolean of false
    if ( !empty($errors)) {

        // if there are items in errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process, then return a message


      $teamId = $_POST['teamId'];


      //$taskQuery = mysqli_query($con, "DELETE FROM tasks WHERE project_id = '$projectId'");
      $deleteTramQuery = mysqli_query($con, "DELETE FROM teams WHERE id = '$teamId'");

      // show a message of success and provide a true success variable
      $data['success'] = true;
      $data['message'] = 'Success!';
  }

    // return all our data to an AJAX call
    echo json_encode($data);