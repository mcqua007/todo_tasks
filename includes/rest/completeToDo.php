<?php

include("../config.php");
// process.php

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


// if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['todoId']))
        $errors['todoId'] = 'Todo Id is required.';
    if (empty($_POST['completed']))
        $errors['completed'] = 'Completed is required.';




// return a response ===========================================================

// if there are any errors in errors array, return a success boolean of false
    if ( !empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process, then return a message


      $todoId = $_POST['todoId'];
      $completed = $_POST['completed'];


      $todoQuery = mysqli_query($con, "UPDATE todos SET completed = '$completed' WHERE id = '$todoId'");

      // show a message of success and provide a true success variable
      $data['success'] = true;
      $data['message'] = 'Success!';
  }

    // return all our data to an AJAX call
    echo json_encode($data);
