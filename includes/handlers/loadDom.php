


<!--  START OF BUILDING EACH CARD ON PAGE LOAD **** still needs to have condition if to completed grey out-->
<!-- **** ALso Load images and files associated with each task-->
<?php
function loadTasks($con, $query){
$taskTodoQuery = mysqli_query($con, $query); //  *eventually add where clasue for user/ users group

$taskData = array();

while ($row = mysqli_fetch_array($taskTodoQuery)) {
    $taskData['id'] = $row['id'];
    $taskData['title'] = $row['title'];
    $taskData['description'] =  $row['description'];
    $taskData['severity'] =  $row['severity'];
    $taskData['assigned_to'] = $row['assigned_to'];
    $taskData['open'] = $row['open'];
    $taskData['todo_hidden'] = $row['todo_hidden'];?>
  <script>

  var response = <?php echo json_encode($taskData); ?>;

  console.log(response);

  // CONDITIONAL - for severity badge level *still needs to have condition if to completed grey out================
   var htmlBadge = "";
   if (response.severity == "low"){
     htmlBadge = "<span class='badge  badge-success severity-badge' role='link' onclick='changeBadge("+response.id+")' data-current-state='low' id='todo-badge-" + response.id +"'>Low</span>";
   }else if(response.severity == "medium"){
     htmlBadge = "<span class='badge  badge-warning severity-badge' role='link' onclick='changeBadge("+response.id+")' data-current-state='medium' id='todo-badge-" + response.id +"'>Medium</span>";
   }
   else {
   htmlBadge =" <span class='badge  badge-danger severity-badge' role='link' onclick='changeBadge("+response.id+")' data-current-state='high' id='todo-badge-" + response.id +"'>High</span>";
   }

   // END CONDITIONAL ===================================

// used to be class on first line class='input-group mb-3', removed mb-3

   var htmlInput = "<div class='input-group' id='todo-input-group-" + response.id +"'  style='padding:10px;'><input type='text' class='form-control' placeholder='Add to do here...' id='todo-input-" + response.id +"' aria-describedby='button-addon2'><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' id='todo-button-" + response.id +"' data-task-id='"+response.id+"' onclick='addToDo(" + response.id + ", this)'><i class='fa fa-plus'></i></button></div></div>";
   htmlInput += "<div style='color: #ccc;padding-left: 5px; padding-right: 5px; padding-bottom: 5px; margin-right: 9px;font-style: italic; font-size:12px; position: relative; text-align:right;' id='assigned-"+ response.id +"'>Assigned To: "+ response.assigned_to +"</div>";

   var menuButton ="<div class='btn-group'>";
     menuButton += "<button class='btn btn-outline-secondary dropdown-toggle' type='button' id='btnGroupDrop1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> more </button>";
     menuButton += "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='btnGroupDrop1' data-dropdown-task-id='" + response.id +"'>";
     menuButton += "<button class='dropdown-item' type='button' data-showfront-btn-id='" + response.id +"' onclick='showFront(" + response.id +")' style='display:none;'> <i class='fa fa-arrow-left' style='margin-right:5px;'></i>Go Back</button>";
     menuButton += "<button class='dropdown-item' type='button' data-complete-btn-id='" + response.id +"' onclick='completeTask(" + response.id +")'> <i class='fa fa-check' style='margin-right:5px;'></i>Completed</button>";
     menuButton += "<button class='dropdown-item' type='button' data-expand-btn-id='" + response.id +"' onclick='expandTask(" + response.id +")'> <i class='fa fa-expand' style='margin-right:5px;'></i>Expand</button>";
     menuButton += "<button class='dropdown-item' type='button' data-shrink-btn-id='" + response.id +"' onclick='shrinkTask(" + response.id +")'  style='display:none;'> <i class='fa fa-compress' style='margin-right:5px;'></i>Shrink</button>";
     menuButton += "<button class='dropdown-item' type='button' data-hide-todo-btn-id='" + response.id +"' data-visible='true'  onclick='hideTodo(" + response.id +")'> <i class='fa fa-eye-slash' style='margin-right:5px;'></i>Hide Todos</button>";
     menuButton += "<button class='dropdown-item' type='button' data-show-todo-btn-id='" + response.id +"' data-visible='false'  onclick='showTodo(" + response.id +")' style='display:none;'> <i class='fa fa-eye' style='margin-right:5px;'></i>Show Todos</button>";
     menuButton += "<button class='dropdown-item' type='button' data-delete-btn-id='" + response.id +"' onclick='deleteTask(" + response.id +")'> <i class='fa fa-trash' style='margin-right:8px;'></i>Delete</button>";
     menuButton += "<button class='dropdown-item' type='button' data-image-upload-btn-id='" + response.id +"' onclick='showImageUpload(" + response.id + ")'> <i class='fa fa-file-image-o' style=' margin-right:8px;'></i>Upload Images</button>";
     menuButton +=  "</div>";
     menuButton += "</div>";


   var htmlButtonGroup = "<div class='btn-group' role='group' aria-label='Basic example'><button type='button' class='btn btn-outline-primary' id='btn-audio-"+ response.id +"'><i class='fa fa-microphone'></i></button><button type='button' class='btn btn-outline-danger'onclick='showImages(" + response.id +")' id='btn-image-"+ response.id +"'><i class='fa fa-picture-o'></i></button>" + menuButton + " </div>";


   var html = "<div class='col-12 col-sm-6 col-lg-4 task-wrap animated'  id='todo-card-wrap-"+ response.id +"'data-expanded='false' data-id='"+ response.id +"'>";
   html += "<div class='col-xs-12 card-set-down card card-shadow' id='todo-card-"+ response.id +"'>" + htmlButtonGroup + "<div style='width:100%; padding:10px;'  id='todo-title-wrap-" + response.id +"' >";
   html += "<span class='card-title' style='width:70%; margin:10px; font-weight:700; font-size:16px; text-transform:uppercase;' id='task-title-"+ response.id +"'>" + response.title + "</span>" + htmlBadge + "</div>";
   html += "<div class='card-body'><p class='card-subtitle mb-2 text-muted' id='task-desc-"+ response.id +"'>"+ response.description + "</p><hr id='todo-hr-"+ response.id +"'/>";
   html += "<div class='card-completed-todos card-todos-amount-text' id='todo-completed-amount-text-"+response.id+"' style='color: #777;'><span id='number-completed-todos-"+response.id+"'></span>/<span id='number-total-todos-"+response.id+"'></span> completed</div>";
   html += "<div class='card-no-todos card-todos-amount-text' id='no-todo-text-"+response.id+"' style='display:none; color: #777;'> No todos yet!</div>";
   html += "<div id='todo-" + response.id +"' data-total-todos='0' data-completed-todos='0'></div>";
   html += "</div>" + htmlInput;
   html += "<div id='todo-card-back-"+ response.id +"' class='' style='display:none;'>";
   html += " </div>";
   html += "</div>";
   html += "</div>";

   $("#todoList").append(html);
 // if task is closed call complete task to render as should, eventually needs to be redone so there is not ajax call
   if(response.open == 0){
     completeTask(response.id);
   }
   if(response.todo_hidden == 1){
     $("#todo-" + response.id).hide("slow");

     $("button[data-hide-todo-btn-id='"+ response.id +"']").attr("data-visible", "false");
      $("button[data-hide-todo-btn-id='"+ response.id +"']").hide();

     $("button[data-show-todo-btn-id='"+ response.id +"']").show();
     $("button[data-show-todo-btn-id='"+ response.id +"']").attr("data-visible", "true");  //changing
   }

   //GET TODOS SECTION
   //=============================================
   <?php
   $taskId = $row['id'];

    $todoQuery = mysqli_query($con, "SELECT * FROM todos where taskId = '$taskId'");

    $todoData = array();
 ?>
 var todo_count = 0;
 var completed_todo_count = 0;
 <?php
    while ($row2 = mysqli_fetch_array($todoQuery)) {
        $todoData['id'] = $row2['id'];
        $todoData['todo'] = $row2['todo'];
        $todoData['completed'] =  $row2['completed'];

        $data = json_encode($todoData); ?>

  var data = <?php echo $data; ?>;
  console.log(data);
     todo_count++;
  
     var todoHtml = "<div style='width:100%; margin-top: 5px;' id='todo-row-" + data.id + "'><div class='form-check'><input type='checkbox'";
     if(data.completed == 0){
        todoHtml += "data-checked='false' data-task-id='" + response.id + "' id='todo-checkbox-" + data.id + "' onchange='setCheckBox(" + data.id + ")' class='form-check-input'><label class='form-check-label'";
     }
     if(data.completed == 1){
         completed_todo_count++;
         todoHtml += "data-checked='true' data-task-id='" + response.id + "' id='todo-checkbox-" + data.id + "' onchange='setCheckBox(" + data.id + ")' class='form-check-input' checked><label class='form-check-label grey'";
     }
     todoHtml += "id='todo-label-" + data.id + "'>" + data.todo + "</label></div></div>";
     $("#todo-" + response.id).append(todoHtml);
  <?php
    } ?>
   //=============================================
   
   if(todo_count == 0){
     $("#todo-completed-amount-text-"+response.id).hide();
     $("#no-todo-text-"+response.id).show();
   }
   else{
     $("#todo-"+ response.id).attr("data-total-todos", todo_count);
    $("#todo-"+ response.id).attr("data-completed-todos", completed_todo_count);
    $("#number-completed-todos-"+ response.id).text(completed_todo_count);
    $("#number-total-todos-"+ response.id).text(todo_count);
   }
   
   //remove fadeIn right after its done animating so it wont animate when sorting
   setTimeout(function(){
     $("#todo-card-wrap-"+ response.id).removeClass("fadeInRight");
   }, 600);

   function changeBadge(id){
    var el = $("#todo-badge-"+id);
    var newBadge;
    var state =  el.attr("data-current-state");
    console.log("state: "+state);

    if(state == "low"){
      el.removeClass("badge-success");
      el.attr("data-current-state", "medium");

      el.addClass("badge-warning");
      el.text("Medium");
      newBadge = "medium";
    }
    else if (state == "medium"){
      el.removeClass("badge-warning");

      el.attr("data-current-state", "high");
      el.addClass("badge-danger");
      el.text("High");
      newBadge = "high";
    }
    else{
      el.removeClass("badge-danger");

      el.attr("data-current-state", "low");
      el.addClass("badge-success");
      el.text("Low");
      newBadge = "low";
    }

    $.post('includes/rest/changeBadge.php', {
      taskId: id,
      newBadge: newBadge
    }).done(function(data) {
      console.log(data);
    });
  }


  </script>

  <?php
  }
  ?>

<?php
} // end function
?>
