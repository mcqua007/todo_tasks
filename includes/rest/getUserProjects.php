<?php

include("../config.php");

$data = array();

if(isset($_POST['userId'])){

  $userId = $_POST['userId'];

  $user_projects_query = mysqli_query($con, "SELECT title, t1.id FROM projects t1 INNER JOIN userProjects t2 ON t1.id = t2.project_id WHERE t2.user_id = $userId");

  $data = array();

  $i = 0;

   while($row = mysqli_fetch_array($user_projects_query )){

      $array1[] = array(
        "id" => $row['id'],
        "title" => $row['title']
      );

  }
  $data['success'] = true;
  $data['projects'] = $array1;

}
else{
  $data['success'] = false;
}


echo json_encode($data);
?>
