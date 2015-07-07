<?php if($logged_in) {?>
  <h2 class="sub-header" id='score'>Score entry</h2>
  <em>Note: any game score above 21 (e.g. 23-21) should be made 21-19</em>
  <div id="centering">
  <form>
    <select class="form-control score" id="team1" onchange="teamScoreOne(this);">
      <?php printTeamScore($id); ?>
    </select> - 
    <select class="form-control score" id="team2" onchange="teamScoreTwo(this);">
      <?php printTeamScore($id); ?>
    </select>
    <br><br>
    <select class="form-control points" id="pointsTeam1" onchange="checkShowSubmit();">
        <?php 
            $scoreH = 0;
              for ($i = 21; $i >= 0; $i--){
                if($i == $scoreH)
                    echo "<option value='".$i."' selected='selected'>".$i."</option>";
                else
                    echo "<option value='".$i."'>".$i."</option>";
              }; ?>
    </select> - 
    <select class="form-control points" id="pointsTeam2" onchange="checkShowSubmit();">
        <?php 
            $scoreA = 0; 
              for ($i = 21; $i >= 0; $i--){
              if($i == $scoreA)
                    echo "<option value='".$i."' selected='selected'>".$i."</option>";
                else
                    echo "<option value='".$i."'>".$i."</option>";
              }; ?>
    </select>
    <br><br>
    <?php $buttonText = "Update"; 
        if($scoreH == 0 && $scoreA == 0)
            $buttonText = "Submit"; ?>
    <input type="button" id="submitScore" onclick="add_editFixture(<?php echo $id?>)" class="btn btn-success" value=<?php echo "'".$buttonText."'"?> tabindex="4">
    <br>
    <i id="scoreSaved" class="glyphicon glyphicon-ok">Saved!</i>
    </form>
   </div>
  <?php 
  }
  ?>