<?php

include("../config.php");
// process.php

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


// if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['data']))
        $errors['todo'] = 'To do is required.';

    if (empty($_POST['taskId']))
        $errors['taskId'] = 'Id is required.';



// return a response ===========================================================

// if there are any errors in our errors array, return a success boolean of false
    if ( !empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

      $todo= $_POST['data'];
      $taskId = $_POST['taskId'];


      $todoQuery = mysqli_query($con, "INSERT INTO todos VALUES('', '$todo', '$taskId', '1')");
      $getIdQuery = mysqli_query($con, "SELECT * FROM todos");

      // show a message of success and provide a true success variable
      $data['success'] = true;
      $data['message'] = 'Success!';

      while ($row = mysqli_fetch_array($getIdQuery)){
          $data['id'] = $row['id'];
          $data['todo'] = $row['todo'];
          $data['taskId'] = $row['taskId'];
          $data['completed'] = $row['completed'];
      }


    }

    // return all our data to an AJAX call
    echo json_encode($data);
