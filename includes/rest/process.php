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

    if (!isset($_POST['userId']))
            $errors['userId'] = 'User Id is required.';

    if (!isset($_POST['projectId']))
            $errors['projectId'] = 'Project Id is required.';



// return a response ===========================================================

// if there are any errors in errors array, return a success boolean of false
    if (!empty($errors)) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process the orm, then return a message

      $assigned =  $_POST['assigned'];
      $severity = $_POST['severity'];
      $description =  $_POST['description'];
      $title = $_POST['title'];
      $user_id = $_POST['userId'];
      $project_id = $_POST['projectId'];
      $date = date("Y-m-d H:i:s");

      $taskQuery = mysqli_query($con, "INSERT INTO tasks VALUES(NULL , '$title', '$description', '$assigned', '$severity', '1', '$project_id', '0', '$user_id', '$date')");
      $getIdQuery = mysqli_query($con, "SELECT * FROM tasks");

      if($taskQuery === false) {
          $data['sql_error'] = "Query failed: " . mysql_error($con);
      }

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
