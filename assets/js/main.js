$(function(){
   //process the form for task manager
   $("#task_form").submit(function(event){
      //grab form data
      var formData = {
        'name' : $('#name_input').val(),
        'description' : $('#description_input').val(),
        'severity' : $('#severity_input').val(),
        'assigned' : $('#assigned_to_input').val()
      }

      //process the task form

      $.ajax({
        type: 'POST',
        url: 'includes/rest/process.php',
        data: formData,
        dataType: 'json',  //type of data we expect back grom the server
        encode: true
      }).done(function(data) {
        console.log(data); //test if data is being called back
      });

      // stop the form from submitting the normal way and refreshing the page
       event.preventDefault();
   });

}); //end document ready

function showTaskManager(){

  var visible = $("#task-manager").attr("data-show");
  console.log(visible);

  if(visible == "false"){
    console.log("show");
    $("#task-manager").show("slow");
    $("#task-manager").attr("data-show", "true");

    $("#add-task-icon").removeClass("fa-plus");
    $("#add-task-icon").addClass("fa-minus");
  }
  else{
    console.log("hide");
    $("#task-manager").hide("slow");
      $("#task-manager").attr("data-show", "false");

      $("#add-task-icon").removeClass("fa-minus");
      $("#add-task-icon").addClass("fa-plus");
  }
}
