

<div class="" style="background-color: #007bff; position: fixed; width: 100%; z-index: 99999; top:0px;">
<div ><i class="fa fa-times" style="display:none;  color: #fff; padding-top: 7px; padding-left: 6px; margin-bottom: -5px; font-size: 21px" id="menu-icon-close" onclick="closeSide()"></i>
<i onclick="openSide()" class="fa fa-bars" style="color: #fff; padding-top: 7px; padding-left: 6px; margin-bottom: -5px; font-size: 21px;" id="menu-icon" ></i></div>
    <center><h3 class="logo-font" style="margin-top: -30px;color: #fff; font-family: 'Leckerli One', cursive; font-size: 25px;">Staqpack</h3></center>
    <div class="btn-group"  style="float:right; padding-right:10px; float: right; padding-right: 10px; position: relative; margin-top: -40px;">
    <button class="add-btn-menu" type="button" id="btnGroupDrop1" data-toggle='dropdown' aria-haspopup="true" aria-expanded="false" >
      <i class="fa fa-plus  m-right-5" id="add-task-icon" style="color:#fff;"></i>
      <span class="add-task-text" style="color:#fff;"> Add </span></button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1" data-dropdown-task-id="">
    <button class="dropdown-item" type="button" data-showfront-btn-id="" onclick="showFormManager('task-manager')" ><span> Task </span></button>
    <button class="dropdown-item" type="button" data-showfront-btn-id="" onclick="showFormManager('project-manager')" > Project</button>
    <button class="dropdown-item" type="button" data-complete-btn-id="" onclick="showFormManager('team-manager')"> Team</button>
      </div>
    </div>
</div>
