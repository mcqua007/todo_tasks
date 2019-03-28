$(function(){
  $("#num_members").on("change", function(){
    $("#add_inputs").empty();

     var num = $("#num_members").val(); // reset the inputs

     console.log("# members: " + num);
     for(i = 1; i <= num; i++){
       var numHtml = "<div class='form-group col-sm-6 col-md-4 col-lg-3' id=''><label for='teamMemberInput'>Team Member "+ i +"</label><input type='text' class='form-control team-field' id='members' placeholder='Enter Username'></div>";
       $("#add_inputs").append(numHtml);
     }
  });

  //=====================================================
  // SUBMIT PROJECT FORM - process form data             ===
  //=====================================================
     $("#team_form").submit(function(event){
       // stop the form from submitting the normal way and refreshing the page
         var formData = $("#team_form").serializeArray();
        event.preventDefault();

        

        var data = {};
        $(formData).each(function(index, obj){
            data[obj.name] = obj.value;
        });

        console.log(formData);
        console.log(data);


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
