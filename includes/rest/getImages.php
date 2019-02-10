<?php

include("../config.php");


$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


// if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['taskId']))
        $errors['taskId'] = 'The Task Id is required.';



// return a response ===========================================================

// if there are any errors in our errors array, return a success boolean of false
    if ( !empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process, then return a message



      $taskId = $_POST['taskId'];


      $imageQuery = mysqli_query($con, "SELECT * FROM images  WHERE task_id = '$taskId'");

      $imageData = array();

          while ($row = mysqli_fetch_array($imageQuery)) {

              $imageData[] = $row;

         }
      // show a message of success and provide a true success variable
      $data['success'] = true;
      $data['message'] = 'Success!';
      $data['images'] = $imageData;
  }

    // return all our data to an AJAX call
    echo json_encode($data);
