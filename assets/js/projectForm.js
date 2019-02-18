$(function(){ //dont execute until dom is loaded
 $('select#project_type_input').change(function() {
     var selectVal =  $(this).val();
      if (selectVal == "team"){
        $("#project-team-select").show();

      }
      else{
        $("#project-team-select").hide();
      }
  })
});
