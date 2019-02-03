$(function(){
   //process the form for task manager

   $( "#todoList" ).sortable();
    $( "#todoList" ).disableSelection();

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
        htmlInput = "<div class='input-group mb-3'  style='padding:10px;'><input type='text' class='form-control' placeholder='To do' id='todo-input-" + response.id +"' aria-describedby='button-addon2'><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' id='todo-button-" + response.id +"' onclick='addToDo(" + response.id + ", )'><i class='fa fa-plus'></i></button></div></div>";

        var html ="<div class='col-sm-12 col-md-3 col-xl-4 animated fadeInRight' id='todo-card-"+ response.id +"' style='margin-top:10px;' data-id='"+ response.id +"'><div class='col-xs-12 card'><div style='width:100%; padding:10px;'><span class='card-title' style='width:70%; margin:10px; font-weight:700; font-size:16px; text-transform:uppercase;'>" + response.title + "</span>" + htmlBadge + "</div><div class='card-body'><p class='card-subtitle mb-2 text-muted'>"+ response.description + "</p><div id='todo-" + response.id +"'></div></div>" + htmlInput + "</div></div>";
        $("#todoList").append(html);

        setTimeout(function(){
          console.log("in here");
          $("#todo-card-"+ response.id).removeClass("fadeInRight");
        }, 900);
      });


   });

}); //end document ready



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
