$(function(){

   //make the task area sortable
   $( "#todoList" ).sortable();
    $( "#todoList" ).disableSelection();

   //process the form for task manager

   $("#task_form").submit(function(event){
     // stop the form from submitting the normal way and refreshing the page
      event.preventDefault();
      //grab form data
      var formData = {
        'title' : $('#title_input').val(),
        'description' : $('#description_input').val(),
        'severity' : $('#severity_input').val(),
        'assigned' : $('#assigned_to_input').val()
      }

      $.ajax({
        type: 'POST',
        url: 'includes/rest/process.php',
        data: formData
        //success: function() {alert("success!"); }
      }).done(function(data) {

         $('input[type="text"], textarea').val('');//reset form input to an epty value

        console.log(data); //test if data is being called back
        //return same data entered in JSON, use data to buld a card, that shows up on the page
        //build card in javascript
         var response = JSON.parse(data);

        var htmlBadge = "";


        if (response.severity == "low"){
          htmlBadge = "<span class='badge  badge-success' style='float:right; width:20%; padding:5px; '>Low</span>";
        }else if(response.severity == "medium"){
          htmlBadge = "<span class='badge  badge-warning' style='float:right; width:20%; padding:5px; '>Medium</span>";
        }
        else {
        htmlBadge =" <span class='badge  badge-danger' style='float:right; width:20%; padding:5px; '>High</span>";
        }
        var htmlInput = "<div class='input-group mb-3'  style='padding:10px;'><input type='text' class='form-control' placeholder='To do' id='todo-input-" + response.id +"' aria-describedby='button-addon2'><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' id='todo-button-" + response.id +"' onclick='addToDo(" + response.id + ", )'><i class='fa fa-plus'></i></button></div></div>";

        var menuButton ="<div class='btn-group'>";
          menuButton += "<button class='btn btn-outline-secondary dropdown-toggle' type='button' id='btnGroupDrop1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> more </button>";
          menuButton += "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='btnGroupDrop1'>";
          menuButton += "<button class='dropdown-item' type='button' onclick='completeTask(" + response.id +")'> <i class='fa fa-check' style='margin-right:5px;'></i>Completed</button>";
          menuButton += "<button class='dropdown-item' type='button' onclick='deleteTask(" + response.id +")'> <i class='fa fa-trash' style='margin-right:8px;'></i>Delete</button>";
          menuButton += "<button class='dropdown-item' type='button'> <i class='fa fa-info' style=' margin-right:8px; margin-left: 5px;'></i>Info</button>";
          menuButton +=  "</div>";
          menuButton += "</div>";


        var htmlButtonGroup = "<div class='btn-group' role='group' aria-label='Basic example'><button type='button' class='btn btn-outline-primary'><i class='fa fa-microphone'></i></button><button type='button' class='btn btn-outline-danger'><i class='fa fa-picture-o'></i></button>" + menuButton + " </div>";


        var html ="<div class='col-sm-12 col-md-3 col-xl-4 task-wrap animated fadeInRight'  id='todo-card-wrap-"+ response.id +"' data-id='"+ response.id +"'><div class='col-xs-12 card card-shadow' id='todo-card-"+ response.id +"'>" + htmlButtonGroup + "<div style='width:100%; padding:10px;'><span class='card-title' style='width:70%; margin:10px; font-weight:700; font-size:16px; text-transform:uppercase;'>" + response.title + "</span>" + htmlBadge + "</div><div class='card-body'><p class='card-subtitle mb-2 text-muted'>"+ response.description + "</p><div id='todo-" + response.id +"'></div></div>" + htmlInput + "</div><div id='todo-card-back-"+ response.id +"' class='' style='display:none;'><h3>Info</h3></div></div>";
        $("#todoList").append(html);

        //remove fadeIn right after its done animating so it wont animate when sorting
        setTimeout(function(){
          $("#todo-card-wrap"+ response.id).removeClass("fadeInRight");
        }, 600);
      });


   });

}); //end document ready


//==============================================
//   FUNCTIONS                               ===
//==============================================

