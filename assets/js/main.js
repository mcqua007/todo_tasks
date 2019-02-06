$(function(){

 //MAKE TEH CARDS SORTABLE
   $( "#todoList" ).sortable();
   $( "#todoList" ).disableSelection();

//=====================================================
// IMAGE UPLOAD FORM - processing data              ===
//=====================================================





//=====================================================
// SUBMIT TASK FORM - process form data             ===
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
           displayErrors("#description-group", response.errors.description);
           displayErrors("#assigned-group", response.errors.assigned);


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
    console.log(data);
    var jsonData = JSON.parse(data);


      //Remove Severity Badge and Show Completed Badge
      var htmlBadge =" <span class='badge  badge-secondary completed-badge' id='todo-badge-completed-" + id +"'>Completed</span>";

      $("#todo-badge-"+id).hide();
      $("#todo-title-wrap-"+id).append(htmlBadge);

       //Grey out the task title
      $("#task-title-"+id).addClass("grey");

      //disable the checbox input for each to do
      $("input[data-task-id='"+id+"']").prop("disabled", true);

      //disabled top two buttons
      $("#btn-image-"+id).prop("disabled", true);
      $("#btn-audio-"+id).prop("disabled", true);

      //disabled todo input
      $("#todo-input-"+id).prop("disabled", true);

      //complete button change to re open
      var reopenBtn ="<button class='dropdown-item' type='button' data-reopen-btn-id='" + id +"' onclick='reopenTask(" + id +")'> <i class='fa fa-undo' style='margin-right:5px;'></i>Re-open</button>";
      $("button[data-complete-btn-id='"+id+"']").remove();
      $("div[data-dropdown-task-id='"+id+"']").prepend(reopenBtn);



  });

}


function reopenTask(id) {
  //!NEED TO  issue where reopen and completed deltes all deleted cards
  $.post('includes/rest/reopenTask.php', {
    taskId: id,
  }).done(function(data) {
    console.log(data);
    var jsonData = JSON.parse(data);


      //Remove Completed Badge and Show Severity Badge
      $("#todo-badge-completed-"+id).remove();
      $("#todo-badge-"+id).show();

       //Grey out the task title
      $("#task-title-"+id).removeClass("grey");

      //disable the checbox input for each to do
      $("input[data-task-id='"+id+"']").prop("disabled", false);

      //disabled top two buttons
      $("#btn-image-"+id).prop("disabled", false);
      $("#btn-audio-"+id).prop("disabled", false);

      //disabled todo input
      $("#todo-input-"+id).prop("disabled", false);

      //complete button change to re open
      var completeBtn ="<button class='dropdown-item' type='button' id='complete-btn-id-" + id  + "' data-complete-btn-id='" + id +"' onclick='completeTask(" + id +")'> <i class='fa fa-check' style='margin-right:5px;'></i>Completed</button>";
      $("button[data-reopen-btn-id='"+id+"']").remove();
      $("div[data-dropdown-task-id='"+id+"']").prepend(completeBtn);

  });

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
        var todoHtml = "<div style='width:100%;' id='todo-row-" + data.id + "'><div class='form-check'><input type='checkbox' data-checked='false' data-task-id='" + id + "' id='todo-checkbox-" + data.id + "' onchange='setCheckBox(" + data.id + ")' class='form-check-input'><label class='form-check-label' id='todo-label-" + data.id + "'>" + todoInput + "</label></div></div>";
        $("#todo-" + id).append(todoHtml);
        $('input[type="text"], textarea').val(''); //reset form input to an epty value
    }
    if(data.success == false){
      console.error(data);
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

  //!!!!!somehow unseting or unchecking is noe unseting in database and returning success false
  if(checked == "true"){
      console.log(checked);
     $("#todo-checkbox-" + id).attr("data-checked", "false");
     $("#todo-label-" + id).removeClass("grey");

     $.post('includes/rest/completeToDo.php', {
       todoId: id,
       completed: 0
     }).done(function(data) {
       var jsonData = JSON.parse(data);
        console.log(jsonData.success );

       if(jsonData.success == false){
         console.error(data);
       }
       else{
         console.log(data);
       }
     });

  }
  else if(checked == "false"){

    $("#todo-checkbox-" + id).attr("data-checked", "true");
    $("#todo-label-" + id).addClass("grey");

    $.post('includes/rest/completeToDo.php', {
      todoId: id,
      completed: 1
    }).done(function(data) {
      var response = JSON.parse(data);

      if(response.success == false){
        console.error(data);
      }
      else{
        console.log(data);
      }


    });
  }

}



