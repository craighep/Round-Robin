var team1 = "-1";
var team2 = "-1";
var team1Score = 0;
var team2Score = 0;

function teamScoreOne(sel) {
   team1 = sel.value;
    $("#team2 > option").each(function() {
        $(this).show();
    });
    if(team1 != "-1"){
       $("#team2 > option[value='"+team1+"']").hide();
    }
       checkShowSubmit();
}

function teamScoreTwo(sel) {
   team2 = sel.value;
    $("#team1 > option").each(function() {
        $(this).show();
    });
    if(team2 != "-1"){
   $("#team1 > option[value='"+team2+"']").hide();
    }
   checkShowSubmit();
}

function checkShowSubmit() {
    team1Score = $( "#pointsTeam1 option:selected" ).text();
    team2Score = $( "#pointsTeam2 option:selected" ).text();
    if (team1 != "-1" && team2 != "-1")
    {
        $('#submitScore').show();
        $("#pointsTeam1").css( "display", "inline" );
        $("#pointsTeam2").css( "display", "inline" );
    }
    else 
    {
        $('#submitScore').hide();
        $('#pointsTeam1').hide();
        $('#pointsTeam2').hide();
    }
}

function add_editLeague(name, state,id) {
    var league = "";
    if (state == "edit")
        league = prompt("Enter league name", name);
    else if (state == "new")
        league = prompt("Enter league name", "");
    else{
        var r = confirm("Are you sure?");
        if (r == false) 
            return;
    }
    
    if (league != null) {
        var hr = new XMLHttpRequest();
        var url = "insertLeague.php";
        var vars = "league="+league+"&state="+state+"&id="+id;
        hr.open("POST", url, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if (hr.readyState == 4) 
                postRefreshPage("leagueSelected", hr.responseText);
        }
        hr.send(vars);
    }
}

function add_editTeam(name, state, id,l_id) {
    var team = "";
    if (state == "edit")
        team = prompt("Enter team name", name);
    else if (state == "new")
        team = prompt("Enter team name", "");
    else{
        var r = confirm("Are you sure?");
        if (r == false) 
            return;
    }
    
    if (team != null) {
        var hr = new XMLHttpRequest();
        var url = "insertTeam.php";
        var vars = "team="+team+"&state="+state+"&id="+id+"&league_ID="+l_id;
        hr.open("POST", url, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if (hr.readyState == 4) 
                getTeams(l_id);
                getTeamTable(l_id);
                getTeamScores(l_id);
                if (state == "edit")
                    selectTeam(id, l_id);
                else {
                    $('#teamStats').hide();
                    $('#teamResults').hide();
                    $('#teamFixtures').hide();
                    resetFixtureTable(l_id);
                }
                $('#noTeams').hide();
        }
        hr.send(vars);
    }
}

function getTeams(l_id) {
    var hr = new XMLHttpRequest();
    var url = "getTeams.php";
    var vars = "league_ID="+l_id+"&action=teams";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if (hr.readyState == 4) 
            $('#teamList').html(hr.responseText);
    }
    hr.send(vars);
}

function getTeamTable(l_id) {
    var hr = new XMLHttpRequest();
    var url = "getTeams.php";
    var vars = "league_ID="+l_id+"&action=table";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if (hr.readyState == 4) 
            $('#teamTable').html(hr.responseText);
    }
    hr.send(vars);
}

function getTeamScores(l_id) {
    var hr = new XMLHttpRequest();
    var url = "getTeams.php";
    var vars = "league_ID="+l_id+"&action=scores";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if (hr.readyState == 4) 
            $('#team1').html(hr.responseText);
            $('#team2').html(hr.responseText);
    }
    hr.send(vars);
}

function add_editFixture(league, state) {
    team1ID = $( "#team1 option:selected" ).val();
    team2ID = $( "#team2 option:selected" ).val();
    team1Score = $( "#pointsTeam1 option:selected" ).text();
    team2Score = $( "#pointsTeam2 option:selected" ).text();
    
    if (league != null) {
        var hr = new XMLHttpRequest();
        var url = "insertFixture.php";
        var vars = "league="+league+"&state="+state+"&team1_ID="+team1ID+"&team2_ID="+team2ID+"&team1_Score="+team1Score+"&team2_Score="+team2Score;
        hr.open("POST", url, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if (hr.readyState == 4) 
                getTeamTable(league);
                $('#scoreSaved').show();
                $('#scoreSaved').fadeOut(2000);
                $('#teamStats').hide();
                $('#teamResults').hide();
                $('#teamFixtures').hide();
                resetFixtureTable(league);
        }
        hr.send(vars);
    }
}

function resetFixtureTable(league){
    var hr = new XMLHttpRequest();
    console.log("yooo");
    var url = "getFixtures.php";
    var vars = "league="+league;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if (hr.readyState == 4) 
            $('#fixturesList').html(hr.responseText);
    }
    hr.send(vars);
}

$( document ).ready(function() {
    $('#pointsTeam1').hide();
    $('#pointsTeam2').hide();
    $( "#teamList a" ).click(function() {
        $("#teamList > a").each(function() {
            $(this).toggleClass( "active", false );
        });
        $( this ).toggleClass( "active" );
    });
});