
<?php
 include("includes/config.php");
include("includes/loadDom.php");

if(isset($_GET['loadId']) && isset($_GET['typeLoad'])){

     $loadId = $_GET['loadId'];
     $typeLoad = $_GET['typeLoad'];

      $query = "SELECT * FROM tasks WHERE " . $typeLoad . "=" . $loadId;

           loadTasks($con, $query);

    }
  else{ echo "Failed!";}

 ?>

    <div class="row" id="todoList" style="margin-top:20px; margin-bottom:20px;" data-project-id="<?php echo $loadId; ?>">
    </div>
