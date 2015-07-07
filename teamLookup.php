<h2 class="sub-header" id="teams">Team look-up</h2>
<div class="container-fluid">
<div class="row">
<div class="col-sm-6 col-md-3">
    <div class="list-group" id="teamList">
        <?php 
           printTeamList($id);
        ?>
        </div>
        <?php 
        if($logged_in){
            echo "<input type=\"submit\" class=\"btn btn-success\" onclick=\"add_editTeam('', 'new', '', '".$id."')\" value=\"Create new team\">";
        }?>
   </div>
   <div class="col-sm-6 col-md-3" id="teamStats">
        <?php 
            echo "<h3 class='sub-header team_icons'><div id='teamName'></div>" ;
            if($logged_in){
              echo "<div class=\"team_icons\">
              <a id='editTeam' href=\"#\" onclick=\"return false;\"><i class=\"glyphicon glyphicon-pencil\"></i></a>
              <a id='deleteTeam' href=\"#\" onclick=\"return false;\"><i class=\"glyphicon glyphicon-trash\"></i></a> 
              </div>";
            }
              echo  "</h3><div id='stats'>Select a team from the list to show fixtures, results and statistics!</div>";
          ?>
   </div>
   <div class="col-sm-6 col-md-3" id="teamResults">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Results</div>

      <ul class="list-group" id="latestResults">
      </ul>
    </div>
   </div>
   <div class="col-sm-6 col-md-3" id="teamFixtures">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Fixtures</div>

      <ul class="list-group" id="latestFixtures">
      </ul>
    </div>
   </div>
  </div>
</div>