<?php 
    if(isset($_POST['league']))
        printFixtures($_POST['league']);
    
    function printFixtures($l_id){
        include 'database.php';
        $query = "SELECT * FROM fixtures where (league_ID = $l_id AND score_team_1 = 0 AND score_team_2 = 0)";
        $result = mysql_query($query);
        $fixtures = Array();
        while($row = mysql_fetch_assoc($result))
        {
            array_push($fixtures, "<tr><td>".$row['team1Name']."</td><td>".$row['team2Name']."</td></tr>");
        }
        shuffle($fixtures);
        echo join('', $fixtures);
    }
?>