function deleteTask(id) {
  console.log("delete task: "+ id);

  $.post('includes/rest/deleteTask.php', {
    taskId: id
  }).done(function(data) {
    console.log(data);
    var jsonData = JSON.parse(data);
    console.log(jsonData.success);

    if(jsonData.success == true){
        console.log("in sucess true delete task");
        $("#todo-card-wrap-"+id).hide("slow");
    }
    else if(jsonData.success == false){
      console.error(data);
    }




  });

}

function completeTask(id) {
  $.post('includes/rest/completeTask.php', {
    taskId: id,
  }).done(function(data) {
    var data = JSON.parse(data);
    console.log(data.success);





  });

}

function showBack(id) {
  $("#todo-card-" + id).addClass("animated flipInY");

  setTimeout(function() {
    console.log(id);
    $("#todo-" + id).hide("slow");
    $("#todo-card-back-" + id).show("slow");
  }, 100);

}

function addToDo(id) {
  // need to post to php and then grab id that way
  var todoInput = $("#todo-input-" + id).val();

  $.post('includes/rest/addToDo.php', {
    data: todoInput,
    taskId: id
  }).done(function(data) {
    console.log(data);
    var data = JSON.parse(data);

    var todoHtml = "<div style='width:100%;' id='todo-row-" + data.id + "'><div class='form-check'><input type='checkbox' data-id='" + data.id + "' onclick='setCheckBox(" + data.id + ")' class='form-check-input'><label class='form-check-label' id='todo-label-" + data.id + "'>" + todoInput + "</label></div></div>";
    $("#todo-" + id).append(todoHtml);
    $('input[type="text"], textarea').val(''); //reset form input to an epty value
  });
}

function setCheckBox(id) {

  $("#todo-label-" + id).addClass("grey");
}

function showTaskManager() {

  var visible = $("#task-manager").attr("data-show");
  console.log(visible);

  if (visible == "false") {
    $("html, body").animate({
      scrollTop: 0
    }, "slow");
    $("#task-manager").show("slow");
    $("#task-manager").attr("data-show", "true");

    $("#add-task-icon").removeClass("fa-plus");
    $("#add-task-icon").addClass("fa-minus");
  } else {

    $("#task-manager").hide("slow");
    $("#task-manager").attr("data-show", "false");

    $("#add-task-icon").removeClass("fa-minus");
    $("#add-task-icon").addClass("fa-plus");
  }
}
function showBack(id){
  $("#todo-card-"+ id).addClass("animated flipInY");

  setTimeout(function(){
    console.log(id);
    $("#todo-"+ id).hide("slow");
    $("#todo-card-back-"+ id).show("slow");
  }, 100);

}
function addToDo(id){
 // need to post to php and then grab id that way
  var todoInput = $("#todo-input-" + id).val();

  $.post('includes/rest/addToDo.php', {data: todoInput, taskId: id}).done(function(data){
      console.log(data);
     var data = JSON.parse(data);

     var todoHtml = "<div style='width:100%;' id='todo-row-" + data.id + "'><div class='form-check'><input type='checkbox' data-id='" + data.id + "' onclick='setCheckBox(" + data.id + ")' class='form-check-input'><label class='form-check-label' id='todo-label-" + data.id + "'>" + todoInput + "</label></div></div>";
     $("#todo-" + id).append(todoHtml);
     $('input[type="text"], textarea').val('');//reset form input to an epty value
  });
}

function setCheckBox(id){

  $("#todo-label-" + id).addClass("grey");
}

function showTaskManager(){

  var visible = $("#task-manager").attr("data-show");
  console.log(visible);

  if(visible == "false"){
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $("#task-manager").show("slow");
    $("#task-manager").attr("data-show", "true");

    $("#add-task-icon").removeClass("fa-plus");
    $("#add-task-icon").addClass("fa-minus");
  }
  else{

    $("#task-manager").hide("slow");
      $("#task-manager").attr("data-show", "false");

      $("#add-task-icon").removeClass("fa-minus");
      $("#add-task-icon").addClass("fa-plus");
  }
}
