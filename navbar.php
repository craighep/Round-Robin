<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Aber Badminton Social League</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li id="mobile-league"> 
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
			  </ul></div>
              </li>
              <?php
	          if($logged_in)
	          	echo '<li><a href="logout.php">Logout</a></li>';
	          else
	          	echo '<li><a href="login/">Admin Login</a></li>';
            ?>
          </ul>
        </div>
      </div>
    </nav>