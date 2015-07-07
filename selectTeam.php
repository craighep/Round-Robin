<?php
    include 'database.php';
    $query = "SELECT * FROM teams ORDER BY name";
    $result = mysql_query($query);
    $json = "{";
    $results = '"results": [';
    $fixtures = ',"fixtures": [';
        
    $teamID = $_POST['team_ID'];
    
    $searchTeam = "SELECT * FROM teams WHERE (ID = $teamID)";
    $teamResult = mysql_query($searchTeam);
    $rowTeam = mysql_fetch_assoc($teamResult);
    $json .='"team":"'.$rowTeam['name'].'","team_ID":"'.$teamID.'",';
    
    $queryTeam1 = "SELECT * FROM fixtures WHERE (team_1_ID = $teamID)";
    $queryTeam2 = "SELECT * FROM fixtures WHERE (team_2_ID = $teamID)";
    $resultFixture1 = mysql_query($queryTeam1);
    $resultFixture2 = mysql_query($queryTeam2);
    
    $Totalfor = 0;
    $Totalagainst = 0;
    
    while($rowFixtureTeam1 = mysql_fetch_assoc($resultFixture1))
    {
        $opponent = searchTeam($rowFixtureTeam1['team_2_ID']);
        if (intval($rowFixtureTeam1['score_team_1']) > 0 || intval($rowFixtureTeam1['score_team_2']) > 0){
            $win = 0;
            $for = $rowFixtureTeam1['score_team_1'];
            $against = $rowFixtureTeam1['score_team_2'];
            if(intval($rowFixtureTeam1['score_team_1']) > intval($rowFixtureTeam1['score_team_2']) )
                $win = 1;
            if (strpos($results,'against') !== false) 
                $results .= ',';
            $results .= '{"opponent":"'.$opponent.'","p_for":"'.$for.'","p_against":"'.$against.'","win":"'.$win.'"}';
            
            $Totalfor += intval($rowFixtureTeam1['score_team_1']);
            $Totalagainst +=  intval($rowFixtureTeam1['score_team_2']);
        }
        else
        {
            if (strpos($fixtures,'opponent') !== false) 
                $fixtures .= ',';
            $fixtures .= '{"opponent":"'.$opponent.'"}';
        } 
    } 
    while($rowFixtureTeam2 = mysql_fetch_assoc($resultFixture2))
    {
        $opponent = searchTeam($rowFixtureTeam2['team_1_ID']);
        if (intval($rowFixtureTeam2['score_team_2']) > 0 || intval($rowFixtureTeam2['score_team_1']) > 0){
            $win = 0;
            $for = $rowFixtureTeam2['score_team_2'];
            $against = $rowFixtureTeam2['score_team_1'];
            if(intval($rowFixtureTeam2['score_team_2']) > intval($rowFixtureTeam2['score_team_1']) )
                $win = 1;
            if (strpos($results,'against') !== false) 
                $results .= ',';
            $results .= '{"opponent":"'.$opponent.'","p_for":"'.$for.'","p_against":"'.$against.'","win":"'.$win.'"}';
            $Totalfor += intval($rowFixtureTeam2['score_team_2']);
            $Totalagainst +=  intval($rowFixtureTeam2['score_team_1']);
        }
        else
        {
            if (strpos($fixtures,'opponent') !== false) 
                $fixtures .= ',';
            $fixtures .= '{"opponent":"'.$opponent.'"}';
        } 
    } 
    $json .= $results . "]";
    $json .= $fixtures . '],"total_for":"'.$Totalfor.'","total_against":"'.$Totalagainst.'"}';
    echo $json;
    
    function searchTeam($otherTeamID) {
        $searchTeam = "SELECT * FROM teams WHERE (ID = $otherTeamID)";
        $teamResult = mysql_query($searchTeam);
        $rowTeam = mysql_fetch_assoc($teamResult);
        return $rowTeam['name'];
    }
?>

