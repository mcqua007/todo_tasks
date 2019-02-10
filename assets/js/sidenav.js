function openSide(){
  $( "#menu-icon-close" ).removeClass("menu-close-animation");
  $( "#menu-icon" ).addClass("menu-animation");

  setTimeout(function(){
    $( "#menu-icon" ).hide();
    $( "#menu-icon-close" ).show();
  }, 300);

  $( ".sidebar-nav-closed" ).animate({
     width: "15%",
     opacity: 1,
   }, 600 );

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
