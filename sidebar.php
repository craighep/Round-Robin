<ul class="nav nav-sidebar">
    <li>
     <div class="btn-group leaugue-drop">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <?php echo $currentLeague; ?> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
      <?php 
        include 'database.php';
        $query = "SELECT * FROM leagues";
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result))
        {
            echo "<li><a href='#' onclick='changeLeague(\"".$row['league_Name']."\")'>".$row['league_Name']."</a></li>";
        } ?>
      </ul>
      <?php if($logged_in)
        echo "
          <div id=\"league_icons\">
          <a href=\"#\" onclick=\"add_editLeague('".$currentLeague."', 'new', '".$id."')\"><i class=\"glyphicon glyphicon-file\"></i></a>
          <a href=\"#\" onclick=\"add_editLeague('".$currentLeague."', 'edit', '".$id."')\"><i class=\"glyphicon glyphicon-pencil\"></i></a>
          <a href=\"#\" onclick=\"add_editLeague('".$currentLeague."', 'delete', '".$id."')\"><i class=\"glyphicon glyphicon-trash\"></i></a> 
          </div>";
      ?>
    </div>
    </li>
    <?php if($currentLeague != "") { ?>
        <?php if($logged_in)
            echo '<li><a href="#score">Score entry <span class="sr-only">(current)</span></a></li>';
        ?>
        <li><a href="#table">Table Standings</a></li>
        <li><a href="#teams">Team look-up</a></li>
        <li><a href="#fixtures">Remaining fixtures</a></li>
    <?php } ?>
</ul>