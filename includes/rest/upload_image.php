<?php

include("../config.php");

    $errors = array();      // array to hold validation errors
    $data = array();      // array to pass back data

    //ommented out until image is realted to task id
    //if (!isset($_POST['taskId'])){
    //  $errors['taskId'] = 'Task Id is required.';
    //}
    if(!isset($_FILES['file'])){
       $errors['image'] = 'An image is required.';
    }
    if(!isset($_POST['taskId'])){
       $errors['task_id'] = 'A task id is required.';
    }

// if there are any errors in errors array, return a success boolean of false
    if ( !empty($errors)) {

        // if there are items in errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

           extract($_POST);

             $name       = $_FILES['file']['name'];
             $temp_name  = $_FILES['file']['tmp_name'];

       if(isset($name)){
           if(!empty($name)){
               $location = '../../assets/uploaded_images/';
               $TargetPath = "/assets/uploaded_images/".$name;
                     if(move_uploaded_file($temp_name, $location.$name)){
                                  $data['success'] = true;
                                  $data['message'] = 'Success!';
                                  $data['upload'] = 'File uploaded successfully';
                                  $data['file_path'] = $TargetPath;
                                  $data['file_name'] = $name;

                            $taskId = $_POST['taskId'];

                            $QueryInsertFile="INSERT INTO images VALUES('', '$TargetPath', '$taskId', '')";
                            mysqli_query($con, $QueryInsertFile);
                     }
                     else{
                        $errors['upload'] = 'The file did not uploaded properly!';
                        $data['errors']  = $errors;
                     }
             }

      }

}

// return all our data to an AJAX call
echo json_encode($data);

?>
