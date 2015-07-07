<?php

include('database.php');

$type = $_POST['state'];

if($type == "new")
{
    if(isset($_POST['team']) && isset($_POST['league_ID'])){
        $le = $_POST['team'];
        $l_ID = $_POST['league_ID'];
        $sql = "INSERT INTO `teams` (`name`, `league_ID`)  VALUES ('{$le}','{$l_ID}')";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        $query = "SELECT * FROM teams WHERE league_ID=".$l_ID;
        $result = mysql_query($query);
        $count = 1;
        $team_ID = 0;
        while($row = mysql_fetch_assoc($result))
        {
            if ($row['name'] == $le){
                $team_ID = $row['ID'];
                $team1Name = $row['name'];
                break;
            }
        } 
        $query = "SELECT * FROM teams WHERE league_ID=".$l_ID;
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result))
        {
            if ($row['name'] != $le){
                $oldTeam = $row['ID'];
                $team2Name = $row['name'];
                $sql = "INSERT INTO `fixtures` (`team_1_ID`, `team_2_ID`, `team1Name`, `team2Name`, `league_ID`)  VALUES ('{$team_ID}','{$oldTeam}','{$team1Name}','{$team2Name}','{$l_ID}')";
                $retval = mysql_query( $sql, $conn );
            }
        } 
        mysql_close($conn);
    }
}
else if($type == "edit")
{
    if(isset($_POST['team']) && isset($_POST['id'])){
        $le = $_POST['team'];
        $id = $_POST['id'];
        $sql = "UPDATE teams SET name = '$le' WHERE ID = $id";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        mysql_close($conn);
    }
}
else 
{
     echo "hi";
    if(isset($_POST['id'])){
        echo "hey";
        $id = $_POST['id'];
        $sql="DELETE FROM teams WHERE ID='$id'";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        $sql="DELETE FROM fixtures WHERE team_1_ID='$id'";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        $sql="DELETE FROM fixtures WHERE team_2_ID='$id'";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        mysql_close($conn);
        echo "";
    }
}
?>