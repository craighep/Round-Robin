<?php
$logged_in = false;
$currentLeague = "";
$currentTeam = "";
$id = 0;


session_start();

if(isset($_GET['leagueSelected']))
   $currentLeague = $_GET['leagueSelected'];

include 'database.php';
if($currentLeague == "") {
    $query = "SELECT * FROM leagues";
    $result = mysql_query($query);
    while($row = mysql_fetch_assoc($result)) {
        $currentLeague = $row['league_Name'];
        break;
    }        
}
$query = "SELECT * FROM leagues";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result)) {
    if($currentLeague == $row['league_Name'])
        $id = $row['league_ID'];
}
$logged_in = (isset($_SESSION['auth']) && $_SESSION['auth'] == 1)
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="League viewer and score entry system">
    <meta name="author" content="Craig Heptinstall">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $currentLeague ?> - League Viewer -</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    </head>
  <body>
    <?php 
    include 'navbar.php';
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <?php 
          include 'sidebar.php';
          ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard - <?php echo $currentLeague ?></h1>
          <div id="noTeams" class="alert alert-danger" role="alert">No teams currently entered!</div>

          <?php if($currentLeague != "") {
        
          include 'getTeams.php';
          include 'getFixtures.php';
          include 'scoreEntry.php';
          include 'teamStandings.php';
          include 'teamLookup.php';
          include 'entireFixtures.php';
         } else {echo '<div class="alert alert-danger" role="alert">No league selected!</div>';} ?>
        </div>
      </div>
    </div>
    <div id="hidden_form_container" style="display:none;"></div>
    
    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="js/changeLeague.js"></script>
    <?php if($logged_in) { ?><script src="js/leagues_teams_settings.js"></script> <?php } ?>
    <script src="js/changeTeam.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script>
            function changeLeague(name){
                postRefreshPage("leagueSelected", name)
            }
    </script>
  </body>
</html>
