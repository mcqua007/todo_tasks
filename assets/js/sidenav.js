function openSide(){
  $( "#menu-icon" ).hide();
  $( "#menu-icon-close" ).show();
  $( ".sidebar-nav-closed" ).animate({
     width: "15%",
     opacity: 1,
   }, 600 );
     $( "#menu-list" ).show("slow");

}

function closeSide(){

  $( "#menu-icon-close" ).hide();
  $( ".sidebar-nav-closed" ).animate({
     width: "0px",
     opacity: 1,
   }, 600 );
     $( "#menu-list" ).hide();
       $( "#menu-icon" ).show();

}
