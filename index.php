<?php include("includes/header.php"); ?>

<body>
<div class="container">
  <h3 style="margin-top:30px;">Task Manager</h3>
    <button class="btn btn-success btn-lg sticky-right" onclick="showTaskManager()"><i class="fa fa-plus  m-right-5" id="add-task-icon" ></i><span class="add-task-text"> Add Task </span></button>
    <div class="jumbotron" id="task-manager" data-show="false" style="display:none; margin-top:50px;">
        <h3>Add New Issue:</h3>
        <form id="task_form">
          <div class="form-group">
            <label for="issueDescInput">Title</label>
            <input type="text" class="form-control" id="title_input" placeholder="Title...">
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

            <div class="row" id="todoList" style="margin-top:20px; margin-bottom:20px;">
            </div>

        <div class="footer">
    </div>
</div>
</body>

<?php include("includes/footer.php"); ?>