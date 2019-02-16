
<?php include("includes/header.php"); ?>
<?php include("includes/topbar.php"); ?>
<?php include("includes/sidenavBar.php"); ?>

<?php
  if(isset($_GET['userLoggedIn'])){
    $userLoggedIn = new User($con, $_GET['userLoggedIn']);
  }
  else{
    echo "Username variable was not passed. Check the openPage() function in script.js";

  }


  if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	$username = $userLoggedIn->getUsername();
	echo "<script> userLoggedIn = '$username'; console.log(userLoggedIn);</script>";
  }
  else {
  	header("Location: register.php");
  }

  ?>
<body>

<div class="container" style="margin-top:50px;">
    <div class="jumbotron" id="task-manager" data-show="false" style="display:none; margin-top:50px;">
      <div style="100%" id="task-alert-flash">
      </div>
        <h3>Add New Issue:</h3>
        <form id="task_form">
          <div class="form-group" id="title-group">
            <label for="issueDescInput">Title</label>
            <input type="text" class="form-control" id="title_input" placeholder="Title...">
          </div>
            <div class="form-group" id="description-group">
            <label for="issueDescInput">Description</label>
            <input type="text" class="form-control" id="description_input" placeholder="Describe the issue...">
            </div>
            <div class="form-group" id="severity-group">
            <label for="issueSeverityInput">Severity</label>
                <select class="form-control"  id="severity_input">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
            </div>
            <div class="form-group" id="assigned-group">
            <label for="issueAssignedToInput">Assigned To</label>
            <input type="text" class="form-control" id="assigned_to_input" placeholder="Assign To...">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
        </div>

        <div class="row" id="todoList" style="margin-top:20px; margin-bottom:20px;">
        </div>

        <div class="footer">
    </div>
</div>
</body>



<?php include("includes/footer.php"); ?>
