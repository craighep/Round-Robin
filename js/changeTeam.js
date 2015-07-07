function selectTeam(teamID, leagueID){
	var hr = new XMLHttpRequest();
    var url = "selectTeam.php";
    var vars = "team_ID="+teamID;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if (hr.readyState == 4){ 
            var json = hr.responseText;
			parseTeamJSON(json,leagueID);
		}
    }
    hr.send(vars);
}

function parseTeamJSON(data, leagueID){
	var json = JSON.parse(data);
    var pointsFor = 0;
    var wins = 0;
    var results = "";
    var fixtures = "";
    
	for (var i = 0; i < json["results"].length; i++){
        results += "<li class='list-group-item ";
        
		if (json["results"][i]["win"] == "1"){
			wins++;
            results += "won'>";
        }
        else 
            results += "lost'>";
        var gameFor = parseInt(json["results"][i]["p_for"]);
        var gameAgainst = parseInt(json["results"][i]["p_against"]);
        if (gameFor > gameAgainst)
            results += "W "+gameFor+"-"+gameAgainst;
        else
            results += "L "+gameFor+"-"+gameAgainst;
		results += " v "+json["results"][i]["opponent"]+"</li>";
        pointsFor += gameFor;
	}
	for (var i = 0; i < json["fixtures"].length; i++){
        fixtures += "<li class='list-group-item'>";
		fixtures += " v "+json["fixtures"][i]["opponent"]+"</li>";
	}
	var gamesRemaining = json["fixtures"].length;
    var avgPointsPerGame = "-";
    var winPerc = "-"
    if (json["results"].length > 0){
        avgPointsPerGame = Math.floor(pointsFor / json["results"].length);
        winPerc = Math.round(100/json["results"].length * wins)+"%";
    }
    
    $('#teamName').html(json["team"]);
    
    var js = "add_editTeam('"+json["team"]+"','edit','"+json["team_ID"]+"','"+leagueID+"'); return false;";
    $("#editTeam").attr('onclick', js);
    js = "add_editTeam('"+json["team"]+"','delete','"+json["team_ID"]+"','"+leagueID+"'); return false;";
    $("#deleteTeam").attr('onclick', js);
    
    $('#teamStats').show();
    $('#teamResults').show();
    $('#teamFixtures').show();
    var html = "";
    html += "<h4>Games Remaining: <b>"+gamesRemaining+"</b></h4>";
    html += "<h4>Avg Pts Per Game: <b>"+avgPointsPerGame+"</b></h4>";
    html += "<h4>Win Percentage: <b>"+winPerc+"</b></h4>"; 
    $('#stats').html(html);
    
    $('#latestResults').html(results);
    $('#latestFixtures').html(fixtures);
}