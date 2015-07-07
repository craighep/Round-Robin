<?php

include('database.php');

    if( isset($_POST['team1_Score']) && isset($_POST['team1_ID']) && isset($_POST['team2_Score']) && isset($_POST['team2_ID']) ){
        
        $score1 = $_POST['team1_Score'];
        $score2 = $_POST['team2_Score'];
        $team1 = $_POST['team1_ID'];
        $team2 = $_POST['team2_ID'];
        
        $queryTeam1 = "SELECT * FROM fixtures WHERE (team_1_ID = $team1 AND team_2_ID = $team2)";
        $queryTeam2 = "SELECT * FROM fixtures WHERE (team_2_ID = $team1 AND team_1_ID = $team2)";
        $resultFixture1 = mysql_query($queryTeam1);
        $resultFixture2 = mysql_query($queryTeam2);
        $for = 0;
        $against = 0;
        $sql = "";
        
        while($rowFixtureTeam1 = mysql_fetch_assoc($resultFixture1))
        {
            $sql = "UPDATE fixtures SET score_team_1 = '$score1', score_team_2 = '$score2' WHERE (team_1_ID = $team1 AND team_2_ID = $team2) OR (team_2_ID = $team1 AND team_1_ID = $team2)";
        } 
        while($rowFixtureTeam2 = mysql_fetch_assoc($resultFixture2))
        {
            $sql = "UPDATE fixtures SET score_team_2 = '$score1', score_team_1 = '$score2' WHERE (team_1_ID = $team1 AND team_2_ID = $team2) OR (team_2_ID = $team1 AND team_1_ID = $team2)";
        } 
        
        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        mysql_close($conn);
    }

?>