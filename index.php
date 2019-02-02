<?php include("includes/header.php"); ?>

<body>
<div class="container">
  <h3>Task Manager</h3>
    <button class="btn btn-success btn-lg sticky-right" onclick="showTaskManager()"><i class="fa fa-plus  m-right-5" id="add-task-icon" ></i> Add Task</button>
    <div class="jumbotron" id="task-manager" data-show="false" style="display:none;">
        <h3>Add New Issue:</h3>
        <form id="task_form" action="process.php" method="POST">
          <div class="form-group">
            <label for="issueDescInput">Name</label>
            <input type="text" class="form-control" id="name_input" placeholder="Name...">
          </div>
            <div class="form-group">
            <label for="issueDescInput">Description</label>
            <input type="text" class="form-control" id="description_input" placeholder="Describe the issue ...">
            </div>
            <div class="form-group">
            <label for="issueSeverityInput">Severity</label>
                <select class="form-control"  id="severity_input">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
            </div>
            <div class="form-group">
            <label for="issueAssignedToInput">Assigned To</label>
            <input type="text" class="form-control" id="assigned_to_input" placeholder="Enter responsible ...">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
        </div>
        <div class="row">
        <div class="col-lg-12">
            <div id="issuesList">
            </div>
        </div>
        </div>
        <div class="footer">
    </div>
</div>
</body>

<?php include("includes/footer.php"); ?>
