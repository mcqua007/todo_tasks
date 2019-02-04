<?php

include("../config.php");
// process.php

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


// if any of these variables don't exist, add an error to $errors array

    if (empty($_POST['title']))
        $errors['title'] = 'Title is required.';

    if (empty($_POST['description']))
        $errors['description'] = 'Description is required.';

    if (empty($_POST['severity']))
            $errors['severity'] = 'Severity is required.';

    if (empty($_POST['assigned']))
                    $errors['assigned'] = 'Person assigned is required.';



// return a response ===========================================================

// if there are any errors in errors array, return a success boolean of false
    if ( !empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process the orm, then return a message

      $assigned =  $_POST['assigned'];
      $severity = $_POST['severity'];
      $description =  $_POST['description'];
      $title = $_POST['title'];

      $taskQuery = mysqli_query($con, "INSERT INTO tasks VALUES('', '$title', '$description', '$assigned', '$severity', '1')");
      $getIdQuery = mysqli_query($con, "SELECT * FROM tasks");

      // show a message of success and provide a true success variable
      $data['success'] = true;
      $data['message'] = 'Success!';

      while ($row = mysqli_fetch_array($getIdQuery)){
          $data['id'] = $row['id'];
          $data['title'] = $row['title'];
          $data['description'] = $row['description'];
          $data['assigned'] = $row['assigned_to'];
          $data['severity'] = $row['severity'];
          $data['open'] = $row['open'];
      }


    }

    // return all our data to an AJAX call
    echo json_encode($data);
