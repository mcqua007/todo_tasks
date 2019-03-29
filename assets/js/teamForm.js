$(function(){
  $("#num_members").on("change", function(){
    $("#add_inputs").empty();

     var num = $("#num_members").val(); // reset the inputs

     console.log("# members: " + num);
     for(i = 1; i <= num; i++){
       var numHtml = "<div class='form-group col-sm-6 col-md-4 col-lg-3' id=''><label for='teamMemberInput'>Team Member "+ i +"</label><input type='text' class='form-control team-field' id='member_"+i+"' placeholder='Enter Username'></div>";
       $("#add_inputs").append(numHtml);
     }
  });

  //=====================================================
  // SUBMIT PROJECT FORM - process form data             ===
  //=====================================================
     $("#team_form").submit(function(event){
         // stop the form from submitting the normal way and refreshing the page
         event.preventDefault();

         var name = $("#team_name").val();
         var num = $("#num_members").val(); // reset the inputs
         var member1 = $("#member_1").val();
         var member2 = $("#member_2").val();
         var member3 = $("#member_3").val();
         var member4 = $("#member_4").val();
         var member5 = $("#member_5").val();

         var formData = {
           'team_name': name,
           'number': num,
           'member1': member1,
           'member2': member2,
           'member3': member3,
           'member4': member4,
           'member5': member5
         }

      $.ajax({
        method: 'POST',
        url: 'includes/rest/processTeamForm.php',
        data: formData,
      //  success: function (response)
    }).done(function(data){

      $('input[type="text"], textarea').val('');//reset form input to an epty value

      console.log(data); //test if data is being called back

     //return same data entered in JSON
      var response = JSON.parse(data);

      if(response.success == true){
         //alert a success message in task jumbotron
           alertFlash("#team-alert-flash", "success","Success! Team has been created.");
         //add to the project to nav
         var menuTeamHtml = "<div class='navItem nav-link' id='team-nav-link-"+response.team_id+"'>";
             menuTeamHtml += "<div role='link' tabindex='0' onclick=\"showDropdownMenu(this, 'team-projects-"+response.team_id+"')\" id='team-id-"+ response.team_id +"' class='team-name'>"+ response.team_name +"<i class='fa fa-trash team-delete-icon' onclick=\"deleteTeam("+response.team_id+", '"+response.team_name+"')\">";
             menuTeamHtml += "</i></div>"; 
             menuTeamHtml +="<div class='' id='team-projects-"+response.team_id+"' data-collapsed='false' style='display: none;'>";
             menuTeamHtml +="<div class='bordertop' style='margin-top:10px;'></div>";
             menuTeamHtml +=" <div class='m-left-10' style='margin-left:10px;' id='team-projects-menu-items-"+response.team_id+"'>";
             menuTeamHtml +="</div>";
             menuTeamHtml +="</div>";
             menuTeamHtml += "</div>";
             //if personal project add to user projects menu else add to teams
             $("#team-menu-inner").append(menuTeamHtml)


             var projectTeamHtml = "<option value='"+ response.team_id +"' id='project-team-"+ response.team_id +"'>"+response.team_name+"</option>"

             $("#project_team_input").append(projectTeamHtml)

         //load project

      }
      else if(response.success == false){
         alertFlash("#team-alert-flash", "danger","ERROR! Form did not submit!");

         //IF ERRORS - DISPLAY TO USER
         // displayErrors("#project_title_group", response.errors.title);
         // displayErrors("#project_description_group", response.errors.description);
         // displayErrors("#project_team_group", response.errors.team);
         // displayErrors("#project_type_group", response.errors.type);

      }

    });// END DONE

  }); //END SUBMIT BLOCK

});

function deleteTeam(id, teamName){
  //alert("Are you sure you want to delete the project ?");
  console.log("delete project: "+ id);
  var confirmDelete = confirm("Are you sure you want to delete "+teamName+", and all of its projects?");

  if(confirmDelete == true){
    $.post('includes/rest/deleteTeam.php', {
      teamId: id,
    }).done(function(data) {
       console.log(data)

       //remove from dom
       $("#team-nav-link-"+id).remove();
    });
  }
}
