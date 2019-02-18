
<?php include("includes/header.php"); ?>
<?php include("includes/topbar.php"); ?>


<?php
  if(isset($_GET['userLoggedIn'])){
    $userLoggedIn = new User($con, $_GET['userLoggedIn']);
  }
  else{
    //echo "Username variable was not passed. Check the openPage() function in script.js";

  }


  if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	$username = $userLoggedIn->getUsername();
  $user_id = $userLoggedIn->getUserId();
	echo "<script> userLoggedIn = '$username';
        var userId = '$user_id';
        </script>";
  }
  else {
  	header("Location: register.php");
  }
  ?>

<?php include("includes/sidenavBar.php"); ?>
<body onload="openTasks(userId, 'user_id')">
  <div class="container" style="margin-top:50px;">
   <div id="all-forms">
     <!-- Task Manager Form -->
    <div class="jumbotron" id="task-manager" data-show="false" style="display:none; margin-top:10px;">
      <i class="fa fa-times" onclick="closeFormManager('task-manager')" style="float: right;font-size:30px;top: -30px;color: #ccc;position: relative;"></i>
      <div style="100%" id="task-alert-flash"></div>
       <h3>Add New Task</h3>
       <form id="task_form" data-project-id="">
         <div class="row">
           <div class="form-group col-md-4" id="title-group">
             <label for="issueDescInput">Title</label>
             <input type="text" class="form-control" id="project_title" placeholder="Title...">
           </div>
           <div class="form-group col-md-4" id="severity-group">
           <label for="issueSeverityInput">Severity</label>
               <select class="form-control"  id="severity_input">
               <option value="Low">Low</option>
               <option value="Medium">Medium</option>
               <option value="High">High</option>
           </select>
           </div>
           <div class="form-group col-md-4" id="assigned-group">
           <label for="issueAssignedToInput">Assigned To</label>
           <input type="text" class="form-control" id="assigned_to_input" placeholder="Assign To...">
           </div>
         </div>
           <div class="form-group" id="description-group">
           <label for="issueDescInput">Description</label>
           <input type="text" class="form-control" id="description_input" placeholder="Describe the issue...">
           </div>
           <button type="submit" class="btn btn-primary">Add</button>
       </form>
     </div>
     <!-- Project Manager Form -->
       <div class="jumbotron" id="project-manager" data-show="false" style="display:none; margin-top:10px;">
         <i class="fa fa-times" onclick="closeFormManager('project-manager')" style="float: right;font-size:30px;top: -30px;color: #ccc;position: relative;"></i>
         <div style="100%" id="project-alert-flash">
         </div>
           <h3>Add New Project</h3>
           <form id="task_form" data-project-id="">
             <div class="row">
               <div class="form-group col-md-4" id="title-group">
                 <label for="issueDescInput">Title</label>
                 <input type="text" class="form-control" id="title_input" placeholder="Title...">
               </div>
               <div class="form-group col-md-4" id="project-type">
                 <label for="projet-type">Type</label>
                  <select class="form-control"  id="project_type_input">
                     <option value="personal">Personal</option>
                     <option value="team">Team</option>
                 </select>
               </div>
               <div class="form-group col-md-4" id="project-team-select" style="display:none;">
                 <label for="issueSeverityInput">Teams</label>
                  <select class="form-control"  id="project_team_input">
                     <option value="team">Team 1</option>
                     <option value="personal">Team 2</option>
                 </select>
               </div>
             </div>
               <div class="form-group" id="description-group">
               <label for="issueDescInput">Description</label>
               <input type="text" class="form-control" id="description_input" placeholder="Describe the issue...">
               </div>
               <button type="submit" class="btn btn-primary">Add</button>
           </form>
       </div>
       <!-- Team Manager Form -->
         <div class="jumbotron" id="team-manager" data-show="false" style="display:none; margin-top:10px;">
           <i class="fa fa-times" onclick="closeFormManager('team-manager')" style="float: right;font-size:30px;top: -30px;color: #ccc;position: relative;"></i>
           <div style="100%" id="project-alert-flash">
           </div>
             <h3>Add New Project</h3>
             <form id="team_form" data-project-id="">
               <div class="row">
                 <div class="form-group col-md-4" id="title-group">
                   <label for="issueDescInput">Title</label>
                   <input type="text" class="form-control" id="title_input" placeholder="Title...">
                 </div>
                 <div class="form-group col-md-4" id="severity-group">
                 <label for="issueSeverityInput">Severity</label>
                     <select class="form-control"  id="severity_input">
                     <option value="Low">Low</option>
                     <option value="Medium">Medium</option>
                     <option value="High">High</option>
                 </select>
                 </div>
                 <div class="form-group col-md-4" id="assigned-group">
                 <label for="issueAssignedToInput">Assigned To</label>
                 <input type="text" class="form-control" id="assigned_to_input" placeholder="Assign To...">
                 </div>
               </div>
                 <div class="form-group" id="description-group">
                 <label for="issueDescInput">Description</label>
                 <input type="text" class="form-control" id="description_input" placeholder="Describe the issue...">
                 </div>
                 <button type="submit" class="btn btn-primary">Add</button>
             </form>
         </div>
      </div>
     <div id="loadTasks"></div>
  </div>
</body>

<?php include("includes/footer.php"); ?>
