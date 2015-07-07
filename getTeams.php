<?php
if(isset($_POST['league_ID']) && isset($_POST['action'])){
    if ($_POST['action'] == "table")
        printTeamTable($_POST['league_ID']);
    else if ($_POST['action'] == "scores")
        printTeamScore($_POST['league_ID']);
    else
        printTeamList($_POST['league_ID']);
}

function printTeamList($l_id){ 
    include 'database.php';
    $query = "SELECT * FROM teams ORDER BY name";
    $result = mysql_query($query);
    while($row = mysql_fetch_assoc($result))
    {
        if ($row['league_ID'] == $l_id)
            echo "<a href=\"javascript:;\" onclick=\"selectTeam('".$row['ID']."','".$l_id."')\" class=\"list-group-item\">".$row['name']."</a>";
    } 
}

function printTeamTable($l_id){ 
    include 'database.php';
    $query = "SELECT * FROM teams ORDER BY name";
    $result = mysql_query($query);
    $count = 1;
    $teams = array();
    while($row = mysql_fetch_assoc($result))
    {
        $teamID = $row['ID'];
        $queryTeam1 = "SELECT * FROM fixtures WHERE (team_1_ID = $teamID AND ( NOT score_team_2 = 0 OR NOT score_team_1 = 0))";
        $queryTeam2 = "SELECT * FROM fixtures WHERE (team_2_ID = $teamID AND ( NOT score_team_2 = 0 OR NOT score_team_1 = 0))";
        $resultFixture1 = mysql_query($queryTeam1);
        $resultFixture2 = mysql_query($queryTeam2);
        $played = 0;
        $for = 0;
        $won = 0;
        $lost = 0;
        $against = 0;
        while($rowFixtureTeam1 = mysql_fetch_assoc($resultFixture1))
        {
            $played++;
            $for += $rowFixtureTeam1['score_team_1'];
            if ($rowFixtureTeam1['score_team_1'] > $rowFixtureTeam1['score_team_2'])
                $won++;
            $against += $rowFixtureTeam1['score_team_2'];
        } 
        while($rowFixtureTeam2 = mysql_fetch_assoc($resultFixture2))
        {
            $played++;
            $for += $rowFixtureTeam2['score_team_2'];
            if ($rowFixtureTeam2['score_team_2'] > $rowFixtureTeam2['score_team_1'])
                $won++;
            $against += $rowFixtureTeam2['score_team_1'];
        } 
        if ($row['league_ID'] == $l_id){
            $lost = $played - $won;
            $team = array("score"=> $for,"text"=>"<td>".$row['name']."</td><td>".$played."</td><td>".$won."</td><td>".$lost."</td><td>".$for."</td><td>".$against."</td><td><b>".$for."</b></td>");
            array_push($teams, $team);
        }
    } 
    $sortArray = array(); 
    foreach($teams as $team){ 
        foreach($team as $key=>$value){ 
            if(!isset($sortArray[$key])){ 
                $sortArray[$key] = array(); 
            } 
            $sortArray[$key][] = $value; 
        } 
    } 
    $orderby = "score"; //change this to whatever key you want from the array 
    array_multisort($sortArray[$orderby],SORT_DESC,$teams);
    foreach ($teams as $team) {
        echo "<tr><td>".$count++."</td>".$team['text']."</tr>";
    }
}

function printTeamScore($l_id){ 
    include 'database.php';
    $query = "SELECT * FROM teams ORDER BY name";
    $result = mysql_query($query);
    $count = 0;
    echo "<option value='0'>- Select Team -</option>";
    while($row = mysql_fetch_assoc($result))
    {
        if ($row['league_ID'] == $l_id){
            echo "<option value='".$row['ID']."'>".$row['name']."</option>";
        }
        $count++;
    } 
    if ($count == 0)
    {
        echo "<script>$('#noTeams').show();</script>";
    }
}
?>