$(function(){

 //MAKE TEH CARDS SORTABLE
   $( "#todoList" ).sortable();
   $( "#todoList" ).disableSelection();




//=====================================================
// SUBMIT TASK FORM - process form data
//=====================================================
   $("#task_form").submit(function(event){

     //remvoe an error messages that where there previously
     $(".task-error-message").hide();

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
        var response = JSON.parse(data);

        if(response.success == true){
           //alert a success message in task jumbotron
             alertFlash("#task-alert-flash", "success","Success! Task created below.");
           //build the card
             buildCard(data);
        }
        else if(response.success == false){
           alertFlash("#task-alert-flash", "danger","ERROR! Please fix issue below!");

           //IF ERRORS - DISPLAY TO USER
           displayErrors("#title-group", response.errors.title);
           displayErrors("#description-group", response.errors.description)
           displayErrors("#assigned-group", response.errors.assigned)


        }
      });

   });

}); //END DOCUMENT READY





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
   //Do Stuff here
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

    if(data.success == true){
        //add to do
        var todoHtml = "<div style='width:100%;' id='todo-row-" + data.id + "'><div class='form-check'><input type='checkbox' data-checked='false' id='todo-checkbox-" + data.id + "' onchange='setCheckBox(" + data.id + ")' class='form-check-input'><label class='form-check-label' id='todo-label-" + data.id + "'>" + todoInput + "</label></div></div>";
        $("#todo-" + id).append(todoHtml);
        $('input[type="text"], textarea').val(''); //reset form input to an epty value
    }
    if(data.success == false){
      console.error(data);
      
      //show there is an error to the user
      var errorText = "<div class='error-todo-text animated fadeIn'>"+ data.errors.todo + "</div>";

      $("#todo-"+ id).append(errorText);

        setTimeout(function() {
          $(".error-todo-text").remove(); //remove error after .7 seconds
        }, 3000);
    }


  });
}

function setCheckBox(id) {
  var checked = $("#todo-checkbox-" + id).attr("data-checked");
  console.log(checked);

  if(checked == "true"){
      console.log(checked);
     $("#todo-checkbox-" + id).attr("data-checked", "false");
     $("#todo-label-" + id).removeClass("grey");

     $.post('includes/rest/completeToDo.php', {
       todoId: id
     }).done(function(data) {
       console.log(data);
     }
  }
  else if(checked == "false"){
      console.log(checked);
    $("#todo-checkbox-" + id).attr("data-checked", "true");
    $("#todo-label-" + id).addClass("grey");

    $.post('includes/rest/completeToDo.php', {
      todoId: id
    }).done(function(data) {
      console.error(data);
    }
  }

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

function alertFlash(where, type, message){

  var html = "<div class='alert animated fadeInDown alert-"+ type +"' role='alert' id='task-alert'>";
      html += message;
      html += "</div>";

    $(where).append(html);

  //animation to fade in alert and fade it out
    setTimeout(function(){

      $("#task-alert").addClass("fadeOu");
          setTimeout(function(){
              $("#task-alert").remove();
          }, 500);

    }, 4000);

}

function displayErrors(where, data){
  if(data){
       var errorText =  "<div class='task-error-message'>"+ data + "</div>";
       $(where).append(errorText);

   }
}
//===========================================================
// BUILD CARD WITH RETURN DATA                            ===
//===========================================================
function buildCard(returnData){

   //turn data into Javascript object
  var response = JSON.parse(returnData);

    // Conditional for severity badge level ================
     var htmlBadge = "";
     if (response.severity == "low"){
       htmlBadge = "<span class='badge  badge-success' style='float:right; width:20%; padding:5px; '>Low</span>";
     }else if(response.severity == "medium"){
       htmlBadge = "<span class='badge  badge-warning' style='float:right; width:20%; padding:5px; '>Medium</span>";
     }
     else {
     htmlBadge =" <span class='badge  badge-danger' style='float:right; width:20%; padding:5px; '>High</span>";
     }

     // END CONDITIONAL ===================================
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


     var html = "<div class='col-sm-12 col-md-3 col-xl-4 task-wrap animated fadeInRight'  id='todo-card-wrap-"+ response.id +"' data-id='"+ response.id +"'>";
     html += "<div class='col-xs-12 card card-shadow' id='todo-card-"+ response.id +"'>" + htmlButtonGroup + "<div style='width:100%; padding:10px;'>";
     html += "<span class='card-title' style='width:70%; margin:10px; font-weight:700; font-size:16px; text-transform:uppercase;'>" + response.title + "</span>" + htmlBadge + "</div>";
     html += "<div class='card-body'><p class='card-subtitle mb-2 text-muted'>"+ response.description + "</p>";
     html += "<div id='todo-" + response.id +"'></div>";
     html += "</div>" + htmlInput + "</div>";
     html += "<div id='todo-card-back-"+ response.id +"' class='' style='display:none;'>";
     html += "<h3>Info</h3>";
     html += " </div>";
     html += "</div>";

     $("#todoList").append(html);

     //remove fadeIn right after its done animating so it wont animate when sorting
     setTimeout(function(){
       $("#todo-card-wrap-"+ response.id).removeClass("fadeInRight");
     }, 600);

}
