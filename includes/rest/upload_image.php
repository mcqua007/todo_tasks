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
    //CHECKING TYPE IS A JPG OR PNG,MAKING SURE IT IS AN IMAGE
    //=========================================================

    //checking content header type

    if($_FILES['file']['type'] != "image/png" && $_FILES['file']['type'] != "image/jpeg") {
     $errors['file_type_error'] = true;
     $errors['file_type'] = "Only PNG and JPG format are allowed!";
     $data['errors']  = $errors;
    }

    //verifying the content of the uploaded file

    $verifyimg = getimagesize($_FILES['file']['tmp_name']);

      if($verifyimg['mime'] != 'image/png' && $verifyimg['mime'] != 'image/jpeg') {
        $errors['file_type_error'] = true;
        $errors['file_type'] = "Only PNG and JPG format are allowed!";
        $data['errors']  = $errors;
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
                                  $data['type'] = $_FILES['file']['type'];

                            $taskId = $_POST['taskId'];

                            $QueryInsertFile="INSERT INTO images VALUES('', '$TargetPath', '$taskId', '')";
                            mysqli_query($con, $QueryInsertFile);
                     }
                     else{
                        $errors['upload_error'] = true;
                        $errors['upload'] = 'The file did not uploaded properly!';
                        $data['errors']  = $errors;
                     }
             }

      }

}

// return all our data to an AJAX call
echo json_encode($data);

?>
