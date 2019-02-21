<?php

include("../config.php");

    $errors = array();      // array to hold validation errors
    $data = array();      // array to pass back data



if(!isset($_FILES['file'])){
   $errors['image'] = 'An file is required.';
}
if(!isset($_POST['taskId'])){
   $errors['task_id'] = 'A task id is required.';
}

$file_type = $_FILES['file']['type']; //get file type and save for checking



//=========================================================
//  CHOOSE PATH WHETHER ITS AN IMAGE OR FILE
//=========================================================

//switch ($file_type) {

//=========================================================
//  FILE PATH - IF FILE TYPE IS A FILE GO THORUGH THIS
//=========================================================

/*
case ($file_type == "text/rtf" || $file_type == "text/plain"):

     //CHECKING TYPE IS A .rtf or .txt

        //verifying the content of the uploaded file
        //verifying the content of the uploaded file

        $verifyFile = getimagesize($_FILES['file']['tmp_name']);

          if($verifyFile['mime'] != 'text/rtf' && $verifyFile['mime'] != 'text/plain') {
            $errors['file_type_error'] = true;
            $errors['mime'] = $verifyFile;
            $errors['file_type'] = "Only .txt and .rtf format are allowed!";
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
                   $location = '../../assets/uploaded_files/';
                   $TargetPath = "/assets/uploaded_files/".$name;
                         if(move_uploaded_file($temp_name, $location.$name)){
                                      $data['success'] = true;
                                      $data['message'] = 'Success!';
                                      $data['upload'] = 'File uploaded successfully';
                                      $data['file_path'] = $TargetPath;
                                      $data['file_name'] = $name;
                                      $data['type'] = $_FILES['file']['type'];

                                $taskId = $_POST['taskId'];

                                $QueryInsertFile="INSERT INTO files VALUES('', '$TargetPath', '$taskId', '')";
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

        break; */

//=========================================================
//  IMAGE PATH - IF FILE TYPE IS IMAGE GO THORUGH THIS
//=========================================================

    //case ($file_type == "image/png" || $file_type == "image/jpeg"):


     //CHECKING TYPE IS A JPG OR PNG,MAKING SURE IT IS AN IMAGE

        //checking content header type

        if($_FILES['file']['type'] != "image/png" && $_FILES['file']['type'] != "image/jpeg") {
         $errors['file_type_error'] = true;
         $errors['file_type'] = "Only PNG and JPG format are allowed!";
         $data['errors']  = $errors;
        }

        //verifying the content of the uploaded file

        $verifyimg = getimagesize($_FILES['file']['tmp_name']);

          $data['mime'] = $verifyimg['mime'];

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
                 //check errors
                 $data['file_name'] = $name;
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

                                $QueryInsertFile="INSERT INTO images VALUES(NULL, '$TargetPath', '$taskId', NULL)";
                                mysqli_query($con, $QueryInsertFile);
                                //checking errors
                                $data['sql_error'] = mysqli_error($con);

                         }
                         else{
                            $errors['upload_error'] = true;
                            $errors['upload'] = 'The file did not uploaded properly!';
                            $data['errors']  = $errors;
                         }
                 }

           }
        }

      //  break;
    //default:
        $data['success'] = false;
        $errors['file_type_error'] = true;
        $errors['file_type'] = "You are not uploading the an allowed file type";
        $data['errors']  = $errors;
//}
// return all our data to an AJAX call
echo json_encode($data);

?>
