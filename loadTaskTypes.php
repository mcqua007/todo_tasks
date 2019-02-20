
<?php
 include("includes/config.php");
include("includes/loadDom.php");



if(isset($_GET['loadId']) && isset($_GET['typeLoad'])){

     $loadId = $_GET['loadId'];
     $typeLoad = $_GET['typeLoad'];

      $query = "SELECT * FROM tasks WHERE " . $typeLoad . "=" . $loadId;

           loadTasks($con, $query);


          if($typeLoad == "project_id"){
            $query2 = mysqli_query($con, "SELECT title FROM projects WHERE id = '$loadId'");

             while($row = mysqli_fetch_array($query2)){
              ?>
              <div class="row">
                <div class="title" style="font-size:25px; margin-left:25px;float:left; color: #000; font-weight:bold;">
                  <?php echo $row['title']; ?>
                </div>

              </div>

              <?php
             }
          }
          else if($typeLoad == "user_id"){

            ?>
            <div class="row">
              <div class="title" style="font-size:25px; margin-left:25px;float:left; color: #000; font-weight:bold;">
                View All Tasks
              </div>
            </div>
            <?php
          }

    }
  else{ echo "Failed!";}

 ?>
   <hr />
    <div class="row" id="todoList" style="margin-top:20px; margin-bottom:20px;" data-project-id="<?php echo $loadId; ?>">
    </div>
