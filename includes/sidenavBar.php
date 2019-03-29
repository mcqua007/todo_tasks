<style>
.team-delete-icon{
visibility: hidden;
}

.team-name:hover .team-delete-icon{
  visibility: visible;
  color:red;
  font-size:19px;
  float:right;
  padding-left:1px;
}
</style>

<div class="sidebar-nav-closed" style="margin-top: -11px;">
   <nav class="nav flex-column" id="menu-list" style="display:none;">
    <div class="nav-link" role="link" tabindex="0" onclick="showDropdownMenu(this, 'user-menu')" id="sidebar-username"><i class="fa fa-user"></i>&nbsp; </div>
    <div class="" id="user-menu" data-collapsed="false" style="display:none;">
        <div class="m-left-10" style="margin-left:10px;">
           <a class="nav-link" role="link"  onclick="logout()">Logout</a>
        </div>
   </div>
     <div class="navItem">
       <div role="link" tabindex="0" onclick="showDropdownMenu(this, 'user-project-menu')"  class="navItemLink link nav-link"> <i class="fa fa-folder"></i>&nbsp;Your Projects</div>
       <div class="" id="user-project-menu" data-collapsed="false" style="display:none;">
         <div class="bordertop" style="margin-top:10px;"></div>
            <div class="m-left-10" style="margin-left:10px;" id="user-projects-menu-items">
              <?php
               $user_projects_query = mysqli_query($con, "SELECT title, t1.id FROM projects t1 INNER JOIN userProjects t2 ON t1.id = t2.project_id WHERE t2.user_id = '$user_id'");

               while($row = mysqli_fetch_array($user_projects_query )){
              ?>
              <div class="navItem nav-link" id="sidebar-project-wrap-<?php echo $row['id']; ?>">
                <span role="link" tabindex="0" onclick="openTasks(<?php echo $row['id']; ?>,'project_id', this)" id="sidebar-project-<?php echo $row['id']; ?>" class=""><?php echo $row['title']; ?></span>
              </div>
              <?php
              }
              ?>
            </div>
         </div>
       </div>
       <div class="navItem">
         <div role="link" tabindex="0" onclick="showDropdownMenu(this, 'team-menu')"  class="navItemLink link nav-link"> <i class="fa fa-users"></i>&nbsp;Your Teams</div>
         <div class="" id="team-menu" data-collapsed="false" style="display:none;">
           <div class="bordertop" style="margin-top:10px;"></div>
              <div class="m-left-10" id="team-menu-inner" style="margin-left:10px;">
                <?php
                 $teams_query = mysqli_query($con, "SELECT name, t2.id FROM teamUsers t1 INNER JOIN teams t2 ON t1.team_id= t2.id WHERE t1.user_id= '$user_id'");

                 while($row2 = mysqli_fetch_array($teams_query )){
                ?>
                <div class="navItem nav-link" id="team-nav-link-<?php echo $row2['id']; ?>">
                  <div role="link" tabindex="0" onclick="showDropdownMenu(this, 'team-projects-<?php echo $row2['id']; ?>')"  id="team-id-<?php echo $row2['id']; ?>" class="team-name"><?php echo $row2['name']; ?> <i class="fa fa-trash team-delete-icon"
                    onclick="deleteTeam(<?php echo $row2['id']; ?>, '<?php echo $row2['name']; ?>')">
                  </i></div>
                  <div class="" id="team-projects-<?php echo $row2['id']; ?>" data-collapsed="false" style="display:none;">
                    <div class="bordertop" style="margin-top:10px;"></div>
                       <div class="m-left-10" style="margin-left:10px;" id="team-projects-menu-items-<?php echo $row2['id']; ?>">
                         <?php
                         $team_id = $row2['id'];
                          $team_project_query = mysqli_query($con, "SELECT title, t1.id FROM projects t1 INNER JOIN teamProjects t2 ON t1.id = t2.project_id WHERE t2.team_id = '$team_id'");

                          while($row3 = mysqli_fetch_array($team_project_query)){
                         ?>
                         <div class="navItem nav-link" id="sidebar-project-wrap-<?php echo $row3['id']; ?>">
                           <span role="link" tabindex="0" onclick="openTasks(<?php echo $row3['id']; ?>,'project_id', this)" id="sidebar-project-<?php echo $row3['id']; ?>" class=""><?php echo $row3['title']; ?></span>
                         </div>
                         <?php
                         }
                         ?>
                       </div>
                    </div>
                </div>
                <?php
                }
                ?>
              </div>
           </div>
         </div>
      <div class="navItem nav-link">
        <span class="" role="link" onclick="openTasks(userId,'user_id', this)"> <i class="fa fa-tasks"></i>&nbsp; View All Tasks</span>
      </div>
  </nav>
</div>
