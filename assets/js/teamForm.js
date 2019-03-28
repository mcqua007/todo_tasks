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




        console.log(formData);


      $.ajax({
        method: 'POST',
        url: 'includes/rest/processTeamForm.php',
        data: formData,
        success: function (response) {
          console.log(response);
        }
      });

    });

});