function showTaskManager(){

  var visible = $("#task-manager").attr("data-show");

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

      $("#task-alert").addClass("fadeOut");
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

function imageUpload(event, id){
  $("#form-img-"+id).submit(function(event){
    console.log("Img Form Submit:");

      event.preventDefault();  //prevents default action, in this case form from submitting the page/reloading
      event.stopImmediatePropagation();//keeps form from duplicating as it was before


      var formData = new FormData($("#form-img-"+id)[0]);

      formData.append("taskId", id);



      console.log(formData);

      $.ajax({
          url : 'includes/rest/upload_image.php',
          type : 'POST',
          data : formData,
          contentType : false,
          processData : false,
          success: function(data) {
           console.log(data);
          var jsonData = JSON.parse(data);


            //if sucessful image upload, create thumbnail
            if(jsonData.success == true){
              //add image thumbnail
              var imgHtml = "<img src='" + jsonData.file_path +"' style='width:50px; margin:5px;'/>";
              $("#image-thumb-id-"+ id).prepend(imgHtml);

              $("#form-img-"+id).trigger("reset");



            }
            else{
              var imageError = "<span id='img-thumb-error-'" +id +" style='color:red;'>"+ jsonData.errors +"</span>";
              $("#image-thumb-id-"+ id).prepend(imageError);


            }
          }


      });
  });
}
//===========================================================
// BUILD CARD WITH RETURN DATA                            ===
//===========================================================



function buildCard(returnData){

   //turn data into Javascript object
  var response = JSON.parse(returnData);

    // CONDITIONAL - for severity badge level ================
     var htmlBadge = "";
     if (response.severity == "low"){
       htmlBadge = "<span class='badge  badge-success severity-badge' id='todo-badge-" + response.id +"'>Low</span>";
     }else if(response.severity == "medium"){
       htmlBadge = "<span class='badge  badge-warning severity-badge' id='todo-badge-" + response.id +"'>Medium</span>";
     }
     else {
     htmlBadge =" <span class='badge  badge-danger severity-badge' id='todo-badge-" + response.id +"'>High</span>";
     }

     // END CONDITIONAL ===================================
     var imageUploadForm = "<div class='card-body'><div class='card-title image-upload-title'>Upload Image</div>";
         imageUploadForm +=   "<div id='image-thumb-id-"+ response.id + "' style='position:relative; top:-70px; margin-bottom:-30px;'></div>";
         imageUploadForm +=  "<form id='form-img-"+ response.id +"' method='POST' role='form' enctype='multipart/form-data'>";
         imageUploadForm +=    "<input class='form-group' type='file' name='file' multiple>";
         imageUploadForm +=    "<button class='btn btn-success' data-task-id='"+ response.id +"' onclick='imageUpload(event, "+ response.id +")' type='submit'>Submit</button>";
         imageUploadForm += "</form>";
         imageUploadForm += "</div>";

     var htmlInput = "<div class='input-group mb-3' id='todo-input-group-" + response.id +"'  style='padding:10px;'><input type='text' class='form-control' placeholder='Add to do here...' id='todo-input-" + response.id +"' aria-describedby='button-addon2'><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' id='todo-button-" + response.id +"' onclick='addToDo(" + response.id + ", )'><i class='fa fa-plus'></i></button></div></div>";

     var menuButton ="<div class='btn-group'>";
       menuButton += "<button class='btn btn-outline-secondary dropdown-toggle' type='button' id='btnGroupDrop1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> more </button>";
       menuButton += "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='btnGroupDrop1' data-dropdown-task-id='" + response.id +"'>";
       menuButton += "<button class='dropdown-item' type='button' data-complete-btn-id='" + response.id +"' onclick='completeTask(" + response.id +")'> <i class='fa fa-check' style='margin-right:5px;'></i>Completed</button>";
       menuButton += "<button class='dropdown-item' type='button' data-delete-btn-id='" + response.id +"' onclick='deleteTask(" + response.id +")'> <i class='fa fa-trash' style='margin-right:8px;'></i>Delete</button>";
       menuButton += "<button class='dropdown-item' type='button' data-info-btn-id='" + response.id +"' onclick='showBack(" + response.id + ")'> <i class='fa fa-info' style=' margin-right:8px; margin-left: 5px;'></i>Info</button>";
       menuButton +=  "</div>";
       menuButton += "</div>";


     var htmlButtonGroup = "<div class='btn-group' role='group' aria-label='Basic example'><button type='button' class='btn btn-outline-primary' id='btn-audio-"+ response.id +"'><i class='fa fa-microphone'></i></button><button type='button' class='btn btn-outline-danger' id='btn-image-"+ response.id +"'><i class='fa fa-picture-o'></i></button>" + menuButton + " </div>";


     var html = "<div class='col-sm-12 col-md-3 col-xl-4 task-wrap animated fadeInRight'  id='todo-card-wrap-"+ response.id +"' data-id='"+ response.id +"'>";
     html += "<div class='col-xs-12 card card-shadow' id='todo-card-"+ response.id +"'>" + htmlButtonGroup + "<div style='width:100%; padding:10px;'  id='todo-title-wrap-" + response.id +"' >";
     html += "<span class='card-title' style='width:70%; margin:10px; font-weight:700; font-size:16px; text-transform:uppercase;' id='task-title-"+ response.id +"'>" + response.title + "</span>" + htmlBadge + "</div>";
     html += "<div class='card-body'><p class='card-subtitle mb-2 text-muted' id='task-desc-"+ response.id +"'>"+ response.description + "</p>";
     html += "<div id='todo-" + response.id +"'></div>";
     html += "</div>" + htmlInput;
     html += "<div id='todo-card-back-"+ response.id +"' class='' style='display:none;'>";
     html += imageUploadForm;
     html += " </div>";
     html += "</div>";
     html += "</div>";


     $("#todoList").append(html);

     //remove fadeIn right after its done animating so it wont animate when sorting
     setTimeout(function(){
       $("#todo-card-wrap-"+ response.id).removeClass("fadeInRight");
     }, 600);

}

function showBack(id) {
  $("#todo-card-" + id).addClass("animated flipInY");

  setTimeout(function() {

    $("#todo-" + id).hide();
    $("#task-title-" + id).hide();
    $("#todo-badge-" + id).hide();
    $("#task-desc-" + id).hide();
    $("#todo-input-group-" + id).hide();

    $("#todo-card-back-" + id).show();

  }, 100);

  setTimeout(function() {
    $("#todo-card-" + id).removeClass("animated flipInY");
  }, 500);


}
