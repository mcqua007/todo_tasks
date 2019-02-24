function openSide(){
  $( "#menu-icon-close" ).removeClass("menu-close-animation");
  $( "#menu-icon" ).addClass("menu-animation");

  setTimeout(function(){
    $( "#menu-icon" ).hide();
    $( "#menu-icon-close" ).show();
  }, 300);

  var screenWidth = $(window).width();

    console.log(screenWidth);

      if(screenWidth <= 550){
        $( ".sidebar-nav-closed" ).animate({
           width: "65%",
           opacity: 1,
         }, 600 );
      }
      else if(screenWidth <= 900){
        $( ".sidebar-nav-closed" ).animate({
           width: "35%",
           opacity: 1,
         }, 600 );
      }
      else{
        $( ".sidebar-nav-closed" ).animate({
           width: "17%",
           opacity: 1,
         }, 600 );
      }

      $( "#menu-list" ).show("slow");

}

function closeSide(){
  $( "#menu-icon" ).removeClass("menu-animation");
  $( "#menu-icon-close" ).addClass("menu-close-animation");

  setTimeout(function(){
    $( "#menu-icon-close" ).hide();
    $( "#menu-icon" ).show();
  }, 300);


  $( ".sidebar-nav-closed" ).animate({
     width: "0px",
     opacity: 1,
   }, 600 );
     $( "#menu-list" ).hide();


}

function showDropdownMenu(click, elementId, userId){
	console.log("click");

	var visible = $("#" + elementId).attr("data-collapsed");


  $(click).addClass("active-bottom");
	if(visible == "false"){
		console.log("show");
		$("#" + elementId).show("slow");
		$("#" + elementId).attr("data-collapsed", "true");
    $(click).addClass("active-bottom");
	}
	else{
		console.log("hide");
		$("#" + elementId).hide("slow");
		$("#" + elementId).attr("data-collapsed", "false");
    $(click).removeClass("active-bottom");
	}
}

//  THIS FUNCTION IS NOT IN USE BUT COULD BE USEFUL
function loadUserProjects(userId){
  console.log(userId);
  $.post('includes/rest/getUserProjects.php', {
    userId: userId,
  }).done(function(data) {

    console.log(data);

    var response = JSON.parse(data);

    for(var i = 0; i < response.projects.length; i++){


      var userProjectsHtml = "<div class='navItem nav-link'>";
          userProjectsHtml += "<span role='link' tabindex='0' onclick=\"openTasks("+ response.projects[i].id +",\'project_id\', this)\" id='sidebar-project-"+ response.projects[i].id +"' class=''>"+ response.projects[i].title +"</span>";
          userProjectsHtml += "</div>";

        $("#user-projects-menu-items").append(userProjectsHtml);
    }

  });
}
