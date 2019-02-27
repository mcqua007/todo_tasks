
<?php
 include("includes/config.php");
include("includes/handlers/loadDom.php");

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
                <div class="col-12">
                  <div class="title" style="font-size:25px; margin-left:25px;float:left; color: #000; font-weight:bold;">
                    <?php echo $row['title']; ?>
                  </div>
                  <!-- Comment Out For Now <div style="float:right;color: #aaa;font-size: 25px;margin-right: 12px;"><i class="fa fa-ellipsis-h" style="position: relative; float: right; top: 5px;" onclick="showProjectMenu()"></i></div> -->
                 <div id="project-menu">
                   <!--<div style="float:right;color: #28a745;font-size: 25px;margin-right: 12px;"><i class="fa fa-check" style="position: relative; float: right; top: 5px;" ></i></div> -->
                   <div role="link" style="float:right;color: #dc3545;font-size: 25px;"><i class="fa fa-trash" style="position: relative;  float: right;top: 5px; margin-right: 10px;" onclick="deleteProject(<?php echo $loadId; ?>)"></i></div>
                 </div>

                </div>

              </div>

              <?php
             }
          }
          else if($typeLoad == "user_id"){
            ?>
            <div class="row">
              <div class="col-12">
                <div class="title" style="font-size:25px; margin-left:25px;float:left; color: #000; font-weight:bold;">
                  View All Tasks
                </div>
              </div>
            </div>
            <?php
          }
        }

     else {
           echo "Failed!";
      }

 ?>

  <hr />
     <div class="row" id="todoList" style="margin-top:20px; margin-bottom:20px;" data-project-id="<?php echo $loadId; ?>">
  </div>
