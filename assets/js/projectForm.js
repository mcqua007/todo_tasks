$(function(){ //dont execute until dom is loaded
  $('select#project_type_input').change(function() {
     var selectVal =  $(this).val();
      if (selectVal == "team"){
        $("#project_team_group").show();

      }
      else{
        $("#project_team_group").hide();
      }
  })


  //=====================================================
  // SUBMIT TASK FORM - process form data             ===
  //=====================================================
     $("#project_form").submit(function(event){

       //remvoe an error messages that where there previously
       $(".project-error-message").hide();

       // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

        //grab form data
        var projectFormData = {
          'title' : $('#project_title_input').val(),
          'description' : $('#project_description_input').val(),
          'type' : $('#project_type_input').val(),
          'team': $('#project_team_input').val()
        }

        $.ajax({
          type: 'POST',
          url: 'includes/rest/processProjectForm.php',
          data: projectFormData
          //success: function() {alert("success!"); }
        }).done(function(data) {

           $('input[type="text"], textarea').val('');//reset form input to an epty value

           console.log(data); //test if data is being called back
          //return same data entered in JSON, use data to buld a card, that shows up on the page
          var response = JSON.parse(data);

          if(response.success == true){
             //alert a success message in task jumbotron
               alertFlash("#project-alert-flash", "success","Success! Project created below.");
             //load project

             openTasks(response.projectId,'project_id', 'sidebar-project-' + response.projectId);

          }
          else if(response.success == false){
             alertFlash("#project-alert-flash", "danger","ERROR! Please fix issue below!");

             //IF ERRORS - DISPLAY TO USER
             displayErrors("#project_title_group", response.errors.title);
             displayErrors("#project_description_group", response.errors.description);
             displayErrors("#project_team_group", response.errors.team);
             displayErrors("#project_type_group", response.errors.type);


          }
        });

     });
});
