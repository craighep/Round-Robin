<?php

include('database.php');

$type = $_POST['state'];

if($type == "new")
{
    if(isset($_POST['league'])){
        $le = $_POST['league'];
        $sql = "INSERT INTO `leagues` (`league_Name`)  VALUES ('{$le}')";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        $_SESSION["league"] = $le;
        mysql_close($conn);
        echo $_POST['league'];
    }
}
else if($type == "edit")
{
    if(isset($_POST['league']) && isset($_POST['id'])){
        $le = $_POST['league'];
        $id = $_POST['id'];
        $sql = "UPDATE leagues SET league_Name = '$le' WHERE league_ID = $id";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        $_SESSION["league"] = $le;
        mysql_close($conn);
        echo $_POST['league'];
    }
}
else 
{
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $sql="DELETE FROM leagues WHERE league_ID='$id'";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        $query = "SELECT * FROM teams WHERE league_ID='$id'";
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result))
        {
            $team_id = $row['ID'];
                
            $sql="DELETE FROM fixtures WHERE team_1_ID='$team_id'";

            $retval = mysql_query( $sql, $conn );
            if(! $retval )
            {
              die(mysql_error());
            }
            $sql="DELETE FROM fixtures WHERE team_2_ID='$team_id'";

            $retval = mysql_query( $sql, $conn );
            if(! $retval )
            {
              die(mysql_error());
            }
        }
            
        $sql="DELETE FROM teams WHERE league_ID='$id'";

        $retval = mysql_query( $sql, $conn );
        if(! $retval )
        {
          die(mysql_error());
        }
        
        mysql_close($conn);
        $_SESSION["league"] = "";
        echo "";
    }
}
?>